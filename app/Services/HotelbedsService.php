<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class HotelbedsService
{
    protected $apiKey;
    protected $secret;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.hotelbeds.api_key');
        $this->secret = config('services.hotelbeds.secret');
        $this->baseUrl = config('services.hotelbeds.base_url', 'https://api.hotelbeds.com');
    }

    /**
     * Génère la signature requise pour l'authentification Hotelbeds
     */
    protected function getSignature(): string
    {
        return hash('sha256', $this->apiKey . $this->secret . time());
    }

    /**
     * Recherche d'hôtels disponibles
     *
     * @param string $destination Code destination (ex: TUN, HAM, SOU)
     * @param string $checkIn Date check-in (YYYY-MM-DD)
     * @param string $checkOut Date check-out (YYYY-MM-DD)
     * @param int $adults Nombre d'adultes
     * @param int $children Nombre d'enfants
     * @param int $rooms Nombre de chambres
     * @return array
     */
    public function searchHotels(
        string $destination,
        string $checkIn,
        string $checkOut,
        int $adults,
        int $children = 0,
        int $rooms = 1
    ): array {
        $cacheKey = "hotels_search_" . md5(json_encode(func_get_args()));

        return Cache::remember($cacheKey, 900, function () use (
            $destination,
            $checkIn,
            $checkOut,
            $adults,
            $children,
            $rooms
        ) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders([
                        'Api-key' => $this->apiKey,
                        'X-Signature' => $this->getSignature(),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ])
                    ->post($this->baseUrl . '/hotel-api/1.0/hotels', [
                        'stay' => [
                            'checkIn' => $checkIn,
                            'checkOut' => $checkOut,
                        ],
                        'occupancies' => [
                            [
                                'rooms' => $rooms,
                                'adults' => $adults,
                                'children' => $children,
                            ]
                        ],
                        'destination' => [
                            'code' => $destination,
                        ],
                    ]);

                if ($response->successful()) {
                    Log::info('Hotelbeds search successful', [
                        'destination' => $destination,
                        'dates' => [$checkIn, $checkOut],
                    ]);
                    return $response->json();
                }

                Log::error('Hotelbeds search failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                throw new \Exception('Hotelbeds API Error: ' . $response->body());
            } catch (\Exception $e) {
                Log::error('Hotelbeds search exception', [
                    'message' => $e->getMessage(),
                    'destination' => $destination,
                ]);
                throw $e;
            }
        });
    }

    /**
     * Vérification des tarifs avant réservation
     *
     * @param string $rateKey Clé du tarif à vérifier
     * @return array
     */
    public function checkRates(string $rateKey): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-key' => $this->apiKey,
                    'X-Signature' => $this->getSignature(),
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/hotel-api/1.0/checkrates', [
                    'rooms' => [
                        [
                            'rateKey' => $rateKey,
                        ]
                    ]
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Rate check failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Hotelbeds rate check failed', [
                'message' => $e->getMessage(),
                'rateKey' => $rateKey,
            ]);
            throw $e;
        }
    }

    /**
     * Création de réservation
     *
     * @param string $rateKey Clé du tarif
     * @param array $holder Informations du client principal
     * @param array $rooms Informations des chambres et occupants
     * @param string $clientReference Référence interne
     * @return array
     */
    public function createBooking(
        string $rateKey,
        array $holder,
        array $rooms,
        string $clientReference
    ): array {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-key' => $this->apiKey,
                    'X-Signature' => $this->getSignature(),
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/hotel-api/1.0/bookings', [
                    'holder' => [
                        'name' => $holder['first_name'],
                        'surname' => $holder['last_name'],
                        'email' => $holder['email'],
                    ],
                    'rooms' => [
                        [
                            'rateKey' => $rateKey,
                            'paxes' => $rooms,
                        ]
                    ],
                    'clientReference' => $clientReference,
                ]);

            if ($response->successful()) {
                Log::info('Hotelbeds booking created', [
                    'reference' => $clientReference,
                    'response' => $response->json(),
                ]);
                return $response->json();
            }

            Log::error('Hotelbeds booking failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new \Exception('Booking creation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Hotelbeds booking exception', [
                'message' => $e->getMessage(),
                'reference' => $clientReference,
            ]);
            throw $e;
        }
    }

    /**
     * Récupération détails réservation
     *
     * @param string $bookingId ID de la réservation Hotelbeds
     * @return array
     */
    public function getBooking(string $bookingId): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-key' => $this->apiKey,
                    'X-Signature' => $this->getSignature(),
                ])
                ->get($this->baseUrl . '/hotel-api/1.0/bookings/' . $bookingId);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception('Get booking failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Hotelbeds get booking failed', [
                'message' => $e->getMessage(),
                'bookingId' => $bookingId,
            ]);
            throw $e;
        }
    }

    /**
     * Annulation réservation
     *
     * @param string $bookingId ID de la réservation Hotelbeds
     * @return array
     */
    public function cancelBooking(string $bookingId): array
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Api-key' => $this->apiKey,
                    'X-Signature' => $this->getSignature(),
                ])
                ->delete($this->baseUrl . '/hotel-api/1.0/bookings/' . $bookingId);

            if ($response->successful()) {
                Log::info('Hotelbeds booking cancelled', [
                    'bookingId' => $bookingId,
                ]);
                return $response->json();
            }

            throw new \Exception('Cancellation failed: ' . $response->body());
        } catch (\Exception $e) {
            Log::error('Hotelbeds cancellation failed', [
                'message' => $e->getMessage(),
                'bookingId' => $bookingId,
            ]);
            throw $e;
        }
    }

    /**
     * Recherche d'hôtels par ville (codes Tunisie)
     *
     * @return array
     */
    public static function getTunisiaDestinationCodes(): array
    {
        return [
            'HAM' => 'Hammamet',
            'SOU' => 'Sousse',
            'DJE' => 'Djerba',
            'TUN' => 'Tunis',
            'MAH' => 'Mahdia',
            'MON' => 'Monastir',
            'TOZ' => 'Tozeur',
            'TAB' => 'Tabarka',
        ];
    }
}

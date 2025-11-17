<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\HotelBooking;
use App\Services\HotelbedsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    protected $hotelbeds;

    public function __construct(HotelbedsService $hotelbeds)
    {
        $this->hotelbeds = $hotelbeds;
    }

    /**
     * Affiche le formulaire de recherche d'hôtels
     */
    public function index()
    {
        $destinations = $this->hotelbeds->getTunisiaDestinationCodes();

        return view('hotels.index', compact('destinations'));
    }

    /**
     * Recherche d'hôtels via l'API Hotelbeds
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'check_in' => 'required|date|after:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:9',
            'children' => 'nullable|integer|min:0|max:9',
            'rooms' => 'nullable|integer|min:1|max:5',
        ]);

        try {
            $results = $this->hotelbeds->searchHotels(
                $validated['destination'],
                $validated['check_in'],
                $validated['check_out'],
                $validated['adults'],
                $validated['children'] ?? 0,
                $validated['rooms'] ?? 1
            );

            $hotels = $results['hotels']['hotels'] ?? [];
            $total = $results['hotels']['total'] ?? 0;

            return view('hotels.results', compact('hotels', 'total', 'validated'));

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la recherche: ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un hôtel
     */
    public function show($id)
    {
        $hotel = Hotel::with(['reviews' => function($query) {
            $query->published()->recent();
        }])->findOrFail($id);

        return view('hotels.show', compact('hotel'));
    }

    /**
     * Formulaire de réservation
     */
    public function bookingForm(Request $request)
    {
        $rateKey = $request->input('rate_key');
        $hotelData = $request->session()->get('hotel_booking_data');

        if (!$rateKey || !$hotelData) {
            return redirect()->route('hotels.index')
                ->with('error', 'Session expirée. Veuillez recommencer votre recherche.');
        }

        return view('hotels.booking', compact('hotelData', 'rateKey'));
    }

    /**
     * Création de la réservation
     */
    public function book(Request $request)
    {
        $validated = $request->validate([
            'rate_key' => 'required|string',
            'guest_first_name' => 'required|string|max:255',
            'guest_last_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'special_requests' => 'nullable|string|max:1000',
        ]);

        try {
            // Vérifier les tarifs avant de réserver
            $rates = $this->hotelbeds->checkRates($validated['rate_key']);

            // Créer la réservation via Hotelbeds
            $bookingReference = HotelBooking::generateReference();

            $holder = [
                'first_name' => $validated['guest_first_name'],
                'last_name' => $validated['guest_last_name'],
                'email' => $validated['guest_email'],
            ];

            $apiBooking = $this->hotelbeds->createBooking(
                $validated['rate_key'],
                $holder,
                [], // Paxes/rooms data
                $bookingReference
            );

            // Enregistrer dans la base de données locale
            $booking = HotelBooking::create([
                'booking_reference' => $bookingReference,
                'user_id' => Auth::id(),
                'guest_first_name' => $validated['guest_first_name'],
                'guest_last_name' => $validated['guest_last_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
                'api_booking_id' => $apiBooking['booking']['reference'] ?? null,
                'api_response' => $apiBooking,
                'special_requests' => $validated['special_requests'],
                'status' => 'confirmed',
                // ... autres champs depuis l'API
            ]);

            // Ajouter des points de fidélité
            if (Auth::check()) {
                Auth::user()->addLoyaltyPoints((int) $booking->total_price);
            }

            // Envoyer l'email de confirmation
            \Mail::to($validated['guest_email'])->send(
                new \App\Mail\BookingConfirmation($booking, 'hotel')
            );

            return redirect()->route('payment.initiate')
                ->with('booking_id', $booking->id)
                ->with('booking_type', 'hotel_booking')
                ->with('success', 'Réservation créée ! Procédez au paiement.');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la réservation: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    private $apiKey;
    private $baseCurrency = 'TND';
    private $apiUrl = 'https://v6.exchangerate-api.com/v6';

    // Devises supportées
    private $supportedCurrencies = [
        'TND' => ['symbol' => 'TND', 'name' => 'Dinar Tunisien', 'flag' => '🇹🇳'],
        'EUR' => ['symbol' => '€', 'name' => 'Euro', 'flag' => '🇪🇺'],
        'USD' => ['symbol' => '$', 'name' => 'Dollar US', 'flag' => '🇺🇸'],
        'GBP' => ['symbol' => '£', 'name' => 'Livre Sterling', 'flag' => '🇬🇧'],
        'SAR' => ['symbol' => 'SAR', 'name' => 'Riyal Saoudien', 'flag' => '🇸🇦'],
        'AED' => ['symbol' => 'AED', 'name' => 'Dirham Émirati', 'flag' => '🇦🇪'],
    ];

    public function __construct()
    {
        $this->apiKey = config('services.exchangerate.key', 'demo-key');
    }

    /**
     * Get exchange rates from API (cached for 1 hour)
     */
    public function getRates()
    {
        return Cache::remember('exchange_rates_tnd', 3600, function() {
            try {
                $response = Http::get("{$this->apiUrl}/{$this->apiKey}/latest/{$this->baseCurrency}");
                
                if ($response->successful() && $response->json('result') === 'success') {
                    return $response->json('conversion_rates');
                }
            } catch (\Exception $e) {
                \Log::error('Currency API Error: ' . $e->getMessage());
            }

            // Fallback rates si l'API échoue
            return $this->getFallbackRates();
        });
    }

    /**
     * Fallback rates (approximatifs) si API indisponible
     */
    private function getFallbackRates()
    {
        return [
            'TND' => 1,
            'EUR' => 0.31,
            'USD' => 0.32,
            'GBP' => 0.25,
            'SAR' => 1.21,
            'AED' => 1.18,
        ];
    }

    /**
     * Convert amount from TND to another currency
     */
    public function convert(float $amount, string $toCurrency): float
    {
        if ($toCurrency === $this->baseCurrency) {
            return $amount;
        }

        $rates = $this->getRates();
        
        if (!isset($rates[$toCurrency])) {
            return $amount; // Return original if currency not found
        }

        return round($amount * $rates[$toCurrency], 2);
    }

    /**
     * Format price with currency symbol
     */
    public function formatPrice(float $amount, string $currency = 'TND'): string
    {
        $converted = $this->convert($amount, $currency);
        $currencyData = $this->supportedCurrencies[$currency] ?? ['symbol' => $currency];

        return $currencyData['symbol'] . ' ' . number_format($converted, 2, '.', ',');
    }

    /**
     * Get all supported currencies
     */
    public function getSupportedCurrencies(): array
    {
        return $this->supportedCurrencies;
    }

    /**
     * Get current user's preferred currency from session
     */
    public function getUserCurrency(): string
    {
        return session('currency', $this->baseCurrency);
    }

    /**
     * Set user's preferred currency
     */
    public function setUserCurrency(string $currency): void
    {
        if (isset($this->supportedCurrencies[$currency])) {
            session(['currency' => $currency]);
        }
    }
}

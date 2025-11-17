<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * Switch user's preferred currency
     */
    public function switch(Request $request)
    {
        $validated = $request->validate([
            'currency' => 'required|string|in:TND,EUR,USD,GBP,SAR,AED',
        ]);

        $this->currencyService->setUserCurrency($validated['currency']);

        return response()->json([
            'success' => true,
            'message' => 'Devise changée avec succès',
            'currency' => $validated['currency']
        ]);
    }
}

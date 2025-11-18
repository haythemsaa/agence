<?php

namespace App\Http\Controllers;

use App\Models\GiftVoucher;
use Illuminate\Http\Request;

class GiftVoucherController extends Controller
{
    /**
     * Show gift voucher purchase page
     */
    public function index()
    {
        $presetAmounts = [100, 200, 500, 1000, 2000, 5000]; // in TND
        return view('gift-vouchers.index', compact('presetAmounts'));
    }

    /**
     * Purchase a gift voucher
     */
    public function purchase(Request $request)
    {
        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:50|max:10000',
            'personal_message' => 'nullable|string|max:500',
            'validity_months' => 'required|integer|in:6,12,24',
        ]);

        $voucher = GiftVoucher::create([
            'code' => GiftVoucher::generateCode(),
            'purchaser_id' => auth()->id(),
            'purchaser_name' => auth()->user()->name,
            'purchaser_email' => auth()->user()->email,
            'recipient_name' => $validated['recipient_name'],
            'recipient_email' => $validated['recipient_email'],
            'personal_message' => $validated['personal_message'] ?? null,
            'amount' => $validated['amount'],
            'remaining_balance' => $validated['amount'],
            'currency' => 'TND',
            'status' => 'active',
            'valid_until' => now()->addMonths($validated['validity_months']),
        ]);

        // TODO: Send email to recipient with voucher code

        return redirect()->route('gift-vouchers.show', $voucher->code)
            ->with('success', 'Chèque cadeau créé avec succès!');
    }

    /**
     * Show voucher details
     */
    public function show(string $code)
    {
        $voucher = GiftVoucher::where('code', $code)->firstOrFail();

        // Only allow purchaser or recipient to view
        if (auth()->check() &&
            auth()->id() !== $voucher->purchaser_id &&
            auth()->user()->email !== $voucher->recipient_email) {
            abort(403, 'Vous n\'êtes pas autorisé à voir ce chèque cadeau.');
        }

        return view('gift-vouchers.show', compact('voucher'));
    }

    /**
     * Check voucher validity
     */
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $voucher = GiftVoucher::where('code', $request->code)->first();

        if (!$voucher) {
            return response()->json([
                'valid' => false,
                'message' => 'Code de chèque cadeau invalide',
            ], 404);
        }

        return response()->json([
            'valid' => $voucher->isValid(),
            'balance' => $voucher->remaining_balance,
            'currency' => $voucher->currency,
            'expires_at' => $voucher->valid_until->format('d/m/Y'),
            'message' => $voucher->isValid()
                ? 'Chèque cadeau valide'
                : 'Chèque cadeau expiré ou déjà utilisé',
        ]);
    }
}

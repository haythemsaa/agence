<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\HotelBooking;
use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    /**
     * Initiate payment for a booking
     */
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'booking_type' => 'required|in:hotel_booking,package_booking',
            'booking_id' => 'required|integer',
            'payment_method' => 'required|in:stripe,paypal,flouci,bank_transfer,cash',
            'amount' => 'required|numeric|min:0',
        ]);

        // Get the booking
        $booking = $this->getBooking($validated['booking_type'], $validated['booking_id']);
        
        if (!$booking) {
            return back()->with('error', 'Réservation introuvable.');
        }

        // Create payment record
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'booking_type' => $validated['booking_type'],
            'booking_id' => $validated['booking_id'],
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'currency' => 'TND',
            'status' => 'pending',
        ]);

        // Redirect based on payment method
        switch ($validated['payment_method']) {
            case 'stripe':
                return $this->initiateStripePayment($payment, $booking);
            
            case 'paypal':
                return $this->initiatePayPalPayment($payment, $booking);
            
            case 'flouci':
                return $this->initiateFlouciPayment($payment, $booking);
            
            case 'bank_transfer':
                return $this->initiateBankTransfer($payment, $booking);
            
            case 'cash':
                return $this->initiateCashPayment($payment, $booking);
            
            default:
                return back()->with('error', 'Méthode de paiement non supportée.');
        }
    }

    /**
     * Initiate Stripe payment
     */
    protected function initiateStripePayment(Payment $payment, $booking)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'tnd',
                        'product_data' => [
                            'name' => $this->getBookingDescription($booking),
                        ],
                        'unit_amount' => $payment->amount * 100, // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['payment' => $payment->id]),
                'cancel_url' => route('payment.cancel', ['payment' => $payment->id]),
                'metadata' => [
                    'payment_id' => $payment->id,
                ],
            ]);

            $payment->update([
                'transaction_id' => $session->id,
                'status' => 'processing',
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement: ' . $e->getMessage());
        }
    }

    /**
     * Initiate PayPal payment
     */
    protected function initiatePayPalPayment(Payment $payment, $booking)
    {
        // PayPal integration would go here
        // For now, redirect to a placeholder
        return view('payments.paypal', compact('payment', 'booking'));
    }

    /**
     * Initiate Flouci payment (Tunisian mobile payment)
     */
    protected function initiateFlouciPayment(Payment $payment, $booking)
    {
        // Flouci integration would go here
        return view('payments.flouci', compact('payment', 'booking'));
    }

    /**
     * Initiate bank transfer
     */
    protected function initiateBankTransfer(Payment $payment, $booking)
    {
        $payment->update(['status' => 'pending']);
        
        return view('payments.bank-transfer', compact('payment', 'booking'));
    }

    /**
     * Initiate cash payment
     */
    protected function initiateCashPayment(Payment $payment, $booking)
    {
        $payment->update(['status' => 'pending']);
        
        return view('payments.cash', compact('payment', 'booking'));
    }

    /**
     * Handle successful payment
     */
    public function success(Payment $payment)
    {
        if ($payment->status !== 'completed') {
            DB::transaction(function () use ($payment) {
                $payment->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                ]);

                // Update booking
                $booking = $this->getBooking($payment->booking_type, $payment->booking_id);
                
                if ($booking instanceof PackageBooking) {
                    $booking->recordPayment($payment->amount);
                } elseif ($booking instanceof HotelBooking) {
                    $booking->update(['status' => 'confirmed']);
                }

                // Add loyalty points
                if (auth()->check()) {
                    auth()->user()->addLoyaltyPoints((int) $payment->amount);
                }
            });
        }

        return view('payments.success', compact('payment'));
    }

    /**
     * Handle cancelled payment
     */
    public function cancel(Payment $payment)
    {
        $payment->update(['status' => 'cancelled']);
        
        return view('payments.cancel', compact('payment'));
    }

    /**
     * Webhook handler for Stripe
     */
    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        // Handle the event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;
            $paymentId = $session->metadata->payment_id ?? null;
            
            if ($paymentId) {
                $payment = Payment::find($paymentId);
                if ($payment && $payment->status !== 'completed') {
                    $payment->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                    ]);

                    // Update booking status
                    $booking = $this->getBooking($payment->booking_type, $payment->booking_id);
                    if ($booking instanceof PackageBooking) {
                        $booking->recordPayment($payment->amount);
                    } elseif ($booking instanceof HotelBooking) {
                        $booking->update(['status' => 'confirmed']);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Get booking instance
     */
    protected function getBooking(string $type, int $id)
    {
        return $type === 'hotel_booking' 
            ? HotelBooking::find($id) 
            : PackageBooking::find($id);
    }

    /**
     * Get booking description
     */
    protected function getBookingDescription($booking): string
    {
        if ($booking instanceof HotelBooking) {
            return "Réservation Hôtel - {$booking->hotel_name}";
        } elseif ($booking instanceof PackageBooking) {
            return "Voyage Organisé - {$booking->package->title}";
        }
        
        return "Réservation";
    }
}

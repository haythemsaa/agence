<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;

class VoucherService
{
    /**
     * Generate voucher PDF for hotel booking
     */
    public function generateHotelVoucher($booking)
    {
        $data = [
            'booking' => $booking,
            'type' => 'hotel',
            'generated_at' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.voucher', $data);
        
        return $pdf->download("voucher-{$booking->booking_reference}.pdf");
    }

    /**
     * Generate voucher PDF for package booking
     */
    public function generatePackageVoucher($booking)
    {
        $data = [
            'booking' => $booking,
            'type' => 'package',
            'generated_at' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.voucher', $data);
        
        return $pdf->download("voucher-{$booking->booking_reference}.pdf");
    }

    /**
     * Generate invoice PDF
     */
    public function generateInvoice($payment)
    {
        $booking = $payment->booking_type === 'hotel_booking' 
            ? $payment->hotelBooking 
            : $payment->packageBooking;

        $data = [
            'payment' => $payment,
            'booking' => $booking,
            'generated_at' => now(),
        ];

        $pdf = Pdf::loadView('pdfs.invoice', $data);
        
        return $pdf->download("facture-{$payment->id}.pdf");
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use App\Models\PackageBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Get user's bookings
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $hotelBookings = $user->hotelBookings()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'type' => 'hotel',
                    'reference' => $booking->booking_reference,
                    'name' => $booking->hotel_name,
                    'destination' => $booking->city . ', ' . $booking->country,
                    'check_in' => $booking->check_in,
                    'check_out' => $booking->check_out,
                    'total_price' => $booking->total_price,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                ];
            });

        $packageBookings = $user->packageBookings()
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'type' => 'package',
                    'reference' => $booking->booking_reference,
                    'name' => $booking->package->title,
                    'destination' => $booking->package->destination,
                    'departure_date' => $booking->departure_date,
                    'total_price' => $booking->total_price,
                    'paid_amount' => $booking->paid_amount,
                    'remaining_amount' => $booking->remaining_amount,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                ];
            });

        $bookings = $hotelBookings->concat($packageBookings)
            ->sortByDesc('created_at')
            ->values();

        return response()->json([
            'success' => true,
            'data' => $bookings
        ]);
    }

    /**
     * Get booking details
     */
    public function show(Request $request, $type, $id)
    {
        $user = $request->user();

        if ($type === 'hotel') {
            $booking = HotelBooking::where('user_id', $user->id)
                ->findOrFail($id);
        } else {
            $booking = PackageBooking::where('user_id', $user->id)
                ->with('package')
                ->findOrFail($id);
        }

        return response()->json([
            'success' => true,
            'data' => $booking
        ]);
    }

    /**
     * Cancel a booking
     */
    public function cancel(Request $request, $type, $id)
    {
        $user = $request->user();

        if ($type === 'hotel') {
            $booking = HotelBooking::where('user_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->findOrFail($id);
        } else {
            $booking = PackageBooking::where('user_id', $user->id)
                ->where('status', '!=', 'cancelled')
                ->findOrFail($id);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Réservation annulée avec succès'
        ]);
    }
}

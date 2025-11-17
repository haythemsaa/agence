<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelBooking;
use Illuminate\Http\Request;

class HotelBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = HotelBooking::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.hotel-bookings.index', compact('bookings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(HotelBooking $hotelBooking)
    {
        $booking = $hotelBooking;
        $booking->load('user');
        return view('admin.hotel-bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HotelBooking $hotelBooking)
    {
        $booking = $hotelBooking;
        return view('admin.hotel-bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HotelBooking $hotelBooking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'total_price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $hotelBooking->update($validated);

        return redirect()->route('admin.hotel-bookings.index')
            ->with('success', 'Réservation mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HotelBooking $hotelBooking)
    {
        $hotelBooking->delete();

        return redirect()->route('admin.hotel-bookings.index')
            ->with('success', 'Réservation supprimée avec succès!');
    }
}

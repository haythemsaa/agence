<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PackageBooking;
use Illuminate\Http\Request;

class PackageBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = PackageBooking::with(['user', 'package'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.package-bookings.index', compact('bookings'));
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageBooking $packageBooking)
    {
        $booking = $packageBooking;
        $booking->load(['user', 'package']);
        return view('admin.package-bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageBooking $packageBooking)
    {
        $booking = $packageBooking;
        return view('admin.package-bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PackageBooking $packageBooking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'total_price' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        // Calculer le montant restant
        if (isset($validated['paid_amount'])) {
            $validated['remaining_amount'] = $validated['total_price'] - $validated['paid_amount'];
        }

        $packageBooking->update($validated);

        return redirect()->route('admin.package-bookings.index')
            ->with('success', 'Réservation mise à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageBooking $packageBooking)
    {
        $packageBooking->delete();

        return redirect()->route('admin.package-bookings.index')
            ->with('success', 'Réservation supprimée avec succès!');
    }
}

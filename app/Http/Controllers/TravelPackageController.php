<?php

namespace App\Http\Controllers;

use App\Models\TravelPackage;
use App\Models\PackageBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelPackageController extends Controller
{
    /**
     * Liste tous les packages
     */
    public function index(Request $request)
    {
        $query = TravelPackage::active()->with('reviews');

        // Filtrer par type
        if ($request->has('type')) {
            $query->byType($request->type);
        }

        // Recherche par mot-clé
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $packages = $query->paginate(12);
        $types = ['circuit', 'sejour', 'omra', 'international'];

        return view('packages.index', compact('packages', 'types'));
    }

    /**
     * Affiche les détails d'un package
     */
    public function show($slug)
    {
        $package = TravelPackage::where('slug', $slug)
            ->with(['reviews' => function($query) {
                $query->published()->recent();
            }])
            ->firstOrFail();

        // Dates de départ disponibles
        $departureDates = $package->departure_dates ?? [];

        return view('packages.show', compact('package', 'departureDates'));
    }

    /**
     * Formulaire de réservation de package
     */
    public function bookingForm($slug)
    {
        $package = TravelPackage::where('slug', $slug)->firstOrFail();

        return view('packages.booking', compact('package'));
    }

    /**
     * Création de la réservation de package
     */
    public function book(Request $request, $slug)
    {
        $package = TravelPackage::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'departure_date' => 'required|date|after:today',
            'nb_adults' => 'required|integer|min:1',
            'nb_children' => 'nullable|integer|min:0',
            'contact_first_name' => 'required|string|max:255',
            'contact_last_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'participants' => 'required|array',
        ]);

        // Vérifier disponibilité
        if (!$package->isAvailableForDate($validated['departure_date'])) {
            return back()->with('error', 'Plus de places disponibles pour cette date.');
        }

        // Calculer le prix total
        $adultsPrice = $package->price_adult * $validated['nb_adults'];
        $childrenPrice = $package->price_child * ($validated['nb_children'] ?? 0);
        $totalPrice = $adultsPrice + $childrenPrice;

        // Créer la réservation
        $booking = PackageBooking::create([
            'booking_reference' => PackageBooking::generateReference(),
            'user_id' => Auth::id(),
            'travel_package_id' => $package->id,
            'departure_date' => $validated['departure_date'],
            'nb_adults' => $validated['nb_adults'],
            'nb_children' => $validated['nb_children'] ?? 0,
            'participants' => $validated['participants'],
            'contact_first_name' => $validated['contact_first_name'],
            'contact_last_name' => $validated['contact_last_name'],
            'contact_email' => $validated['contact_email'],
            'contact_phone' => $validated['contact_phone'],
            'adults_price' => $adultsPrice,
            'children_price' => $childrenPrice,
            'total_price' => $totalPrice,
            'remaining_amount' => $totalPrice,
            'status' => 'pending',
        ]);

        // Ajouter des points de fidélité
        if (Auth::check()) {
            Auth::user()->addLoyaltyPoints((int) $totalPrice);
        }

        return redirect()->route('booking.confirmation', $booking->id)
            ->with('success', 'Réservation enregistrée !');
    }
}

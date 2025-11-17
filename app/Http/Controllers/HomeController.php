<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\TravelPackage;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function index()
    {
        // Hôtels en vedette
        $featuredHotels = Hotel::featured()
            ->active()
            ->with('reviews')
            ->take(8)
            ->get();

        // Circuits/Packages en vedette
        $featuredPackages = TravelPackage::featured()
            ->active()
            ->with('reviews')
            ->take(6)
            ->get();

        // Derniers avis
        $recentReviews = Review::published()
            ->verified()
            ->with(['user', 'reviewable'])
            ->recent()
            ->take(10)
            ->get();

        // Destinations populaires (Tunisie)
        $destinations = [
            ['code' => 'HAM', 'name' => 'Hammamet', 'image' => '/images/destinations/hammamet.jpg'],
            ['code' => 'SOU', 'name' => 'Sousse', 'image' => '/images/destinations/sousse.jpg'],
            ['code' => 'DJE', 'name' => 'Djerba', 'image' => '/images/destinations/djerba.jpg'],
            ['code' => 'TUN', 'name' => 'Tunis', 'image' => '/images/destinations/tunis.jpg'],
            ['code' => 'MAH', 'name' => 'Mahdia', 'image' => '/images/destinations/mahdia.jpg'],
            ['code' => 'MON', 'name' => 'Monastir', 'image' => '/images/destinations/monastir.jpg'],
            ['code' => 'TOZ', 'name' => 'Tozeur', 'image' => '/images/destinations/tozeur.jpg'],
            ['code' => 'TAB', 'name' => 'Tabarka', 'image' => '/images/destinations/tabarka.jpg'],
        ];

        return view('home', compact(
            'featuredHotels',
            'featuredPackages',
            'recentReviews',
            'destinations'
        ));
    }

    /**
     * Recherche rapide depuis la page d'accueil
     */
    public function search(Request $request)
    {
        $type = $request->input('type', 'hotels'); // hotels ou packages

        if ($type === 'hotels') {
            return redirect()->route('hotels.search', $request->all());
        }

        return redirect()->route('packages.index', $request->all());
    }
}

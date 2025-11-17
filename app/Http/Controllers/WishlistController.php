<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Hotel;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('wishlistable')
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlists'));
    }

    /**
     * Add item to wishlist
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:hotel,package',
            'id' => 'required|integer',
        ]);

        $type = $validated['type'] === 'hotel' ? Hotel::class : TravelPackage::class;

        $wishlist = Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'wishlistable_type' => $type,
            'wishlistable_id' => $validated['id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Ajouté aux favoris',
            'wishlist_id' => $wishlist->id,
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function destroy(Wishlist $wishlist)
    {
        // S'assurer que l'item appartient à l'utilisateur
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Retiré des favoris',
            ]);
        }

        return redirect()->route('wishlist.index')
            ->with('success', 'Article retiré de vos favoris');
    }

    /**
     * Check if item is in wishlist (AJAX)
     */
    public function check(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:hotel,package',
            'id' => 'required|integer',
        ]);

        $type = $validated['type'] === 'hotel' ? Hotel::class : TravelPackage::class;

        $exists = Wishlist::where('user_id', auth()->id())
            ->where('wishlistable_type', $type)
            ->where('wishlistable_id', $validated['id'])
            ->exists();

        return response()->json(['in_wishlist' => $exists]);
    }
}

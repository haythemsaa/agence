<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TravelPackage;
use Illuminate\Http\Request;

class TravelPackageController extends Controller
{
    /**
     * Get list of packages
     */
    public function index(Request $request)
    {
        $packages = TravelPackage::where('is_active', true);

        if ($request->has('type')) {
            $packages->where('type', $request->type);
        }

        if ($request->has('destination')) {
            $packages->where('destination', 'like', '%' . $request->destination . '%');
        }

        if ($request->has('max_price')) {
            $packages->where('price_adult', '<=', $request->max_price);
        }

        $packages = $packages->withCount('bookings')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    /**
     * Get package details
     */
    public function show($slug)
    {
        $package = TravelPackage::where('slug', $slug)
            ->where('is_active', true)
            ->with('reviews')
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $package
        ]);
    }

    /**
     * Get featured packages
     */
    public function featured()
    {
        $packages = TravelPackage::where('is_active', true)
            ->where('featured', true)
            ->take(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Services\HotelbedsService;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    protected $hotelbedsService;

    public function __construct(HotelbedsService $hotelbedsService)
    {
        $this->hotelbedsService = $hotelbedsService;
    }

    /**
     * Get list of hotels
     */
    public function index(Request $request)
    {
        $hotels = Hotel::query();

        if ($request->has('destination')) {
            $hotels->where('city', 'like', '%' . $request->destination . '%')
                   ->orWhere('country', 'like', '%' . $request->destination . '%');
        }

        if ($request->has('min_rating')) {
            $hotels->where('rating', '>=', $request->min_rating);
        }

        $hotels = $hotels->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $hotels
        ]);
    }

    /**
     * Search hotels via Hotelbeds API
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'destination' => 'required|string',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1|max:10',
            'children' => 'nullable|integer|min:0|max:10',
        ]);

        try {
            $results = $this->hotelbedsService->searchHotels(
                $validated['destination'],
                $validated['check_in'],
                $validated['check_out'],
                $validated['adults'],
                $validated['children'] ?? 0
            );

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la recherche: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get hotel details
     */
    public function show($id)
    {
        $hotel = Hotel::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $hotel
        ]);
    }
}

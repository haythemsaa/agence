<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TravelPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = TravelPackage::withSum('bookings', 'nb_adults')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:circuit,sejour,omra,international',
            'destination' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'price_adult' => 'required|numeric|min:0',
            'price_child' => 'nullable|numeric|min:0',
            'min_participants' => 'nullable|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'departure_city' => 'required|string|max:255',
            'description' => 'required|string',
            'program' => 'nullable|string',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'available_dates' => 'nullable|string',
            'images' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Génération du slug
        $validated['slug'] = Str::slug($validated['title']);

        // Conversion des champs texte en tableaux/JSON
        if (isset($validated['program'])) {
            $validated['program'] = json_decode($validated['program'], true) ?? [];
        }

        if (isset($validated['included'])) {
            $validated['included'] = array_filter(explode("\n", $validated['included']));
        }

        if (isset($validated['not_included'])) {
            $validated['not_included'] = array_filter(explode("\n", $validated['not_included']));
        }

        if (isset($validated['available_dates'])) {
            $validated['available_dates'] = array_filter(explode("\n", $validated['available_dates']));
        }

        if (isset($validated['images'])) {
            $validated['images'] = array_filter(explode("\n", $validated['images']));
        }

        $validated['is_active'] = $request->has('is_active');

        TravelPackage::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Voyage créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelPackage $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelPackage $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelPackage $package)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:circuit,sejour,omra,international',
            'destination' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'duration_nights' => 'required|integer|min:0',
            'price_adult' => 'required|numeric|min:0',
            'price_child' => 'nullable|numeric|min:0',
            'min_participants' => 'nullable|integer|min:1',
            'max_participants' => 'required|integer|min:1',
            'departure_city' => 'required|string|max:255',
            'description' => 'required|string',
            'program' => 'nullable|string',
            'included' => 'nullable|string',
            'not_included' => 'nullable|string',
            'available_dates' => 'nullable|string',
            'images' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Mise à jour du slug si le titre change
        if ($validated['title'] !== $package->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Conversion des champs texte en tableaux/JSON
        if (isset($validated['program'])) {
            $validated['program'] = json_decode($validated['program'], true) ?? [];
        }

        if (isset($validated['included'])) {
            $validated['included'] = array_filter(explode("\n", $validated['included']));
        }

        if (isset($validated['not_included'])) {
            $validated['not_included'] = array_filter(explode("\n", $validated['not_included']));
        }

        if (isset($validated['available_dates'])) {
            $validated['available_dates'] = array_filter(explode("\n", $validated['available_dates']));
        }

        if (isset($validated['images'])) {
            $validated['images'] = array_filter(explode("\n", $validated['images']));
        }

        $validated['is_active'] = $request->has('is_active');

        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Voyage mis à jour avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelPackage $package)
    {
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Voyage supprimé avec succès!');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'reviewable'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'admin_response' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis mis à jour avec succès!');
    }

    /**
     * Publish a review
     */
    public function publish(Review $review)
    {
        $review->update(['is_published' => true]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis publié avec succès!');
    }

    /**
     * Add admin response to a review
     */
    public function respond(Request $request, Review $review)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string',
        ]);

        $review->update($validated);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Réponse ajoutée avec succès!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Avis supprimé avec succès!');
    }
}

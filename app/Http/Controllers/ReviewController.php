<?php

namespace App\Http\Controllers;

use App\Models\Bean;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request, Bean $bean): RedirectResponse
    {
        // Check if user already reviewed this bean
        $existingReview = Review::where('user_id', Auth::id())
            ->where('bean_id', $bean->id)
            ->first();

        if ($existingReview) {
            return redirect()
                ->back()
                ->with('error', 'You have already reviewed this bean. Please edit your existing review instead.');
        }

        $validated = $request->validate([
            'rating_overall' => 'required|numeric|min:0|max:10',
            'rating_aroma' => 'nullable|numeric|min:0|max:10',
            'rating_acidity' => 'nullable|numeric|min:0|max:10',
            'rating_body' => 'nullable|numeric|min:0|max:10',
            'rating_flavor' => 'nullable|numeric|min:0|max:10',
            'rating_aftertaste' => 'nullable|numeric|min:0|max:10',
            'brewing_method' => 'nullable|string|max:255',
            'review_text' => 'nullable|string|max:5000',
            'would_buy_again' => 'nullable|boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['bean_id'] = $bean->id;
        $validated['helpful_count'] = 0;

        $review = Review::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $review->images()->create([
                    'image_url' => $path,
                ]);
            }
        }

        return redirect()
            ->route('beans.show', $bean)
            ->with('success', 'Review posted successfully!');
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review): RedirectResponse
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating_overall' => 'required|numeric|min:0|max:10',
            'rating_aroma' => 'nullable|numeric|min:0|max:10',
            'rating_acidity' => 'nullable|numeric|min:0|max:10',
            'rating_body' => 'nullable|numeric|min:0|max:10',
            'rating_flavor' => 'nullable|numeric|min:0|max:10',
            'rating_aftertaste' => 'nullable|numeric|min:0|max:10',
            'brewing_method' => 'nullable|string|max:255',
            'review_text' => 'nullable|string|max:5000',
            'would_buy_again' => 'nullable|boolean',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'exists:review_images,id',
        ]);

        $review->update($validated);

        // Handle image removals
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $imageId) {
                $image = $review->images()->find($imageId);
                if ($image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('review-images', 'public');
                $review->images()->create([
                    'image_url' => $path,
                ]);
            }
        }

        return redirect()
            ->route('beans.show', $review->bean)
            ->with('success', 'Review updated successfully!');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $this->authorize('delete', $review);

        $bean = $review->bean;

        // Delete associated images
        foreach ($review->images as $image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        }

        $review->delete();

        return redirect()
            ->route('beans.show', $bean)
            ->with('success', 'Review deleted successfully!');
    }
}

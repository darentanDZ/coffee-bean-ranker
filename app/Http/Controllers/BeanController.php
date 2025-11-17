<?php

namespace App\Http\Controllers;

use App\Models\Bean;
use App\Models\FlavorTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BeanController extends Controller
{
    /**
     * Display a listing of beans
     */
    public function index(Request $request)
    {
        $query = Bean::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('roaster', 'like', "%{$search}%")
                  ->orWhere('origin_country', 'like', "%{$search}%");
            });
        }

        // Origin filter
        if ($request->filled('origin')) {
            $query->where('origin_country', $request->origin);
        }

        // Roast level filter
        if ($request->filled('roast_level')) {
            $query->where('roast_level', $request->roast_level);
        }

        // Processing method filter
        if ($request->filled('processing')) {
            $query->where('processing_method', $request->processing);
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'rating':
                $query->withAvg('reviews', 'rating_overall')
                    ->orderByDesc('reviews_avg_rating_overall');
                break;
            case 'popular':
                $query->withCount('reviews')->orderByDesc('reviews_count');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            default:
                $query->latest();
        }

        $beans = $query->paginate(12);

        // Get filter options
        $origins = Bean::distinct()->pluck('origin_country')->filter()->sort();
        $roast_levels = ['light', 'medium', 'medium-dark', 'dark'];
        $processing_methods = ['washed', 'natural', 'honey', 'experimental'];

        return view('beans.index', compact('beans', 'origins', 'roast_levels', 'processing_methods'));
    }

    /**
     * Show the form for creating a new bean
     */
    public function create()
    {
        $roast_levels = ['light', 'medium', 'medium-dark', 'dark'];
        $processing_methods = ['washed', 'natural', 'honey', 'experimental'];
        $flavor_tags = FlavorTag::all();

        return view('beans.create', compact('roast_levels', 'processing_methods', 'flavor_tags'));
    }

    /**
     * Store a newly created bean
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roaster' => 'required|string|max:255',
            'origin_country' => 'nullable|string|max:255',
            'origin_region' => 'nullable|string|max:255',
            'farm' => 'nullable|string|max:255',
            'altitude' => 'nullable|integer|min:0',
            'roast_level' => 'nullable|in:light,medium,medium-dark,dark',
            'processing_method' => 'nullable|in:washed,natural,honey,experimental',
            'varietal' => 'nullable|string|max:255',
            'harvest_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'bag_size_grams' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'flavor_tags' => 'nullable|array',
        ]);

        $validated['created_by_user_id'] = Auth::id();

        $bean = Bean::create($validated);

        // Attach flavor tags
        if ($request->filled('flavor_tags')) {
            $bean->flavorTags()->sync($request->flavor_tags);
        }

        return redirect()
            ->route('beans.show', $bean)
            ->with('success', 'Bean added successfully!');
    }

    /**
     * Display the specified bean
     */
    public function show(Bean $bean)
    {
        $bean->load(['creator', 'reviews.user', 'reviews.images', 'flavorTags']);

        // Get average ratings
        $averageRatings = [
            'overall' => $bean->reviews()->avg('rating_overall') ?? 0,
            'aroma' => $bean->reviews()->avg('rating_aroma') ?? 0,
            'acidity' => $bean->reviews()->avg('rating_acidity') ?? 0,
            'body' => $bean->reviews()->avg('rating_body') ?? 0,
            'flavor' => $bean->reviews()->avg('rating_flavor') ?? 0,
            'aftertaste' => $bean->reviews()->avg('rating_aftertaste') ?? 0,
        ];

        // Get similar beans
        $similar_beans = Bean::where('id', '!=', $bean->id)
            ->where(function ($query) use ($bean) {
                $query->where('origin_country', $bean->origin_country)
                    ->orWhere('roast_level', $bean->roast_level)
                    ->orWhere('roaster', $bean->roaster);
            })
            ->limit(4)
            ->get();

        return view('beans.show', compact('bean', 'averageRatings', 'similar_beans'));
    }

    /**
     * Show the form for editing the bean
     */
    public function edit(Bean $bean)
    {
        $this->authorize('update', $bean);

        $roast_levels = ['light', 'medium', 'medium-dark', 'dark'];
        $processing_methods = ['washed', 'natural', 'honey', 'experimental'];
        $flavor_tags = FlavorTag::all();

        return view('beans.edit', compact('bean', 'roast_levels', 'processing_methods', 'flavor_tags'));
    }

    /**
     * Update the bean
     */
    public function update(Request $request, Bean $bean)
    {
        $this->authorize('update', $bean);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'roaster' => 'required|string|max:255',
            'origin_country' => 'nullable|string|max:255',
            'origin_region' => 'nullable|string|max:255',
            'farm' => 'nullable|string|max:255',
            'altitude' => 'nullable|integer|min:0',
            'roast_level' => 'nullable|in:light,medium,medium-dark,dark',
            'processing_method' => 'nullable|in:washed,natural,honey,experimental',
            'varietal' => 'nullable|string|max:255',
            'harvest_date' => 'nullable|date',
            'price' => 'nullable|numeric|min:0',
            'bag_size_grams' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'flavor_tags' => 'nullable|array',
        ]);

        $bean->update($validated);

        // Sync flavor tags
        if ($request->has('flavor_tags')) {
            $bean->flavorTags()->sync($request->flavor_tags);
        }

        return redirect()
            ->route('beans.show', $bean)
            ->with('success', 'Bean updated successfully!');
    }

    /**
     * Remove the bean
     */
    public function destroy(Bean $bean)
    {
        $this->authorize('delete', $bean);

        $bean->delete();

        return redirect()
            ->route('beans.index')
            ->with('success', 'Bean deleted successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bean;
use App\Models\UserBean;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with personal stats
     */
    public function index()
    {
        $user = Auth::user();

        // Get user statistics
        $stats = [
            'total_reviews' => $user->reviews()->count(),
            'beans_tried' => $user->beans()->distinct('bean_id')->count(),
            'discussion_posts' => $user->threads()->count() + $user->replies()->count(),
            'avg_rating' => round($user->reviews()->avg('rating_overall') ?? 0, 1),
        ];

        // Get recent reviews
        $recentReviews = $user->reviews()
            ->with('bean')
            ->latest()
            ->take(5)
            ->get();

        // Get coffee collection (journal entries)
        $collection = $user->beans()
            ->with('bean')
            ->latest()
            ->take(6)
            ->get();

        // Get recent discussions
        $recentThreads = $user->threads()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentReviews', 'collection', 'recentThreads'));
    }

    /**
     * Display the coffee journal (user's coffee collection)
     */
    public function journal()
    {
        $user = Auth::user();

        // Get all user beans with their related bean info
        $journalEntries = $user->beans()
            ->with('bean.flavorTags')
            ->latest()
            ->paginate(12);

        // Get all beans for adding to journal
        $availableBeans = Bean::orderBy('name')->get();

        return view('dashboard.journal', compact('journalEntries', 'availableBeans'));
    }

    /**
     * Add a bean to user's coffee journal
     */
    public function storeJournal(Request $request)
    {
        $validated = $request->validate([
            'bean_id' => 'required|exists:beans,id',
            'purchase_date' => 'nullable|date',
            'price_paid' => 'nullable|numeric|min:0',
            'purchase_location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'roast_date' => 'nullable|date',
            'status' => 'nullable|in:current,finished,stale,wishlist',
        ]);

        $validated['user_id'] = Auth::id();

        UserBean::create($validated);

        return redirect()
            ->route('journal.index')
            ->with('success', 'Coffee added to your journal!');
    }

    /**
     * Remove a bean from user's coffee journal
     */
    public function destroyJournal(UserBean $userBean)
    {
        // Ensure the user owns this journal entry
        if ($userBean->user_id !== Auth::id()) {
            abort(403);
        }

        $userBean->delete();

        return redirect()
            ->route('journal.index')
            ->with('success', 'Coffee removed from your journal.');
    }
}

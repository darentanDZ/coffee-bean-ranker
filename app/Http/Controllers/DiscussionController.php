<?php

namespace App\Http\Controllers;

use App\Models\DiscussionThread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of discussion threads
     */
    public function index(Request $request)
    {
        $query = DiscussionThread::with(['user', 'replies']);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'popular':
                $query->orderByDesc('view_count');
                break;
            case 'replies':
                $query->withCount('replies')->orderByDesc('replies_count');
                break;
            default:
                $query->latest();
        }

        // Pinned threads first
        $query->orderByDesc('pinned');

        $threads = $query->paginate(20);

        $categories = ['brewing', 'beans', 'equipment', 'recipes', 'general'];

        return view('discussions.index', compact('threads', 'categories'));
    }

    /**
     * Show the form for creating a new thread
     */
    public function create()
    {
        $categories = ['brewing', 'beans', 'equipment', 'recipes', 'general'];
        return view('discussions.create', compact('categories'));
    }

    /**
     * Store a newly created thread
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|in:brewing,beans,equipment,recipes,general',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['view_count'] = 0;

        $thread = DiscussionThread::create($validated);

        return redirect()
            ->route('discussions.show', $thread)
            ->with('success', 'Discussion thread created successfully!');
    }

    /**
     * Display the specified thread
     */
    public function show(DiscussionThread $discussion)
    {
        $discussion->load(['user', 'replies.user']);
        $discussion->incrementViewCount();

        return view('discussions.show', compact('discussion'));
    }

    /**
     * Show the form for editing the thread
     */
    public function edit(DiscussionThread $discussion)
    {
        $this->authorize('update', $discussion);

        $categories = ['brewing', 'beans', 'equipment', 'recipes', 'general'];
        return view('discussions.edit', compact('discussion', 'categories'));
    }

    /**
     * Update the thread
     */
    public function update(Request $request, DiscussionThread $discussion)
    {
        $this->authorize('update', $discussion);

        $validated = $request->validate([
            'category' => 'required|in:brewing,beans,equipment,recipes,general',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $discussion->update($validated);

        return redirect()
            ->route('discussions.show', $discussion)
            ->with('success', 'Thread updated successfully!');
    }

    /**
     * Remove the thread
     */
    public function destroy(DiscussionThread $discussion)
    {
        $this->authorize('delete', $discussion);

        $discussion->delete();

        return redirect()
            ->route('discussions.index')
            ->with('success', 'Thread deleted successfully!');
    }

    /**
     * Store a reply to a thread
     */
    public function storeReply(Request $request, DiscussionThread $discussion)
    {
        if ($discussion->locked) {
            return redirect()
                ->route('discussions.show', $discussion)
                ->with('error', 'This thread is locked and cannot accept new replies.');
        }

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['thread_id'] = $discussion->id;

        $discussion->replies()->create($validated);

        return redirect()
            ->route('discussions.show', $discussion)
            ->with('success', 'Reply posted successfully!');
    }
}

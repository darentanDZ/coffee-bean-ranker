<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bean;
use App\Models\DiscussionThread;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized access.');
            }
            return $next($request);
        });
    }

    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        // Get platform statistics
        $stats = [
            'total_users' => User::count(),
            'total_beans' => Bean::count(),
            'total_reviews' => Review::count(),
            'total_discussions' => DiscussionThread::count(),
            'users_this_month' => User::where('created_at', '>=', now()->subMonth())->count(),
            'beans_this_month' => Bean::where('created_at', '>=', now()->subMonth())->count(),
        ];

        // Get recent users
        $recentUsers = User::latest()->take(10)->get();

        // Get recent beans
        $recentBeans = Bean::with('creator')
            ->latest()
            ->take(10)
            ->get();

        // Get recent discussions
        $recentDiscussions = DiscussionThread::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Get flagged content (discussions with high activity or reports)
        $flaggedDiscussions = DiscussionThread::with('user')
            ->where('locked', true)
            ->orWhere('pinned', true)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentUsers',
            'recentBeans',
            'recentDiscussions',
            'flaggedDiscussions'
        ));
    }

    /**
     * Pin or unpin a discussion thread
     */
    public function pinDiscussion(DiscussionThread $discussion): RedirectResponse
    {
        $discussion->update(['pinned' => !$discussion->pinned]);

        return redirect()
            ->back()
            ->with('success', $discussion->pinned ? 'Thread pinned successfully.' : 'Thread unpinned successfully.');
    }

    /**
     * Lock or unlock a discussion thread
     */
    public function lockDiscussion(DiscussionThread $discussion): RedirectResponse
    {
        $discussion->update(['locked' => !$discussion->locked]);

        return redirect()
            ->back()
            ->with('success', $discussion->locked ? 'Thread locked successfully.' : 'Thread unlocked successfully.');
    }

    /**
     * Delete a user (admin action)
     */
    public function deleteUser(User $user): RedirectResponse
    {
        // Prevent admins from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()
                ->back()
                ->with('error', 'You cannot delete your own account from the admin panel.');
        }

        // Prevent deleting other admins
        if ($user->isAdmin()) {
            return redirect()
                ->back()
                ->with('error', 'You cannot delete other admin accounts.');
        }

        $user->delete();

        return redirect()
            ->back()
            ->with('success', 'User deleted successfully.');
    }
}

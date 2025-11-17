<?php

namespace App\Http\Controllers;

use App\Models\Bean;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get trending beans (most reviewed in last 7 days)
        $trending_beans = Bean::withCount(['reviews' => function ($query) {
            $query->where('created_at', '>=', now()->subDays(7));
        }])
            ->orderBy('reviews_count', 'desc')
            ->limit(8)
            ->get();

        // Get recent reviews
        $recent_reviews = Review::with(['user', 'bean'])
            ->latest()
            ->limit(5)
            ->get();

        // Platform stats
        $stats = [
            'total_beans' => Bean::count(),
            'total_reviews' => Review::count(),
            'total_users' => User::count(),
            'total_roasters' => Bean::distinct('roaster')->count('roaster'),
        ];

        return view('home', compact('trending_beans', 'recent_reviews', 'stats'));
    }
}

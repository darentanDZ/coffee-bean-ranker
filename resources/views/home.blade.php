@extends('layouts.app')

@section('title', 'Discover Your Next Perfect Cup')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-br from-coffee-800 via-coffee-700 to-coffee-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Discover Your Next<br>
                <span class="text-cream-300">Perfect Cup</span>
            </h1>
            <p class="text-xl text-cream-200 mb-8 max-w-2xl mx-auto">
                Track your coffee journey, discover new beans, and connect with fellow coffee enthusiasts.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" class="bg-cream-600 hover:bg-cream-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition">
                        Get Started Free
                    </a>
                    <a href="{{ route('beans.index') }}" class="bg-coffee-900 hover:bg-coffee-950 text-cream-100 px-8 py-3 rounded-lg font-semibold text-lg transition">
                        Explore Beans
                    </a>
                @else
                    <a href="{{ route('beans.create') }}" class="bg-cream-600 hover:bg-cream-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition">
                        Add a Bean
                    </a>
                    <a href="{{ route('dashboard') }}" class="bg-coffee-900 hover:bg-coffee-950 text-cream-100 px-8 py-3 rounded-lg font-semibold text-lg transition">
                        My Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <div class="text-4xl font-bold text-coffee-900">{{ $stats['total_beans'] ?? 0 }}</div>
                <div class="text-coffee-600 mt-2">Coffee Beans</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-coffee-900">{{ $stats['total_reviews'] ?? 0 }}</div>
                <div class="text-coffee-600 mt-2">Reviews</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-coffee-900">{{ $stats['total_users'] ?? 0 }}</div>
                <div class="text-coffee-600 mt-2">Coffee Lovers</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-coffee-900">{{ $stats['total_roasters'] ?? 0 }}</div>
                <div class="text-coffee-600 mt-2">Roasters</div>
            </div>
        </div>
    </div>
</div>

<!-- Trending Beans -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-coffee-900">🔥 Trending This Week</h2>
        <a href="{{ route('beans.index') }}" class="text-coffee-600 hover:text-coffee-800 font-medium">
            View All →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($trending_beans ?? [] as $bean)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                <div class="h-48 bg-gradient-to-br from-coffee-400 to-coffee-600 flex items-center justify-center">
                    @if($bean->image_url)
                        <img src="{{ $bean->image_url }}" alt="{{ $bean->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-lg text-coffee-900 mb-1">{{ $bean->name }}</h3>
                    <p class="text-coffee-600 text-sm mb-2">{{ $bean->roaster }}</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= round($bean->averageRating()) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-coffee-600 ml-2">{{ number_format($bean->averageRating(), 1) }}</span>
                        <span class="text-sm text-coffee-400 ml-1">({{ $bean->reviewCount() }})</span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        @if($bean->origin_country)
                            <span class="text-xs bg-cream-100 text-coffee-700 px-2 py-1 rounded">{{ $bean->origin_country }}</span>
                        @endif
                        @if($bean->roast_level)
                            <span class="text-xs bg-coffee-100 text-coffee-700 px-2 py-1 rounded">{{ ucfirst($bean->roast_level) }}</span>
                        @endif
                    </div>
                    <a href="{{ route('beans.show', $bean) }}" class="mt-4 block text-center bg-coffee-700 hover:bg-coffee-800 text-white py-2 rounded-md font-medium transition">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-coffee-600 text-lg">No beans yet. Be the first to add one!</p>
                <a href="{{ route('beans.create') }}" class="inline-block mt-4 bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-2 rounded-md font-medium">
                    Add First Bean
                </a>
            </div>
        @endforelse
    </div>
</div>

<!-- Explore by Origin -->
<div class="bg-cream-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-coffee-900 mb-8 text-center">☕ Explore by Origin</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach(['Ethiopia', 'Colombia', 'Brazil', 'Kenya', 'Guatemala', 'Costa Rica'] as $origin)
                <a href="{{ route('beans.index', ['origin' => $origin]) }}" class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition">
                    <div class="text-3xl mb-2">🌍</div>
                    <div class="font-semibold text-coffee-800">{{ $origin }}</div>
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Reviews -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-coffee-900 mb-8">Latest Reviews</h2>
    <div class="space-y-6">
        @forelse($recent_reviews ?? [] as $review)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-center">
                        <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full">
                        <div class="ml-4">
                            <h4 class="font-bold text-coffee-900">{{ $review->user->name }}</h4>
                            <p class="text-sm text-coffee-600">reviewed <a href="{{ route('beans.show', $review->bean) }}" class="text-coffee-700 hover:underline font-medium">{{ $review->bean->name }}</a></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex text-yellow-500">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($review->rating_overall) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="ml-2 font-bold text-coffee-900">{{ number_format($review->rating_overall, 1) }}</span>
                    </div>
                </div>
                @if($review->review_text)
                    <p class="mt-4 text-coffee-700">{{ Str::limit($review->review_text, 200) }}</p>
                @endif
                <div class="mt-4 text-sm text-coffee-500">
                    {{ $review->created_at->diffForHumans() }}
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white rounded-lg">
                <p class="text-coffee-600 text-lg">No reviews yet. Be the first to review a bean!</p>
            </div>
        @endforelse
    </div>
</div>

<!-- CTA Section -->
@guest
<div class="bg-gradient-to-r from-coffee-700 to-coffee-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold mb-4">Ready to Start Your Coffee Journey?</h2>
        <p class="text-xl text-cream-200 mb-8">Join our community of coffee enthusiasts today!</p>
        <a href="{{ route('register') }}" class="inline-block bg-cream-600 hover:bg-cream-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition">
            Create Free Account
        </a>
    </div>
</div>
@endguest
@endsection

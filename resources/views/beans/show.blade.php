@extends('layouts.app')

@section('title', $bean->name . ' - ' . $bean->roaster)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav class="mb-6 text-sm">
        <a href="{{ route('home') }}" class="text-coffee-600 hover:text-coffee-800">Home</a>
        <span class="mx-2 text-coffee-400">/</span>
        <a href="{{ route('beans.index') }}" class="text-coffee-600 hover:text-coffee-800">Beans</a>
        <span class="mx-2 text-coffee-400">/</span>
        <span class="text-coffee-900">{{ $bean->name }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Bean Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h1 class="text-3xl font-bold text-coffee-900 mb-2">{{ $bean->name }}</h1>
                        <p class="text-xl text-coffee-600 mb-4">{{ $bean->roaster }}</p>

                        <!-- Rating Overview -->
                        <div class="flex items-center mb-4">
                            <div class="flex text-yellow-500 text-2xl">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-8 h-8 {{ $i <= round($averageRatings['overall']) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-3 text-2xl font-bold text-coffee-900">{{ number_format($averageRatings['overall'], 1) }}</span>
                            <span class="ml-2 text-coffee-600">({{ $bean->reviews->count() }} reviews)</span>
                        </div>

                        <!-- Flavor Tags -->
                        @if($bean->flavorTags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($bean->flavorTags as $tag)
                                    <span class="px-3 py-1 bg-cream-200 text-coffee-800 rounded-full text-sm font-medium">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-3">
                            @auth
                                <button onclick="document.getElementById('review-form').scrollIntoView({ behavior: 'smooth' })" class="bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-2 rounded-lg font-medium transition">
                                    Write Review
                                </button>
                                <button class="bg-cream-600 hover:bg-cream-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                    Add to Collection
                                </button>
                                @can('update', $bean)
                                    <a href="{{ route('beans.edit', $bean) }}" class="bg-coffee-100 hover:bg-coffee-200 text-coffee-800 px-6 py-2 rounded-lg font-medium transition">
                                        Edit Bean
                                    </a>
                                @endcan
                            @else
                                <a href="{{ route('login') }}" class="bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-2 rounded-lg font-medium transition">
                                    Sign in to Review
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Bean Image -->
                    <div class="ml-6 flex-shrink-0">
                        <div class="w-48 h-48 bg-gradient-to-br from-coffee-400 to-coffee-600 rounded-lg flex items-center justify-center overflow-hidden">
                            @if($bean->image_url)
                                <img src="{{ $bean->image_url }}" alt="{{ $bean->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Ratings -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold text-coffee-900 mb-4">Detailed Ratings</h2>
                <div class="space-y-3">
                    @foreach(['aroma' => 'Aroma', 'acidity' => 'Acidity', 'body' => 'Body', 'flavor' => 'Flavor', 'aftertaste' => 'Aftertaste'] as $key => $label)
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-coffee-700 font-medium">{{ $label }}</span>
                                <span class="text-coffee-600">{{ number_format($averageRatings[$key], 1) }}/5.0</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-coffee-600 h-2 rounded-full" style="width: {{ ($averageRatings[$key] / 5) * 100 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Description -->
            @if($bean->description)
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold text-coffee-900 mb-4">About This Bean</h2>
                    <p class="text-coffee-700 leading-relaxed">{{ $bean->description }}</p>
                </div>
            @endif

            <!-- Reviews Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-2xl font-bold text-coffee-900 mb-6">Reviews ({{ $bean->reviews->count() }})</h2>

                @forelse($bean->reviews as $review)
                    <div class="border-b border-coffee-100 pb-6 mb-6 last:border-0">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center">
                                <img src="{{ $review->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full">
                                <div class="ml-3">
                                    <h4 class="font-bold text-coffee-900">{{ $review->user->name }}</h4>
                                    <p class="text-sm text-coffee-500">{{ $review->created_at->diffForHumans() }}</p>
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
                            <p class="text-coffee-700 mb-3">{{ $review->review_text }}</p>
                        @endif

                        @if($review->brewing_method)
                            <p class="text-sm text-coffee-600">Brewing method: <span class="font-medium">{{ $review->brewing_method }}</span></p>
                        @endif

                        @if($review->would_buy_again)
                            <p class="text-sm text-green-600 font-medium mt-2">✓ Would buy again</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <p class="text-coffee-600">No reviews yet. Be the first to review this bean!</p>
                    </div>
                @endforelse
            </div>

            <!-- Write Review Form -->
            @auth
                <div id="review-form" class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-coffee-900 mb-6">Write Your Review</h2>
                    <form method="POST" action="{{ route('reviews.store', $bean) }}">
                        @csrf
                        <!-- Rating -->
                        <div class="mb-6">
                            <label class="block text-coffee-700 font-medium mb-2">Overall Rating *</label>
                            <div class="flex gap-2" x-data="{ rating: 0 }">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" @click="rating = {{ $i }}; document.getElementById('rating').value = {{ $i }}" class="text-3xl">
                                        <span x-show="rating >= {{ $i }}" class="text-yellow-500">★</span>
                                        <span x-show="rating < {{ $i }}" class="text-gray-300">☆</span>
                                    </button>
                                @endfor
                                <input type="hidden" id="rating" name="rating_overall" required>
                            </div>
                        </div>

                        <!-- Brewing Method -->
                        <div class="mb-4">
                            <label class="block text-coffee-700 font-medium mb-2">Brewing Method</label>
                            <input type="text" name="brewing_method" placeholder="e.g., Pour Over, Espresso" class="w-full px-4 py-2 border border-coffee-300 rounded-lg">
                        </div>

                        <!-- Review Text -->
                        <div class="mb-4">
                            <label class="block text-coffee-700 font-medium mb-2">Your Review</label>
                            <textarea name="review_text" rows="5" placeholder="Share your experience with this bean..." class="w-full px-4 py-2 border border-coffee-300 rounded-lg"></textarea>
                        </div>

                        <!-- Would Buy Again -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="would_buy_again" value="1" class="rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500">
                                <span class="ml-2 text-coffee-700">I would buy this again</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-coffee-700 hover:bg-coffee-800 text-white py-3 rounded-lg font-semibold transition">
                            Submit Review
                        </button>
                    </form>
                </div>
            @endauth
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Bean Details Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 sticky top-20">
                <h3 class="text-lg font-bold text-coffee-900 mb-4">Bean Details</h3>
                <dl class="space-y-3">
                    @if($bean->origin_country)
                        <div>
                            <dt class="text-sm text-coffee-600">Origin</dt>
                            <dd class="font-medium text-coffee-900">{{ $bean->origin_country }}@if($bean->origin_region), {{ $bean->origin_region }}@endif</dd>
                        </div>
                    @endif

                    @if($bean->roast_level)
                        <div>
                            <dt class="text-sm text-coffee-600">Roast Level</dt>
                            <dd class="font-medium text-coffee-900">{{ ucfirst($bean->roast_level) }}</dd>
                        </div>
                    @endif

                    @if($bean->processing_method)
                        <div>
                            <dt class="text-sm text-coffee-600">Processing</dt>
                            <dd class="font-medium text-coffee-900">{{ ucfirst($bean->processing_method) }}</dd>
                        </div>
                    @endif

                    @if($bean->varietal)
                        <div>
                            <dt class="text-sm text-coffee-600">Varietal</dt>
                            <dd class="font-medium text-coffee-900">{{ $bean->varietal }}</dd>
                        </div>
                    @endif

                    @if($bean->altitude)
                        <div>
                            <dt class="text-sm text-coffee-600">Altitude</dt>
                            <dd class="font-medium text-coffee-900">{{ number_format($bean->altitude) }}m</dd>
                        </div>
                    @endif

                    @if($bean->price)
                        <div>
                            <dt class="text-sm text-coffee-600">Price</dt>
                            <dd class="font-medium text-coffee-900">${{ number_format($bean->price, 2) }} @if($bean->bag_size_grams)({{ $bean->bag_size_grams }}g)@endif</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-sm text-coffee-600">Added by</dt>
                        <dd class="font-medium text-coffee-900">{{ $bean->creator->name }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Similar Beans -->
            @if($similar_beans->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-bold text-coffee-900 mb-4">Similar Beans</h3>
                    <div class="space-y-4">
                        @foreach($similar_beans as $similar)
                            <a href="{{ route('beans.show', $similar) }}" class="block hover:bg-cream-50 p-3 rounded-lg transition">
                                <h4 class="font-medium text-coffee-900">{{ $similar->name }}</h4>
                                <p class="text-sm text-coffee-600">{{ $similar->roaster }}</p>
                                <div class="flex items-center mt-1">
                                    <div class="flex text-yellow-500 text-xs">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-3 h-3 {{ $i <= round($similar->averageRating()) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-xs text-coffee-600 ml-1">{{ number_format($similar->averageRating(), 1) }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

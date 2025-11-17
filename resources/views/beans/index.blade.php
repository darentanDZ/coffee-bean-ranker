@extends('layouts.app')

@section('title', 'Browse Coffee Beans')

@section('content')
<div class="bg-coffee-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Discover Coffee Beans</h1>
        <p class="text-cream-200 text-lg">Explore our community's coffee bean collection</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('beans.index') }}" class="space-y-4">
            <!-- Search Bar -->
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search beans, roasters, origins..." class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
            </div>

            <!-- Filters Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Origin Filter -->
                <select name="origin" class="px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                    <option value="">All Origins</option>
                    @foreach($origins as $origin)
                        <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>
                            {{ $origin }}
                        </option>
                    @endforeach
                </select>

                <!-- Roast Level Filter -->
                <select name="roast_level" class="px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                    <option value="">All Roast Levels</option>
                    @foreach($roast_levels as $level)
                        <option value="{{ $level }}" {{ request('roast_level') == $level ? 'selected' : '' }}>
                            {{ ucfirst($level) }}
                        </option>
                    @endforeach
                </select>

                <!-- Processing Method Filter -->
                <select name="processing" class="px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                    <option value="">All Processing</option>
                    @foreach($processing_methods as $method)
                        <option value="{{ $method }}" {{ request('processing') == $method ? 'selected' : '' }}>
                            {{ ucfirst($method) }}
                        </option>
                    @endforeach
                </select>

                <!-- Sort -->
                <select name="sort" class="px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center">
                <button type="submit" class="bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-2 rounded-lg font-medium transition">
                    Apply Filters
                </button>
                @if(request()->hasAny(['search', 'origin', 'roast_level', 'processing', 'sort']))
                    <a href="{{ route('beans.index') }}" class="text-coffee-600 hover:text-coffee-800 font-medium">
                        Clear All Filters
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Add Bean Button -->
    @auth
        <div class="mb-6 text-right">
            <a href="{{ route('beans.create') }}" class="inline-flex items-center bg-cream-600 hover:bg-cream-700 text-white px-6 py-3 rounded-lg font-medium transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Bean
            </a>
        </div>
    @endauth

    <!-- Results Info -->
    <div class="mb-6 text-coffee-600">
        Showing {{ $beans->firstItem() ?? 0 }} - {{ $beans->lastItem() ?? 0 }} of {{ $beans->total() }} beans
    </div>

    <!-- Beans Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($beans as $bean)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                <!-- Bean Image -->
                <div class="h-48 bg-gradient-to-br from-coffee-400 to-coffee-600 flex items-center justify-center">
                    @if($bean->image_url)
                        <img src="{{ $bean->image_url }}" alt="{{ $bean->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                        </svg>
                    @endif
                </div>

                <!-- Bean Info -->
                <div class="p-4">
                    <h3 class="font-bold text-lg text-coffee-900 mb-1 truncate">{{ $bean->name }}</h3>
                    <p class="text-coffee-600 text-sm mb-2 truncate">{{ $bean->roaster }}</p>

                    <!-- Rating -->
                    <div class="flex items-center mb-3">
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

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-1 mb-3">
                        @if($bean->origin_country)
                            <span class="text-xs bg-cream-100 text-coffee-700 px-2 py-1 rounded">{{ $bean->origin_country }}</span>
                        @endif
                        @if($bean->roast_level)
                            <span class="text-xs bg-coffee-100 text-coffee-700 px-2 py-1 rounded">{{ ucfirst($bean->roast_level) }}</span>
                        @endif
                    </div>

                    <!-- Price -->
                    @if($bean->price)
                        <p class="text-coffee-700 font-semibold mb-3">${{ number_format($bean->price, 2) }}</p>
                    @endif

                    <!-- View Button -->
                    <a href="{{ route('beans.show', $bean) }}" class="block text-center bg-coffee-700 hover:bg-coffee-800 text-white py-2 rounded-md font-medium transition">
                        View Details
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 bg-white rounded-lg">
                <svg class="w-24 h-24 text-coffee-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-xl font-semibold text-coffee-700 mb-2">No beans found</h3>
                <p class="text-coffee-600 mb-4">Try adjusting your filters or search criteria</p>
                @auth
                    <a href="{{ route('beans.create') }}" class="inline-block bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-3 rounded-lg font-medium transition">
                        Add First Bean
                    </a>
                @endauth
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($beans->hasPages())
        <div class="mt-8">
            {{ $beans->links() }}
        </div>
    @endif
</div>
@endsection

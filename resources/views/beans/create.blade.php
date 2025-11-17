@extends('layouts.app')

@section('title', 'Add New Coffee Bean')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-coffee-900 mb-2">Add New Coffee Bean</h1>
        <p class="text-coffee-600">Share a coffee bean you've discovered with the community</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('beans.store') }}" class="bg-white rounded-lg shadow-md p-8">
        @csrf

        <!-- Basic Information -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-coffee-900 mb-4">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Bean Name -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Bean Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Roaster -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Roaster *</label>
                    <input type="text" name="roaster" value="{{ old('roaster') }}" required class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500 @error('roaster') border-red-500 @enderror">
                    @error('roaster')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Origin Details -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-coffee-900 mb-4">Origin</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Country -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Country</label>
                    <input type="text" name="origin_country" value="{{ old('origin_country') }}" placeholder="e.g., Ethiopia" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>

                <!-- Region -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Region</label>
                    <input type="text" name="origin_region" value="{{ old('origin_region') }}" placeholder="e.g., Yirgacheffe" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>

                <!-- Farm -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Farm</label>
                    <input type="text" name="farm" value="{{ old('farm') }}" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>
            </div>
        </div>

        <!-- Processing Details -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-coffee-900 mb-4">Processing & Profile</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Roast Level -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Roast Level</label>
                    <select name="roast_level" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                        <option value="">Select roast level</option>
                        @foreach($roast_levels as $level)
                            <option value="{{ $level }}" {{ old('roast_level') == $level ? 'selected' : '' }}>
                                {{ ucfirst($level) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Processing Method -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Processing Method</label>
                    <select name="processing_method" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                        <option value="">Select processing method</option>
                        @foreach($processing_methods as $method)
                            <option value="{{ $method }}" {{ old('processing_method') == $method ? 'selected' : '' }}>
                                {{ ucfirst($method) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Varietal -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Varietal</label>
                    <input type="text" name="varietal" value="{{ old('varietal') }}" placeholder="e.g., Bourbon, Heirloom" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>

                <!-- Altitude -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Altitude (meters)</label>
                    <input type="number" name="altitude" value="{{ old('altitude') }}" placeholder="1800" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>
            </div>
        </div>

        <!-- Pricing & Package -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-coffee-900 mb-4">Pricing & Package</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Price -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Price (USD)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="19.99" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>

                <!-- Bag Size -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Bag Size (grams)</label>
                    <input type="number" name="bag_size_grams" value="{{ old('bag_size_grams') }}" placeholder="340" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>

                <!-- Harvest Date -->
                <div>
                    <label class="block text-coffee-700 font-medium mb-2">Harvest Date</label>
                    <input type="date" name="harvest_date" value="{{ old('harvest_date') }}" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                </div>
            </div>
        </div>

        <!-- Flavor Profile -->
        @if($flavor_tags->count() > 0)
            <div class="mb-8">
                <h2 class="text-xl font-bold text-coffee-900 mb-4">Flavor Profile</h2>
                <p class="text-coffee-600 mb-4">Select flavors that describe this bean</p>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($flavor_tags as $tag)
                        <label class="flex items-center p-3 border border-coffee-200 rounded-lg hover:bg-cream-50 cursor-pointer transition">
                            <input type="checkbox" name="flavor_tags[]" value="{{ $tag->id }}" class="rounded border-coffee-300 text-coffee-700 focus:ring-coffee-500">
                            <span class="ml-2 text-coffee-700">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Description -->
        <div class="mb-8">
            <label class="block text-coffee-700 font-medium mb-2">Description</label>
            <textarea name="description" rows="5" placeholder="Tell us about this bean... tasting notes, origin story, brewing recommendations..." class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">{{ old('description') }}</textarea>
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-coffee-700 hover:bg-coffee-800 text-white py-3 rounded-lg font-semibold transition">
                Add Coffee Bean
            </button>
            <a href="{{ route('beans.index') }}" class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-coffee-800 rounded-lg font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

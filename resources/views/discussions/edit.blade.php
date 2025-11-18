@extends('layouts.app')

@section('title', 'Edit Discussion')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-coffee-900 mb-2">Edit Discussion</h1>
        <p class="text-coffee-600">Update your discussion</p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('discussions.update', $discussion) }}" class="bg-white rounded-lg shadow-md p-8">
        @csrf
        @method('PUT')

        <!-- Category -->
        <div class="mb-6">
            <label class="block text-coffee-700 font-medium mb-2">Category *</label>
            <select name="category" required class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500 @error('category') border-red-500 @enderror">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" {{ old('category', $discussion->category) == $category ? 'selected' : '' }}>
                        {{ ucfirst($category) }}
                    </option>
                @endforeach
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Title -->
        <div class="mb-6">
            <label class="block text-coffee-700 font-medium mb-2">Title *</label>
            <input type="text" name="title" value="{{ old('title', $discussion->title) }}" required placeholder="What's your discussion about?" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content -->
        <div class="mb-6">
            <label class="block text-coffee-700 font-medium mb-2">Content *</label>
            <textarea name="content" rows="10" required placeholder="Share your thoughts, questions, or ideas..." class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500 @error('content') border-red-500 @enderror">{{ old('content', $discussion->content) }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Buttons -->
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-coffee-700 hover:bg-coffee-800 text-white py-3 rounded-lg font-semibold transition">
                Update Discussion
            </button>
            <a href="{{ route('discussions.show', $discussion) }}" class="px-8 py-3 bg-gray-200 hover:bg-gray-300 text-coffee-800 rounded-lg font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', $discussion->title)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('discussions.index') }}" class="text-coffee-600 hover:text-coffee-800 font-medium">
            ← Back to Discussions
        </a>
    </div>

    <!-- Thread -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="p-6 border-b border-coffee-100">
            <div class="flex items-center gap-2 mb-4">
                @if($discussion->pinned)
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">
                        📌 Pinned
                    </span>
                @endif
                @if($discussion->locked)
                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">
                        🔒 Locked
                    </span>
                @endif
                <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-coffee-100 text-coffee-800 rounded">
                    {{ ucfirst($discussion->category) }}
                </span>
            </div>

            <h1 class="text-3xl font-bold text-coffee-900 mb-4">{{ $discussion->title }}</h1>

            <div class="flex items-center gap-4 text-sm text-coffee-500 mb-6">
                <div class="flex items-center gap-2">
                    <img src="{{ $discussion->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($discussion->user->name) }}" alt="{{ $discussion->user->name }}" class="w-8 h-8 rounded-full">
                    <span class="font-medium">{{ $discussion->user->name }}</span>
                </div>
                <span>•</span>
                <span>{{ $discussion->created_at->format('M d, Y \a\t h:i A') }}</span>
                <span>•</span>
                <span>👁️ {{ $discussion->view_count ?? 0 }} views</span>
            </div>

            <div class="prose max-w-none text-coffee-700 whitespace-pre-line">
                {{ $discussion->content }}
            </div>
        </div>

        <!-- Thread Actions -->
        @auth
            @if(auth()->id() === $discussion->user_id || auth()->user()->isAdmin() || auth()->user()->isModerator())
                <div class="px-6 py-4 bg-coffee-50 flex gap-3">
                    @if(auth()->id() === $discussion->user_id || auth()->user()->isAdmin())
                        <a href="{{ route('discussions.edit', $discussion) }}" class="text-coffee-600 hover:text-coffee-800 font-medium">
                            Edit Thread
                        </a>
                    @endif
                    @if(auth()->user()->isAdmin() || auth()->user()->isModerator())
                        <form method="POST" action="{{ route('discussions.destroy', $discussion) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this thread?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium">
                                Delete Thread
                            </button>
                        </form>
                    @endif
                </div>
            @endif
        @endauth
    </div>

    <!-- Replies Section -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-coffee-900 mb-4">
            Replies ({{ $discussion->replies->count() }})
        </h2>

        <div class="space-y-4">
            @forelse($discussion->replies as $reply)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-start gap-4">
                        <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) }}" alt="{{ $reply->user->name }}" class="w-12 h-12 rounded-full">

                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="font-bold text-coffee-900">{{ $reply->user->name }}</span>
                                <span class="text-sm text-coffee-500">{{ $reply->created_at->diffForHumans() }}</span>
                                @if($reply->is_best_answer)
                                    <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded">
                                        ✓ Best Answer
                                    </span>
                                @endif
                            </div>

                            <div class="prose max-w-none text-coffee-700 whitespace-pre-line">
                                {{ $reply->content }}
                            </div>

                            @if($reply->upvotes > 0)
                                <div class="mt-3 text-sm text-coffee-600">
                                    👍 {{ $reply->upvotes }} {{ Str::plural('upvote', $reply->upvotes) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md p-12 text-center">
                    <p class="text-coffee-600">No replies yet. Be the first to respond!</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Reply Form -->
    @auth
        @if(!$discussion->locked)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-coffee-900 mb-4">Post a Reply</h3>
                <form method="POST" action="{{ route('discussions.replies.store', $discussion) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="content" rows="6" class="w-full px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500" placeholder="Write your reply..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-3 rounded-lg font-medium transition">
                        Post Reply
                    </button>
                </form>
            </div>
        @else
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                <p class="text-yellow-800">🔒 This thread is locked. No new replies can be posted.</p>
            </div>
        @endif
    @else
        <div class="bg-coffee-50 border border-coffee-200 rounded-lg p-6 text-center">
            <p class="text-coffee-700">
                <a href="{{ route('login') }}" class="text-coffee-800 font-semibold hover:underline">Log in</a>
                or
                <a href="{{ route('register') }}" class="text-coffee-800 font-semibold hover:underline">register</a>
                to reply to this thread.
            </p>
        </div>
    @endguest
</div>
@endsection

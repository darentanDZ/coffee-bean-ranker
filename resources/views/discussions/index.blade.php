@extends('layouts.app')

@section('title', 'Community Discussions')

@section('content')
<!-- Header -->
<div class="bg-coffee-700 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Community Discussions</h1>
        <p class="text-cream-200 text-lg">Join the conversation with fellow coffee enthusiasts</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-bold text-coffee-900 mb-4">Categories</h3>
                <div class="space-y-2">
                    <a href="{{ route('discussions.index') }}" class="block px-3 py-2 rounded {{ !request('category') ? 'bg-coffee-100 text-coffee-900' : 'text-coffee-700 hover:bg-coffee-50' }}">
                        All Discussions
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('discussions.index', ['category' => $cat]) }}" class="block px-3 py-2 rounded {{ request('category') == $cat ? 'bg-coffee-100 text-coffee-900' : 'text-coffee-700 hover:bg-coffee-50' }}">
                            {{ ucfirst($cat) }}
                        </a>
                    @endforeach
                </div>
            </div>

            @auth
                <a href="{{ route('discussions.create') }}" class="block w-full bg-cream-600 hover:bg-cream-700 text-white text-center px-6 py-3 rounded-lg font-medium transition">
                    Start New Thread
                </a>
            @endauth
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Search and Sort -->
            <div class="bg-white rounded-lg shadow-md p-4 mb-6">
                <form method="GET" action="{{ route('discussions.index') }}" class="flex gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search discussions..." class="flex-1 px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">

                    <select name="sort" class="px-4 py-2 border border-coffee-300 rounded-lg focus:ring-coffee-500 focus:border-coffee-500">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Viewed</option>
                        <option value="replies" {{ request('sort') == 'replies' ? 'selected' : '' }}>Most Replies</option>
                    </select>

                    <button type="submit" class="bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-2 rounded-lg font-medium transition">
                        Search
                    </button>
                </form>
            </div>

            <!-- Threads List -->
            <div class="space-y-4">
                @forelse($threads as $thread)
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-2">
                                        @if($thread->pinned)
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded">
                                                📌 Pinned
                                            </span>
                                        @endif
                                        @if($thread->locked)
                                            <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded">
                                                🔒 Locked
                                            </span>
                                        @endif
                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold bg-coffee-100 text-coffee-800 rounded">
                                            {{ ucfirst($thread->category) }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-bold text-coffee-900 mb-2">
                                        <a href="{{ route('discussions.show', $thread) }}" class="hover:text-coffee-700">
                                            {{ $thread->title }}
                                        </a>
                                    </h3>

                                    <p class="text-coffee-600 mb-4 line-clamp-2">
                                        {{ Str::limit(strip_tags($thread->content), 150) }}
                                    </p>

                                    <div class="flex items-center gap-4 text-sm text-coffee-500">
                                        <div class="flex items-center gap-1">
                                            <img src="{{ $thread->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($thread->user->name) }}" alt="{{ $thread->user->name }}" class="w-6 h-6 rounded-full">
                                            <span>{{ $thread->user->name }}</span>
                                        </div>
                                        <span>•</span>
                                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                                        <span>•</span>
                                        <span>👁️ {{ $thread->view_count ?? 0 }} views</span>
                                        <span>•</span>
                                        <span>💬 {{ $thread->replies_count ?? $thread->replies->count() }} replies</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-24 h-24 text-coffee-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-coffee-700 mb-2">No discussions found</h3>
                        <p class="text-coffee-600 mb-4">Be the first to start a conversation!</p>
                        @auth
                            <a href="{{ route('discussions.create') }}" class="inline-block bg-coffee-700 hover:bg-coffee-800 text-white px-6 py-3 rounded-lg font-medium transition">
                                Start First Thread
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($threads->hasPages())
                <div class="mt-8">
                    {{ $threads->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

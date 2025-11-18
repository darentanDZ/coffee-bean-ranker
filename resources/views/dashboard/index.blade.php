<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Reviews</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_reviews'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Beans Tried</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['beans_tried'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Discussion Posts</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['discussion_posts'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Average Rating</div>
                        <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['avg_rating'] }}/5</div>
                    </div>
                </div>
            </div>

            <!-- Recent Reviews -->
            @if($recentReviews->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Reviews</h3>
                    <div class="space-y-3">
                        @foreach($recentReviews as $review)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3 last:border-0">
                            <a href="{{ route('beans.show', $review->bean) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                {{ $review->bean->name }}
                            </a>
                            <div class="flex items-center mt-1">
                                <span class="text-yellow-400">{{ str_repeat('★', $review->rating_overall) }}</span>
                                <span class="text-gray-400">{{ str_repeat('☆', 5 - $review->rating_overall) }}</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Coffee Collection -->
            @if($collection->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">My Coffee Collection</h3>
                        <a href="{{ route('journal.index') }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">View All</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($collection as $userBean)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <a href="{{ route('beans.show', $userBean->bean) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                {{ $userBean->bean->name }}
                            </a>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $userBean->bean->roaster }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-2">Added {{ $userBean->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Discussions -->
            @if($recentThreads->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">My Recent Discussions</h3>
                    <div class="space-y-3">
                        @foreach($recentThreads as $thread)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3 last:border-0">
                            <a href="{{ route('discussions.show', $thread) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                {{ $thread->title }}
                            </a>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                in {{ ucfirst($thread->category) }} • {{ $thread->created_at->diffForHumans() }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('beans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Browse Beans
                        </a>
                        <a href="{{ route('beans.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Add Bean
                        </a>
                        <a href="{{ route('journal.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            My Journal
                        </a>
                        <a href="{{ route('discussions.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Start Discussion
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

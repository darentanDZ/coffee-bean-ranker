<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Profile') }}
            </h2>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                Edit Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- User Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                        @else
                        <div class="w-24 h-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                            <span class="text-3xl text-gray-600 dark:text-gray-300">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                        </div>
                        @endif

                        <div class="flex-1">
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>
                            @if($user->location)
                            <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $user->location }}</p>
                            @endif
                            @if($user->bio)
                            <p class="text-gray-700 dark:text-gray-300 mt-3">{{ $user->bio }}</p>
                            @endif

                            @if($user->instagram_handle || $user->twitter_handle)
                            <div class="flex gap-3 mt-3">
                                @if($user->instagram_handle)
                                <a href="https://instagram.com/{{ $user->instagram_handle }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                    Instagram
                                </a>
                                @endif
                                @if($user->twitter_handle)
                                <a href="https://twitter.com/{{ $user->twitter_handle }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                                    Twitter
                                </a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_reviews'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Reviews</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['beans_tried'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Beans Tried</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['discussions'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Discussions</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['followers'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Followers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['following'] }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Following</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

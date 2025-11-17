<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Users</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_users'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Beans</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_beans'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Reviews</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_reviews'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">Discussions</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['total_discussions'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">New Users</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500">This Month</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['users_this_month'] }}</div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400">New Beans</div>
                        <div class="text-xs text-gray-500 dark:text-gray-500">This Month</div>
                        <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $stats['beans_this_month'] }}</div>
                    </div>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif

            <!-- Recent Users -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Users</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($recentUsers as $user)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('users.show', $user) }}" class="text-blue-600 dark:text-blue-400 hover:underline">{{ $user->name }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ ucfirst($user->role ?? 'user') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->diffForHumans() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if(!$user->isAdmin())
                                        <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Beans -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recently Added Beans</h3>
                    <div class="space-y-3">
                        @foreach($recentBeans as $bean)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3 last:border-0 flex justify-between items-center">
                            <div>
                                <a href="{{ route('beans.show', $bean) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    {{ $bean->name }}
                                </a>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    by {{ $bean->creator->name }} • {{ $bean->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <a href="{{ route('beans.show', $bean) }}" class="text-blue-600 dark:text-blue-400 hover:underline text-sm">View</a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Recent Discussions -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Recent Discussions</h3>
                    <div class="space-y-3">
                        @foreach($recentDiscussions as $discussion)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3 last:border-0 flex justify-between items-start">
                            <div class="flex-1">
                                <a href="{{ route('discussions.show', $discussion) }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                                    {{ $discussion->title }}
                                </a>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    by {{ $discussion->user->name }} in {{ ucfirst($discussion->category) }} • {{ $discussion->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex gap-2 ml-4">
                                <form method="POST" action="{{ route('admin.discussions.pin', $discussion) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm {{ $discussion->pinned ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 dark:text-gray-400' }} hover:underline">
                                        {{ $discussion->pinned ? 'Unpin' : 'Pin' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.discussions.lock', $discussion) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm {{ $discussion->locked ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }} hover:underline">
                                        {{ $discussion->locked ? 'Unlock' : 'Lock' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Flagged/Moderated Content -->
            @if($flaggedDiscussions->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Moderated Discussions</h3>
                    <div class="space-y-3">
                        @foreach($flaggedDiscussions as $discussion)
                        <div class="border-b border-gray-200 dark:border-gray-700 pb-3 last:border-0">
                            <div class="flex items-center gap-2">
                                @if($discussion->pinned)
                                <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded">Pinned</span>
                                @endif
                                @if($discussion->locked)
                                <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Locked</span>
                                @endif
                                <a href="{{ route('discussions.show', $discussion) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                    {{ $discussion->title }}
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

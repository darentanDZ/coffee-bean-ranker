<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Coffee Journal') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif

            <!-- Add Coffee Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Add Coffee to Journal</h3>
                    <form method="POST" action="{{ route('journal.store') }}" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="bean_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coffee Bean</label>
                                <select id="bean_id" name="bean_id" required class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select a bean...</option>
                                    @foreach($availableBeans as $bean)
                                    <option value="{{ $bean->id }}">{{ $bean->name }} - {{ $bean->roaster }}</option>
                                    @endforeach
                                </select>
                                @error('bean_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="purchase_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Date</label>
                                <input type="date" id="purchase_date" name="purchase_date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="price_paid" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Price ($)</label>
                                <input type="number" step="0.01" id="price_paid" name="price_paid" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="purchase_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Purchase Location</label>
                                <input type="text" id="purchase_location" name="purchase_location" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="roast_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Roast Date</label>
                                <input type="date" id="roast_date" name="roast_date" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
                                <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Add to Journal
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Journal Entries -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">My Coffee Collection ({{ $journalEntries->total() }})</h3>

                    @if($journalEntries->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($journalEntries as $entry)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 relative">
                            <form method="POST" action="{{ route('journal.destroy', $entry) }}" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Are you sure you want to remove this from your journal?')" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200 text-sm">
                                    Remove
                                </button>
                            </form>

                            <a href="{{ route('beans.show', $entry->bean) }}" class="text-lg font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                {{ $entry->bean->name }}
                            </a>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $entry->bean->roaster }}</p>

                            @if($entry->bean->flavorTags->count() > 0)
                            <div class="mt-2 flex flex-wrap gap-1">
                                @foreach($entry->bean->flavorTags->take(3) as $tag)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    {{ $tag->name }}
                                </span>
                                @endforeach
                            </div>
                            @endif

                            @if($entry->purchase_date || $entry->price_paid || $entry->purchase_location || $entry->roast_date)
                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700 text-sm space-y-1">
                                @if($entry->purchase_date)
                                <p class="text-gray-600 dark:text-gray-400">Purchased: {{ $entry->purchase_date->format('M d, Y') }}</p>
                                @endif
                                @if($entry->price_paid)
                                <p class="text-gray-600 dark:text-gray-400">Price: ${{ number_format($entry->price_paid, 2) }}</p>
                                @endif
                                @if($entry->purchase_location)
                                <p class="text-gray-600 dark:text-gray-400">From: {{ $entry->purchase_location }}</p>
                                @endif
                                @if($entry->roast_date)
                                <p class="text-gray-600 dark:text-gray-400">Roasted: {{ $entry->roast_date->format('M d, Y') }}</p>
                                @endif
                                @if($entry->status)
                                <p class="text-gray-600 dark:text-gray-400">Status: {{ ucfirst($entry->status) }}</p>
                                @endif
                            </div>
                            @endif

                            @if($entry->notes)
                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-600 dark:text-gray-400 italic">{{ Str::limit($entry->notes, 100) }}</p>
                            </div>
                            @endif

                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-3">Added {{ $entry->created_at->diffForHumans() }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $journalEntries->links() }}
                    </div>
                    @else
                    <p class="text-gray-600 dark:text-gray-400 text-center py-8">
                        No entries in your journal yet. Add your first coffee above!
                    </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

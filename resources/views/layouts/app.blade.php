<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coffee Bean Ranker') }} - @yield('title', 'Discover Your Next Perfect Cup')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-50 text-coffee-900 antialiased">
    <!-- Navigation -->
    <nav class="bg-coffee-800 border-b border-coffee-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-cream-100 text-xl font-bold flex items-center">
                            <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                            </svg>
                            Coffee Bean Ranker
                        </a>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('home') ? 'border-cream-300 text-cream-100' : 'border-transparent text-cream-300 hover:text-cream-100 hover:border-cream-400' }} text-sm font-medium">
                            Discover
                        </a>
                        <a href="{{ route('beans.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('beans.*') ? 'border-cream-300 text-cream-100' : 'border-transparent text-cream-300 hover:text-cream-100 hover:border-cream-400' }} text-sm font-medium">
                            Beans
                        </a>
                        <a href="{{ route('discussions.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('discussions.*') ? 'border-cream-300 text-cream-100' : 'border-transparent text-cream-300 hover:text-cream-100 hover:border-cream-400' }} text-sm font-medium">
                            Community
                        </a>
                    </div>
                </div>

                <!-- Right Side -->
                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <!-- User Dropdown -->
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm font-medium text-cream-300 hover:text-cream-100 focus:outline-none">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ auth()->user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}" alt="{{ auth()->user()->name }}">
                                <span class="ml-2">{{ auth()->user()->name }}</span>
                                <svg class="ml-1 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-1">
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-coffee-700 hover:bg-cream-100">My Dashboard</a>
                                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-coffee-700 hover:bg-cream-100">Profile</a>
                                    <a href="{{ route('journal.index') }}" class="block px-4 py-2 text-sm text-coffee-700 hover:bg-cream-100">My Coffee Journal</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-coffee-700 hover:bg-cream-100">
                                            Sign Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-cream-300 hover:text-cream-100 px-3 py-2 rounded-md text-sm font-medium">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="ml-4 bg-cream-600 hover:bg-cream-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Get Started
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex items-center sm:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-cream-400 hover:text-cream-100 hover:bg-coffee-700 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden" x-data="{ mobileMenuOpen: false }">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('home') ? 'border-cream-300 text-cream-100 bg-coffee-700' : 'border-transparent text-cream-300 hover:bg-coffee-700 hover:border-cream-400' }}">
                    Discover
                </a>
                <a href="{{ route('beans.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('beans.*') ? 'border-cream-300 text-cream-100 bg-coffee-700' : 'border-transparent text-cream-300 hover:bg-coffee-700 hover:border-cream-400' }}">
                    Beans
                </a>
                <a href="{{ route('discussions.index') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium {{ request()->routeIs('discussions.*') ? 'border-cream-300 text-cream-100 bg-coffee-700' : 'border-transparent text-cream-300 hover:bg-coffee-700 hover:border-cream-400' }}">
                    Community
                </a>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-coffee-900 text-cream-300 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-cream-100 font-bold text-lg mb-4">Coffee Bean Ranker</h3>
                    <p class="text-sm">Discover, track, and share your coffee journey with fellow enthusiasts.</p>
                </div>
                <div>
                    <h4 class="text-cream-100 font-semibold mb-4">Explore</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('beans.index') }}" class="hover:text-cream-100">Browse Beans</a></li>
                        <li><a href="{{ route('home') }}" class="hover:text-cream-100">Trending</a></li>
                        <li><a href="{{ route('discussions.index') }}" class="hover:text-cream-100">Community</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-cream-100 font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-cream-100">Brewing Guides</a></li>
                        <li><a href="#" class="hover:text-cream-100">Coffee Origins</a></li>
                        <li><a href="#" class="hover:text-cream-100">Roast Levels</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-cream-100 font-semibold mb-4">About</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-cream-100">About Us</a></li>
                        <li><a href="#" class="hover:text-cream-100">Contact</a></li>
                        <li><a href="#" class="hover:text-cream-100">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-coffee-800 mt-8 pt-8 text-sm text-center">
                <p>&copy; {{ date('Y') }} Coffee Bean Ranker. Built with Laravel & Tailwind CSS.</p>
            </div>
        </div>
    </footer>
</body>
</html>

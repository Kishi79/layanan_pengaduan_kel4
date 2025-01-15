<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <!-- Glassmorphism Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-200/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">P</span>
                        </div>
                        <span class="ml-2 text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                            Pengaduan
                        </span>
                    </a>

                    <!-- Primary Navigation -->
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}"
                           class="group relative inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <span>Dashboard</span>
                            <div class="absolute bottom-0 h-0.5 w-full transform scale-x-0 transition-transform group-hover:scale-x-100
                                {{ request()->routeIs('dashboard') ? 'bg-indigo-600 scale-x-100' : 'bg-gray-300' }}"></div>
                        </a>
                        <a href="{{ route('pengaduan.index') }}"
                           class="group relative inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('pengaduan.*') ? 'text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">
                            <span>Pengaduan</span>
                            <div class="absolute bottom-0 h-0.5 w-full transform scale-x-0 transition-transform group-hover:scale-x-100
                                {{ request()->routeIs('pengaduan.*') ? 'bg-indigo-600 scale-x-100' : 'bg-gray-300' }}"></div>
                        </a>
                    </div>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center space-x-3 px-3 py-2 rounded-full bg-white border border-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                                <span class="text-white font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 rounded-xl bg-white py-2 shadow-xl ring-1 ring-black ring-opacity-5">
                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="pt-16 min-h-screen">
        <main class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            @if(isset($header))
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $header }}</h1>
                @if(isset($description))
                <p class="mt-2 text-sm text-gray-600">{{ $description }}</p>
                @endif
            </div>
            @endif

            <!-- Alerts -->
            @if(session('success'))
                <div class="mb-6 rounded-lg bg-green-50 p-4 shadow-lg border border-green-200/50 backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 shadow-lg border border-red-200/50 backdrop-blur-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Content -->
            <div class="bg-white/60 backdrop-blur-lg shadow-xl rounded-2xl border border-gray-200/50">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Footer -->
    <footer class="bg-white/80 backdrop-blur-md border-t border-gray-200/50 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500">
                    © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Terms</span>
                        Terms & Conditions
                    </a>
                    <a href="#" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Privacy</span>
                        Privacy Policy
                    </a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>

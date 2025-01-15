<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-indigo-700 transition duration-300">
            <div class="flex items-center justify-center h-16 bg-indigo-800">
                <span class="text-white text-2xl font-bold">Admin Panel</span>
            </div>

            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="{{ request()->routeIs('admin.dashboard') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}
                              flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.pengaduan.index') }}"
                       class="{{ request()->routeIs('admin.pengaduan.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}
                              flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Pengaduan
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="{{ request()->routeIs('admin.users.*') ? 'bg-indigo-800 text-white' : 'text-indigo-100 hover:bg-indigo-800' }}
                              flex items-center px-4 py-3 text-sm font-medium rounded-lg transition duration-150">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Users
                    </a>
                </div>
            </nav>
        </div>
        <div class="pl-64">
            <div class="bg-white shadow-sm">
                <div class="flex justify-between items-center px-8 py-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                        <p class="mt-1 text-sm text-gray-600">@yield('subtitle')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-600">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <main class="p-8 bg-gray-50 min-h-screen">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

@extends('layouts.app')

@section('content')
<div class="p-6">
    <!-- Welcome Banner -->
    <div class="relative bg-indigo-600 rounded-3xl p-8 overflow-hidden">
        <div class="absolute right-0 top-0 -mt-10 -mr-10">
            <svg width="200" height="200" viewBox="0 0 200 200" fill="none">
                <defs>
                    <linearGradient id="paint0_linear" x1="0" y1="0" x2="200" y2="200" gradientUnits="userSpaceOnUse">
                        <stop stop-color="white" stop-opacity="0.2"/>
                        <stop offset="1" stop-color="white" stop-opacity="0"/>
                    </linearGradient>
                </defs>
                <circle cx="100" cy="100" r="100" fill="url(#paint0_linear)"/>
            </svg>
        </div>
        <div class="relative">
            <h1 class="text-white text-3xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
            <p class="mt-2 text-indigo-100">Pantau pengaduan Anda dan buat pengaduan baru dengan mudah.</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Total Pengaduan -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-xl bg-indigo-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Pengaduan</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $totalPengaduan }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Diproses -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-xl bg-yellow-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Sedang Diproses</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $pengaduanDiproses }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengaduan Selesai -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 rounded-xl bg-green-500 p-3">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">{{ $pengaduanSelesai }}</div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Pengaduan -->
    <div class="mt-8">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-medium text-gray-900">Pengaduan Terbaru</h2>
            <a href="{{ route('pengaduan.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Lihat Semua
            </a>
        </div>
        <div class="mt-4 bg-white shadow-sm rounded-xl divide-y divide-gray-200">
            @forelse($recentPengaduans as $pengaduan)
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $pengaduan->status === 'Menunggu Tanggapan' ? 'bg-yellow-100 text-yellow-800' :
                                   ($pengaduan->status === 'Diproses' ? 'bg-blue-100 text-blue-800' :
                                   'bg-green-100 text-green-800') }}">
                                {{ $pengaduan->status }}
                            </span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-sm font-medium text-gray-900">{{ $pengaduan->judul }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($pengaduan->deskripsi, 100) }}</p>
                        </div>
                    </div>
                    <div class="ml-6">
                        <a href="{{ route('pengaduan.show', $pengaduan) }}"
                           class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Detail
                        </a>
                    </div>
                </div>
                <div class="mt-4 text-sm text-gray-500">
                    {{ $pengaduan->created_at->diffForHumans() }} • Tiket #{{ $pengaduan->nomor_tiket }}
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-gray-500">
                Belum ada pengaduan.
                <a href="{{ route('pengaduan.create') }}" class="text-indigo-600 hover:text-indigo-500">
                    Buat pengaduan baru
                </a>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <h2 class="text-lg font-medium text-gray-900">Aksi Cepat</h2>
        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
            <a href="{{ route('pengaduan.create') }}"
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">Buat Pengaduan Baru</p>
                    <p class="text-sm text-gray-500">Sampaikan keluhan atau saran Anda</p>
                </div>
            </a>

            <a href="{{ route('profile.edit') }}"
               class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <span class="absolute inset-0" aria-hidden="true"></span>
                    <p class="text-sm font-medium text-gray-900">Edit Profil</p>
                    <p class="text-sm text-gray-500">Perbarui informasi akun Anda</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

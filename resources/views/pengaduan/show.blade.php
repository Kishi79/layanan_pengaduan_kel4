@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Detail Pengaduan</h2>
                    <p class="mt-1 text-sm text-gray-600">
                        Nomor Tiket: {{ $pengaduan->nomor_tiket }}
                    </p>
                </div>

                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:px-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $pengaduan->judul }}
                                </h3>
                                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                    Dibuat pada {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $pengaduan->status === 'Menunggu Tanggapan' ? 'bg-yellow-100 text-yellow-800' :
                                       ($pengaduan->status === 'Diproses' ? 'bg-blue-100 text-blue-800' :
                                       'bg-green-100 text-green-800') }}">
                                    {{ $pengaduan->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-200">
                        <dl>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Deskripsi
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $pengaduan->deskripsi }}
                                </dd>
                            </div>
                            @if($pengaduan->lampiran)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    Lampiran
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <a href="{{ Storage::url('public/lampiran/' . $pengaduan->lampiran) }}"
                                       target="_blank"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Lihat Lampiran
                                    </a>
                                </dd>
                            </div>
                            @endif
                        </dl>
                    </div>
                </div>

                @if($pengaduan->tanggapans->count() > 0)
                <div class="mt-6">
                    <h3 class="text-lg font-medium text-gray-900">Tanggapan</h3>
                    <div class="mt-4 space-y-4">
                        @foreach($pengaduan->tanggapans as $tanggapan)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">{{ $tanggapan->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $tanggapan->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $tanggapan->tanggapan }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('pengaduan.index') }}"
                       class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

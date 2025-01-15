@extends('layouts.admin')

@section('header')
    Detail Pengaduan
@endsection

@section('content')
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Detail Pengaduan #{{ $pengaduan->nomor_tiket }}</h2>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-100 border border-green-400 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Informasi Pelapor</h3>
                    <div class="mt-2 space-y-2">
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">Nama:</span> {{ $pengaduan->user->name }}
                        </p>
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">Email:</span> {{ $pengaduan->user->email }}
                        </p>
                        <p class="text-sm text-gray-900">
                            <span class="font-medium">Tanggal Laporan:</span> {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Status Pengaduan</h3>
                    <form action="{{ route('admin.pengaduan.status', $pengaduan) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="Menunggu Tanggapan" {{ $pengaduan->status === 'Menunggu Tanggapan' ? 'selected' : '' }}>
                                Menunggu Tanggapan
                            </option>
                            <option value="Diproses" {{ $pengaduan->status === 'Diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="Selesai" {{ $pengaduan->status === 'Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-500">Detail Pengaduan</h3>
                <div class="mt-2 space-y-4">
                    <p class="text-sm text-gray-900">
                        <span class="font-medium">Judul:</span> {{ $pengaduan->judul }}
                    </p>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Deskripsi:</span>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                    </div>
                    @if($pengaduan->lampiran)
                        <div>
                            <span class="text-sm font-medium text-gray-500">Lampiran:</span>
                            <div class="mt-1">
                                <a href="{{ Storage::url('public/lampiran/' . $pengaduan->lampiran) }}"
                                   target="_blank"
                                   class="text-indigo-600 hover:text-indigo-900 text-sm">
                                    Lihat Lampiran
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-sm font-medium text-gray-500">Tanggapan</h3>
                <div class="mt-4 space-y-4">
                    @forelse($pengaduan->tanggapans as $tanggapan)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-900">{{ $tanggapan->user->name }}</span>
                                <span class="text-sm text-gray-500">{{ $tanggapan->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-700 whitespace-pre-line">{{ $tanggapan->tanggapan }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada tanggapan</p>
                    @endforelse

                    <form action="{{ route('admin.pengaduan.tanggapan', $pengaduan) }}" method="POST" class="mt-4">
                        @csrf
                        <div>
                            <label for="tanggapan" class="block text-sm font-medium text-gray-700">
                                Tambah Tanggapan
                            </label>
                            <div class="mt-1">
                                <textarea id="tanggapan"
                                          name="tanggapan"
                                          rows="3"
                                          class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                                          required></textarea>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Kirim Tanggapan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

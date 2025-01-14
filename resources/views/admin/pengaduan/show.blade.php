<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengaduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Pengaduan</h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nomor Tiket</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->nomor_tiket }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pelapor</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST" class="mt-1 inline-flex">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="Menunggu Tanggapan" {{ $pengaduan->status === 'Menunggu Tanggapan' ? 'selected' : '' }}>Menunggu Tanggapan</option>
                                        <option value="Diproses" {{ $pengaduan->status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" {{ $pengaduan->status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Judul</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $pengaduan->judul }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                            </div>

                            @if($pengaduan->lampiran)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lampiran</label>
                                <div class="mt-1">
                                    <a href="{{ Storage::url('public/lampiran/' . $pengaduan->lampiran) }}" 
                                       target="_blank"
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Lihat Lampiran
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Tanggapan</h3>
                        <div class="mt-4 space-y-4">
                            @foreach($pengaduan->tanggapans as $tanggapan)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $tanggapan->user->name }}</span>
                                        <span class="text-sm text-gray-500">{{ $tanggapan->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $tanggapan->tanggapan }}</p>
                                </div>
                            @endforeach

                            <form action="{{ route('admin.pengaduan.tanggapan', $pengaduan) }}" method="POST" class="mt-4">
                                @csrf
                                <div>
                                    <label for="tanggapan" class="block text-sm
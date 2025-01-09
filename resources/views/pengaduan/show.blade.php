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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Nomor Tiket</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $pengaduan->nomor_tiket }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Status</h3>
                        <p class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $pengaduan->status === 'Menunggu Tanggapan' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($pengaduan->status === 'Diproses' ? 'bg-blue-100 text-blue-800' : 
                                   'bg-green-100 text-green-800') }}">
                                {{ $pengaduan->status }}
                            </span>
                        </p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Judul</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $pengaduan->judul }}</p>
                    </div>

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Deskripsi</h3>
                        <p class="mt-1 text-sm text-gray-600 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                    </div>

                    @if($pengaduan->lampiran)
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Lampiran</h3>
                        <div class="mt-1">
                            <a href="{{ Storage::url('public/lampiran/' . $pengaduan->lampiran) }}"
                                target="_blank"
                                class="text-blue-600 hover:text-blue-900">
                                Lihat Lampiran
                            </a>
                        </div>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Tanggal Dibuat</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('pengaduan.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            Kembali
                        </a>
                        <a href="{{ route('pengaduan.edit', $pengaduan) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Pengaduan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

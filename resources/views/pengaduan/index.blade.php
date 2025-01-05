@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4" align="center">Daftar Pengaduan</h1>
    <!-- <a href="{{ route('pengaduan.create') }}" class="btn btn-primary mb-3">Buat Pengaduan</a> -->
    <table class="table table-bordered">
    <thead align="center">
    <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Nomor Tiket</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduans as $pengaduan)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pengaduan->judul }}</td>
                    <td>{{ $pengaduan->nomor_tiket }}</td>
                    <td>
                        <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('pengaduan.edit', $pengaduan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('pengaduan.destroy', $pengaduan->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus pengaduan ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

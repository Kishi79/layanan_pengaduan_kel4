@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detail Pengaduan</h1>
    <div class="card">
        <div class="card-header">
            {{ $pengaduan->judul }}
        </div>
        <div class="card-body">
            <p><strong>Nomor Tiket:</strong> {{ $pengaduan->nomor_tiket }}</p>
            <p><strong>Deskripsi:</strong></p>
            <p>{{ $pengaduan->deskripsi }}</p>
            <p><strong>Status:</strong> {{ $pengaduan->status }}</p>
        </div>
    </div>
    <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection

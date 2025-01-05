@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Pengaduan</h1>
    <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $pengaduan->judul }}" required>
        </div>
        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ $pengaduan->deskripsi }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

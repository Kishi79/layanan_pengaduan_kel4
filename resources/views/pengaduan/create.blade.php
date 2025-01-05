<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-danger text-white text-center">
                <h4>Form Pengaduan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul *</label>
                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Masukkan judul pengaduan" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi *</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pengaduan" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Lampiran</label>
                        <input type="file" class="form-control" id="lampiran" name="lampiran" accept="image/*,application/pdf">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger px-5">Kirim Pengaduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

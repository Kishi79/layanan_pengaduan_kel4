<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="path-to-logo.png" alt="" width="30" height="30">
            
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Tentang</a>
                </li> -->
                 <!-- Tombol Buat -->
                 <li class="nav-item">
                    <a href="{{ route('pengaduan.create') }}" class="btn btn-danger">Buat</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="btn btn-outline-primary" href="/login">Masuk</a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-primary ms-2" href="/register">Daftar</a> -->
                </li>
            </ul>
        </div>
    </div>
</nav>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan WhatsApp & Passcode - Admin Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/menu">⚙️ Panel Admin Restoran</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white" href="/menu">Kelola Menu</a>
                <a class="nav-link text-warning active" href="/menu/setting">⚙️ Pengaturan WA & PIN</a>
                <a class="nav-link text-warning" href="/katalog" target="_blank">🌐 Lihat Katalog Publik</a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4 border-0 rounded-3">
                    <h3 class="mb-3 text-center">📱 Pengaturan Admin</h3>
                    <p class="text-muted text-center small mb-4">Atur nomor tujuan WhatsApp checkout dan PIN rahasia untuk masuk ke panel admin.</p>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('menu.updatesetting') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor WhatsApp Admin</label>
                            <input type="text" name="no_whatsapp" class="form-control" value="{{ $setting->no_whatsapp ?? '6281234567890' }}" required>
                            <small class="text-muted">Format internasional tanpa tanda plus (+), contoh: <b>6281234567890</b>.</small>
                        </div>

                        <!-- TAMBAHAN INPUT PASSCODE -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Passcode / PIN Masuk Admin</label>
                            <input type="text" name="passcode" class="form-control" value="{{ $setting->passcode ?? '123456' }}" required>
                            <small class="text-muted">PIN rahasia yang digunakan untuk masuk ke panel admin dari halaman katalog.</small>
                        </div>

<!-- TAMBAHAN INPUT PENGATURAN BANNER -->
                        <hr class="my-4">
                        <h5 class="fw-bold mb-3">🎨 Pengaturan Teks Banner Katalog</h5>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Judul Utama Banner</label>
                            <input type="text" name="banner_title" class="form-control" value="{{ $setting->banner_title ?? 'Selamat Datang' }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Sub-Judul / Keterangan Banner</label>
                            <input type="text" name="banner_subtitle" class="form-control" value="{{ $setting->banner_subtitle ?? 'Pilih menu favoritmu di bawah dan pesan langsung via WhatsApp dengan mudah!' }}" required>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="/menu" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
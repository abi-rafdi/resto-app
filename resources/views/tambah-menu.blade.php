<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu Restoran</title>
    <!-- Kita pakai Bootstrap biar tampilannya rapi otomatis -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h3 class="mb-4 text-center">Tambah Menu Restoran Baru</h3>

                    <!-- Pesan Sukses jika data berhasil disimpan -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf <!-- Pengaman wajib di Laravel -->

                        <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Goreng Spesial" required>
                        </div>

                        <!-- TAMBAHAN: Pilihan Kategori Menu -->
                        <div class="mb-3">
                            <label class="form-label">Kategori Menu</label>
                            <select name="kategori" class="form-select" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Makanan">Makanan</option>
                                <option value="Minuman">Minuman</option>
                                <option value="Snack">Snack</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" placeholder="Contoh: 20000" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Contoh: Nasi goreng dengan telur dan suwiran ayam"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Menu</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/menu" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
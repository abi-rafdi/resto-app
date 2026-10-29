<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm p-4">
                    <h3 class="mb-4 text-center">Edit Menu Restoran</h3>

                    <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') 
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
                        </div>

                        <!-- TAMBAHAN: Pilihan Kategori Menu -->
                        <div class="mb-3">
                            <label class="form-label">Kategori Menu</label>
                            <select name="kategori" class="form-select" required>
                                <option value="Makanan" {{ $menu->kategori == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                                <option value="Minuman" {{ $menu->kategori == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                                <option value="Snack" {{ $menu->kategori == 'Snack' ? 'selected' : '' }}>Snack</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Singkat</label>
                            <textarea name="deskripsi" class="form-control" rows="3">{{ $menu->deskripsi }}</textarea>
                        </div>

                        <!-- Bagian Foto Menu -->
                        <div class="mb-3">
                            <label class="form-label">Foto Menu Saat Ini:</label>
                            <div class="mb-2">
                                @if($menu->gambar)
                                    <div class="p-2 border rounded bg-white d-inline-block">
                                        <img src="{{ asset('images/' . $menu->gambar) }}" alt="Preview" style="width: 100px; height: 100px; object-fit: cover; border-radius: 6px;">
                                    </div>
                                @else
                                    <p class="text-muted small fst-italic">Belum ada foto yang diunggah.</p>
                                @endif
                            </div>

                            <label class="form-label mt-2">Ganti / Unggah Foto Baru (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto.</small>
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
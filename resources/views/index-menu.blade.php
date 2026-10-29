<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navbar Khusus Admin -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/menu"> Panel Admin Restoran</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link text-white active" href="/menu">Kelola Menu</a>
                <a class="nav-link text-warning" href="/menu/setting"> Pengaturan Admin</a>
                <a class="nav-link text-warning" href="/katalog" target="_blank"> Lihat Katalog Publik</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Menu Restoran</h2>
            <a href="/tambah-menu" class="btn btn-primary fw-bold">+ Tambah Menu Baru</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- FORM PENCARIAN DI PANEL ADMIN -->
        <div class="row mb-4">
            <div class="col-md-5">
                <form action="{{ url('/menu') }}" method="GET" class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama menu atau kategori..." value="{{ $search ?? '' }}">
                    <button class="btn btn-dark px-3 fw-bold" type="submit">🔍 Cari</button>
                    @if(isset($search) && $search)
                        <a href="{{ url('/menu') }}" class="btn btn-secondary">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="card shadow-sm p-3 border-0">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Deskripsi</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $index => $menu)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if($menu->gambar)
                                <img src="{{ asset('images/' . $menu->gambar) }}" alt="" style="width: 45px; height: 45px; object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted small">Tidak ada</span>
                            @endif
                        </td>
                        <td><strong>{{ $menu->nama_menu }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $menu->kategori ?? 'Umum' }}</span></td>
                        <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td>
                            <!-- TOMBOL UBAH STATUS -->
                            <form action="{{ route('menu.toggleStatus', $menu->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                @if(($menu->status ?? 'Tersedia') === 'Tersedia')
                                    <button type="submit" class="btn btn-success btn-sm fw-bold px-3" title="Klik untuk ubah jadi Habis">Tersedia</button>
                                @else
                                    <button type="submit" class="btn btn-secondary btn-sm fw-bold px-3" title="Klik untuk ubah jadi Tersedia">Habis</button>
                                @endif
                            </form>
                        </td>
                        <td>{{ $menu->deskripsi ?? '-' }}</td>
                        <td class="text-center">
                            <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning btn-sm fw-bold">Edit</a>
                            
                            <form action="{{ route('menu.destroy', $menu->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm fw-bold">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">Belum ada menu yang ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
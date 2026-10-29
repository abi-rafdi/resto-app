<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Menu Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-custom { background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .hero-section { background: linear-gradient(135deg, #ff7e5f, #feb47b); color: white; border-radius: 15px; padding: 30px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .card { border: none; border-radius: 12px; transition: transform 0.2s, box-shadow 0.2s; overflow: hidden; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 20px rgba(0,0,0,0.12); }
        .card-img-top { height: 160px; object-fit: cover; cursor: pointer; transition: opacity 0.2s; }
        .card-img-top:hover { opacity: 0.9; }
    </style>
</head>
<body>
    <!-- Navbar Publik (Bebas Akses Tanpa Login, Tanpa Jejak Admin) -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top py-3 mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-danger" href="/katalog"> Menu </a>
            <div class="d-flex align-items-center">
                <span class="navbar-text small text-muted me-3 d-none d-md-inline">
                    Pesan Cepat & Praktis via WhatsApp
                </span>
                <!-- Tombol Rahasia Masuk Admin -->
                <button class="btn btn-sm btn-outline-secondary border-0 text-muted" data-bs-toggle="modal" data-bs-target="#adminLoginModal" title="Login Admin">
                    🔒 Admin
                </button>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <!-- Banner Header Cantik (Dinamis dari Admin) -->
        <div class="hero-section text-center">
            <h1 class="fw-bold mb-2">{{ $bannerTitle }}</h1>
            <p class="mb-0">{{ $bannerSubtitle }}</p>
        </div>
<!-- NOTIFIKASI ERROR JIKA PASSCODE SALAH -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- FORM PENCARIAN MENU -->
        <div class="row mb-4">
            <div class="col-md-6 mx-auto">
                <form action="{{ url('/katalog') }}" method="GET" class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control form-control-lg border-0" placeholder="Cari nama makanan atau minuman..." value="{{ $search ?? '' }}">
                    <button class="btn btn-danger px-4 fw-bold" type="submit">Cari</button>
                    @if(isset($search) &&$search)
                        <a href="{{ url('/katalog') }}" class="btn btn-secondary d-flex align-items-center">Reset</a>
                    @endif
                </form>
            </div>
        </div>
        <!-- AKHIR FORM PENCARIAN -->
        
        <div class="row">
            <!-- Daftar Menu Berdasarkan Kategori -->
            <div class="col-lg-8 mb-4">
                @forelse($menus as $kategori =>$menuList)
                    <div class="mb-5">
                        <!-- Judul Kategori Berdasarkan Nama Kategorinya -->
                        <h4 class="fw-bold text-dark border-bottom pb-2 mb-3">
                            {{ $kategori }}
                        </h4>

                        <div class="row">
                            @foreach($menuList as $menu)
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 shadow-sm">
                                    @if($menu->gambar)
                                        <!-- GAMBAR BISA DIKLIK UNTUK PREVIEW -->
                                        <img src="{{ asset('images/' . $menu->gambar) }}" class="card-img-top" alt="{{ $menu->nama_menu }}" title="Klik untuk memperbesar foto" onclick="bukaModalGambar('{{ asset('images/' . $menu->gambar) }}', '{{$menu->nama_menu }}')">
                                    @else
                                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center card-img-top small">
                                            Tidak Ada Foto
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title fw-bold text-dark">{{ $menu->nama_menu }}</h5>
                                        <h6 class="text-danger fw-bold mb-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h6>
                                        <p class="card-text text-muted small flex-grow-1">{{ $menu->deskripsi ?? 'Menu spesial siap disajikan.' }}</p>
                                        
                                        <!-- CEK STATUS KETERSEDIAAN MENU -->
                                        @if(($menu->status ?? 'Tersedia') === 'Tersedia')
                                            <button type="button" class="btn btn-outline-success btn-sm w-100 fw-bold mt-2" 
                                                onclick="tambahKeKeranjang('{{ $menu->nama_menu }}', {{$menu->harga }})">
                                                + Tambah ke Pesanan
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm w-100 fw-bold mt-2" disabled>
                                                ❌ Stok Habis
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <p class="text-muted">Belum ada menu yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Keranjang & Checkout WhatsApp -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top p-3" style="top: 80px; border-radius: 12px;">
                    <div class="card-body p-0">
                        <h4 class="card-title mb-3 fw-bold text-dark">Keranjang Pesanan</h4>
                        <ul id="list-keranjang" class="list-group mb-3">
                            <li class="list-group-item text-muted text-center border-0 bg-light py-3 rounded">Keranjang masih kosong</li>
                        </ul>
                        <div class="d-flex justify-content-between mb-3 fw-bold fs-5 border-top pt-2">
                            <span>Total:</span>
                            <span id="total-harga" class="text-success">Rp 0</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Pemesan:</label>
                            <input type="text" id="nama-pemesan" class="form-control" placeholder="Contoh: Budi Santoso">
                        </div>

                        <button type="button" class="btn btn-success w-100 py-2 fw-bold shadow-sm" onclick="checkoutWhatsApp()">
                             Checkout via WhatsApp
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL POPUP PREVIEW GAMBAR -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg bg-dark text-white">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold" id="imageModalLabel">Detail Foto Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center p-3">
                    <img id="modalImageSrc" src="" alt="Preview Gambar" class="img-fluid rounded" style="max-height: 75vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (Wajib untuk Modal Bootstrap) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script Keranjang & WhatsApp -->
    <script>
        let keranjang = [];

        function tambahKeKeranjang(nama, harga) {
            let item = keranjang.find(p => p.nama === nama);
            if (item) {
                item.qty++;
            } else {
                keranjang.push({ nama: nama, harga: harga, qty: 1 });
            }
            updateTampilanKeranjang();
        }

        function updateTampilanKeranjang() {
            let list = document.getElementById('list-keranjang');
            let totalHargaEl = document.getElementById('total-harga');
            list.innerHTML = '';
            
            if (keranjang.length === 0) {
                list.innerHTML = '<li class="list-group-item text-muted text-center border-0 bg-light py-3 rounded">Keranjang masih kosong</li>';
                totalHargaEl.innerText = 'Rp 0';
                return;
            }

            let total = 0;
            keranjang.forEach((item, index) => {
                let subtotal = item.harga * item.qty;
                total += subtotal;
                list.innerHTML += `
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 border-bottom py-2">
                        <div>
                            <h6 class="my-0 fw-bold" style="font-size: 14px;">${item.nama}</h6>
                            <small class="text-muted">${item.qty} x Rp ${item.harga.toLocaleString()}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger border-0" onclick="hapusItem(${index})">&times;</button>
                    </li>
                `;
            });
            totalHargaEl.innerText = 'Rp ' + total.toLocaleString();
        }

        function hapusItem(index) {
            keranjang.splice(index, 1);
            updateTampilanKeranjang();
        }

        function checkoutWhatsApp() {
            let nama = document.getElementById('nama-pemesan').value.trim();
            if (!nama) {
                alert('Mohon masukkan nama pemesan terlebih dahulu!');
                return;
            }
            if (keranjang.length === 0) {
                alert('Keranjang masih kosong, pilih menu terlebih dahulu!');
                return;
            }

            let pesan = `Halo Admin, saya ingin memesan:\n\n*Nama Pemesan:* ${nama}\n\n*Pesanan:* \n`;
            let total = 0;
            keranjang.forEach(item => {
                let subtotal = item.harga * item.qty;
                total += subtotal;
                pesan += `- ${item.nama} (${item.qty}x) = Rp ${subtotal.toLocaleString()}\n`;
            });
            pesan += `\n*Total Pembayaran: Rp ${total.toLocaleString()}*\n\nMohon segera diproses ya, terima kasih!`;

            let noWhatsApp = '{{ $noWhatsApp }}'; 
            let urlWA = `https://wa.me/${noWhatsApp}?text=${encodeURIComponent(pesan)}`;
            window.open(urlWA, '_blank');
        }

        // Fungsi untuk membuka modal preview gambar ukuran penuh
        function bukaModalGambar(url, nama) {
            document.getElementById('imageModalLabel').innerText = 'Foto: ' + nama;
            document.getElementById('modalImageSrc').src = url;
            var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
            myModal.show();
        }
    </script>
    <!-- MODAL LOGIN ADMIN DENGAN PASSCODE -->
    <div class="modal fade" id="adminLoginModal" tabindex="-1" aria-labelledby="adminLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header bg-dark text-white rounded-top-4">
                    <h5 class="modal-title fs-6 fw-bold" id="adminLoginModalLabel">🔐 Login Panel Admin</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.verify') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Masukkan Passcode Admin</label>
                            <input type="password" name="passcode" class="form-control text-center fs-5" placeholder="••••••" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 fw-bold py-2 shadow-sm">Masuk ke Admin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
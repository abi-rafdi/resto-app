#  Restoran Management System (Laravel)

Aplikasi web manajemen restoran modern berbasis **Laravel v10** yang dilengkapi dengan panel admin terproteksi PIN (*passcode*) dan katalog menu publik interaktif dengan fitur keranjang belanja dan pemesanan langsung via **WhatsApp**.

---

##  Fitur Utama

###  Panel Admin (Restoran Management)
* **Manajemen Menu (CRUD)**: Tambah, edit, hapus menu lengkap dengan unggah foto (*image upload*).
* **Pengaturan Dinamis (`/menu/setting`)**: 
  * Mengubah nomor WhatsApp tujuan *checkout* secara *real-time*.
  * Mengatur PIN / *Passcode* keamanan untuk akses masuk admin dari halaman katalog.
  * Mengubah Judul dan Teks Banner sambutan di halaman katalog secara langsung dari database.
* **Status Ketersediaan Stok**: Tombol *toggle* interaktif (*Tersedia / Habis*) yang langsung memperbarui status menu di sisi pelanggan.
* **Pencarian & Pengurutan**: Fitur pencarian menu dan pengurutan kategori secara alfabetis (A-Z).

###  Katalog Publik (Sisi Pelanggan)
* **Akses Bebas & Aman**: Pelanggan dapat melihat katalog dan memesan tanpa perlu login. Akses admin tersembunyi di balik tombol gembok ber-PIN.
* **Pencarian Cepat**: Kolom pencarian untuk memudahkan pelanggan mencari makanan atau minuman.
* **Kategori & Abjad Tersusun Rapi**: Menu dikelompokkan berdasarkan kategori dan diurutkan secara rapi (A-Z).
* **Preview Foto (Lightbox/Modal)**: Klik pada foto menu untuk memperbesar gambar dalam ukuran penuh.
* **Keranjang & Checkout WhatsApp**: Keranjang belanja interaktif yang otomatis menghitung total harga dan langsung mengarahkan pesanan ke WhatsApp admin.

---

##  Teknologi yang Digunakan
* **Backend**: Laravel v10 (PHP)
* **Database**: MySQL
* **Frontend**: Bootstrap 5, Blade Template, JavaScript (Vanilla JS)

---

##  Cara Instalasi & Menjalankan Proyek (Lokal)

Jika kamu ingin menjalankan ulang proyek ini di komputer lain, ikuti langkah-langkah berikut:

1. **Clone repositori ini**:
   ```bash
   git clone [https://github.com/abi-rafdi/resto-app.git](https://github.com/abi-rafdi/resto-app.git)
   cd resto-app

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
Cara Instalasi & Menjalankan Proyek di Komputer Lain

Ikuti langkah-langkah detail berikut jika ingin menjalankan proyek ini di komputer baru:

### 1. Persiapan Awal (Prasyarat)
Pastikan komputer sudah terinstall:
* **PHP v8.1+** & **XAMPP** (atau web server sejenis)
* **Composer**
* **Git**

  ### 2. Langkah-Langkah Instalasi

1. **Clone Repositori ini**  
   Buka Terminal/CMD, lalu jalankan:
   ```bash
   git clone [https://github.com/abi-rafdi/resto-app.git](https://github.com/USERNAME-KAMU/resto-app.git)
   cd resto-app

1. Install Dependensi Laravel

Jalankan perintah Composer untuk mengunduh kembali folder vendor:
composer install

2. Buat File Konfigurasi Environment (.env)

Copy file contoh .env.example menjadi .env:

Di Windows (CMD):
copy .env.example .env

Di Git Bash / Terminal / Linux / Mac:
cp .env.example .env

3.Generate Application Key

Buat enkripsi kunci aplikasi Laravel:
php artisan key:generate

4. Buat & Setting Database MySQL

Nyalakan Apache dan MySQL di XAMPP Control Panel.

Buka browser dan pergi ke http://localhost/phpmyadmin.

Buat database baru dengan nama: resto_db (atau nama pilihanmu).

Buka file .env di editor teks (VS Code), lalu sesuaikan konfigurasi databasenya:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=resto_db
DB_USERNAME=root
DB_PASSWORD=

5.Jalankan Migration Database

Buat seluruh tabel yang dibutuhkan otomatis di MySQL:
php artisan migrate

6.Jalankan Server Lokal
php artisan serve

7.Buka Aplikasi di Browser

Katalog Publik (Sisi Pelanggan): http://127.0.0.1:8000/katalog

Panel Admin: Klik tombol 🔒 Admin di kanan atas katalog, lalu masukkan Passcode default: 12345.




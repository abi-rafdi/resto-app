<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Setting;

class MenuController extends Controller
{
  // Menampilkan daftar semua menu di panel admin (dengan pencarian & pengurutan kategori)
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Menu::query();

        if ($search) {
            $query->where('nama_menu', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
        }

        // Urutkan berdasarkan Kategori terlebih dahulu (abjad), lalu Nama Menu
        $menus = $query->orderBy('kategori', 'asc')
                       ->orderBy('nama_menu', 'asc')
                       ->get();

        return view('index-menu', compact('menus', 'search'));
    }

    // Menampilkan halaman form tambah menu
    public function create()
    {
        return view('tambah-menu');
    }

    // Menyimpan data baru ke database (dengan upload gambar & kategori)
    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $namaFileGambar = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFileGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namaFileGambar);
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFileGambar,
        ]);

        return redirect()->back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    // Menampilkan form edit dengan data menu yang dipilih
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('edit-menu', compact('menu'));
    }

    // Menyimpan perubahan data ke database (termasuk update gambar & kategori)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $menu = Menu::findOrFail($id);
        
        $namaFileGambar = $menu->gambar; 
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFileGambar = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $namaFileGambar);

            // Hapus gambar lama jika ada
            if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
                unlink(public_path('images/' . $menu->gambar));
            }
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'gambar' => $namaFileGambar,
        ]);

        return redirect('/menu')->with('success', 'Menu berhasil diperbarui!');
    }

    // Fitur Hapus Menu
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        
        // Hapus file gambar fisik jika ada
        if ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return redirect('/menu')->with('success', 'Menu berhasil dihapus!');
    }
    
   // Menampilkan katalog menu untuk pelanggan (dengan banner dinamis dari database)
    public function katalog(Request $request)
    {
        $search = $request->input('search');

        $query = Menu::query();

        if ($search) {
            $query->where('nama_menu', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
        }

        // Urutkan kategori dan nama menu secara alfabetis (A-Z)
        $menus = $query->orderBy('kategori', 'asc')
                       ->orderBy('nama_menu', 'asc')
                       ->get()
                       ->groupBy('kategori');
                       
        $setting = Setting::first();
        $noWhatsApp = $setting ? $setting->no_whatsapp : '6281234567890';
        
        // Ambil teks banner dari database (jika kosong, gunakan teks default)
        $bannerTitle = $setting && $setting->banner_title ? $setting->banner_title : 'Selamat Datang';
        $bannerSubtitle = $setting && $setting->banner_subtitle ? $setting->banner_subtitle : 'Pilih menu favoritmu di bawah dan pesan langsung via WhatsApp dengan mudah!';
        
        return view('katalog', compact('menus', 'noWhatsApp', 'bannerTitle', 'bannerSubtitle', 'search'));
    }

    // Menampilkan halaman pengaturan WhatsApp, Passcode, & Banner
    public function editSetting()
    {
        $setting = Setting::first();
        return view('setting', compact('setting'));
    }

    // Menyimpan perubahan nomor WhatsApp, Passcode, & Teks Banner Admin
    public function updateSetting(Request $request)
    {
        $request->validate([
            'no_whatsapp' => 'required',
            'passcode' => 'required',
            'banner_title' => 'required',
            'banner_subtitle' => 'required',
        ]);

        $setting = Setting::find(1);
        
        if ($setting) {
            $setting->no_whatsapp = $request->no_whatsapp;
            $setting->passcode = $request->passcode;
            $setting->banner_title = $request->banner_title;
            $setting->banner_subtitle = $request->banner_subtitle;
            $setting->save();
        } else {
            Setting::create([
                'id' => 1,
                'no_whatsapp' => $request->no_whatsapp,
                'passcode' => $request->passcode,
                'banner_title' => $request->banner_title,
                'banner_subtitle' => $request->banner_subtitle,
            ]);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    // Memverifikasi passcode yang dimasukkan dari katalog
    public function verifyPasscode(Request $request)
    {
        $setting = Setting::first();
        $savedPasscode = $setting ? $setting->passcode : '123456'; // Default passcode

        if ($request->passcode === $savedPasscode) {
            return redirect('/menu')->with('success', 'Selamat datang kembali, Admin!');
        }

        return redirect('/katalog')->with('error', 'Passcode admin salah!');
    }

    // Fitur Mengubah Status Ketersediaan Menu (Tersedia / Habis)
    public function toggleStatus($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->status = ($menu->status === 'Tersedia') ? 'Habis' : 'Tersedia';
        $menu->save();

        return redirect()->back()->with('success', 'Status menu ' . $menu->nama_menu . ' berhasil diperbarui!');
    }
}
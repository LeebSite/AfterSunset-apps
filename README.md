
# 🌇 After Sunset.idn - Sistem Manajemen Angkringan UMKM

![Laravel](https://img.shields.io/badge/Built%20With-Laravel-red)
![License](https://img.shields.io/github/license/yourusername/aftersunset)
![Status](https://img.shields.io/badge/status-active-success)
![Version](https://img.shields.io/badge/version-1.0.0-blue)

**After Sunset** adalah sistem informasi berbasis web untuk membantu digitalisasi manajemen usaha Angkringan lokal, dikembangkan oleh tim [aftersunset.idn](https://aftersunset.idn). Sistem ini dibuat menggunakan Laravel Framework dan ditujukan untuk mendukung pelaku UMKM agar lebih modern, efisien, dan aman dalam mengelola usaha.

---  

## 🚀 Fitur Utama

✅ **Manajemen Produk**  
Kelola menu makanan & minuman dengan harga, kategori, dan stok.

✅ **Pencatatan Transaksi**  
Pencatatan penjualan secara real-time dengan detail pesanan dan metode pembayaran.

✅ **Log Aktivitas Pengguna**  
Sistem keamanan accountability dengan pencatatan log aktivitas lengkap (login, logout, gagal login, dll).

✅ **Multi Role**  
Role-based access untuk Admin, Karyawan, dan Member dengan fitur yang berbeda-beda.

✅ **Autentikasi & Keamanan**  
Dilengkapi sistem pemblokiran sementara saat login gagal berulang dan pencatatan IP.

✅ **Statistik Usaha**  
Tampilan statistik transaksi dan aktivitas untuk pemilik usaha.

✅ **Responsive UI**  
Antarmuka modern, responsif, dan ramah pengguna.

---

## 🛠️ Teknologi yang Digunakan

- Laravel 10.x
- PHP 8.x
- MySQL / MariaDB
- Tailwind CSS / Blade
- Chart.js (opsional untuk statistik)
- FontAwesome & Heroicons

---

## 📂 Struktur Proyek (Ringkasan)

```
├── app/
│   ├── Models/
│   ├── Http/Controllers/
├── resources/views/
│   ├── layouts/
│   ├── auth/
│   └── pages/
├── routes/
│   └── web.php
├── public/storage → storage/app/public (symlink)
├── database/migrations/
├── storage/logs/
└── README.md
```

---

## 🔐 Keamanan & Log Aktivitas

Sistem ini mencatat **log aktivitas pengguna** untuk keperluan audit dan investigasi:
- Login berhasil & gagal
- Logout
- Aktivitas dashboard
- Blokir otomatis setelah gagal login beberapa kali
- Informasi yang dicatat: ID user, IP address, browser, URL asal

Disimpan dalam file `log.txt` dan tabel database `activity_logs`.

---

## 📦 Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/yourusername/aftersunset.git
   cd aftersunset
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Salin file `.env` dan konfigurasi**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Buat database & migrasi**
   ```bash
   php artisan migrate --seed
   ```

5. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan server lokal**
   ```bash
   php artisan serve
   ```

---

## 👥 Kontributor

- 👨‍💻 Muhammad Ghalib Pradipa (Project Lead & Developer)
- 🌐 aftersunset.idn (UMKM & Business Owner)

---

## 📃 Lisensi

Sistem ini dirilis di bawah [MIT License](LICENSE).

---

## ❤️ Dukungan

Jika kamu menyukai proyek ini, silakan beri ⭐️ di repository ini dan bantu UMKM lokal berkembang bersama teknologi!

---

# Al Azhar Apps Docs (AADoc)

Al Azhar Apps Docs (AADoc) adalah portal pusat bantuan dan dokumentasi berbasis web yang dirancang untuk menyimpan dan menyajikan panduan penggunaan berbagai aplikasi Al Azhar. Aplikasi ini memudahkan pengguna untuk mencari dan membaca dokumentasi, serta memudahkan administrator dalam mengelola konten dokumentasi (Kategori dan Dokumen).

## 🚀 Fitur Utama

- **Portal Pengguna (Front-end):**
  - Tampilan yang responsif dan modern.
  - Halaman beranda dengan daftar kategori dokumentasi.
  - Fitur pencarian dokumen yang cepat dan akurat.
  - Pembaca dokumen yang mendukung teks kaya (rich text) dan gambar.
- **Panel Admin:**
  - Manajemen Kategori (Create, Read, Update, Delete).
  - Manajemen Dokumen/Artikel (Create, Read, Update, Delete).
  - Fitur upload gambar untuk disematkan di dalam dokumen.
  - Autentikasi yang aman untuk mengelola konten.

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Tailwind CSS, Alpine.js, Blade Templates
- **Asset Bundler:** Vite
- **Database:** MySQL / MariaDB (Dapat disesuaikan melalui `.env`)

## 📋 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL/MariaDB/PostgreSQL/SQLite)

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi ini di lingkungan lokal Anda:

1. **Clone repository ini**
   ```bash
   git clone https://github.com/donarazhar/aadoc.git
   cd aadoc
   ```

2. **Install dependensi PHP menggunakan Composer**
   ```bash
   composer install
   ```

3. **Install dependensi Node.js**
   ```bash
   npm install
   ```

4. **Salin file environment dan atur konfigurasi database**
   ```bash
   cp .env.example .env
   ```
   *Buka file `.env` dan sesuaikan pengaturan database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).*

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database dan Seeder (jika ada)**
   ```bash
   php artisan migrate --seed
   ```

7. **Buat symlink untuk storage gambar**
   ```bash
   php artisan storage:link
   ```

8. **Build aset frontend**
   ```bash
   npm run build
   # atau untuk mode development:
   # npm run dev
   ```

## 🚀 Menjalankan Aplikasi

Jalankan server pengembangan lokal dengan perintah berikut:

```bash
php artisan serve
```

Aplikasi dapat diakses melalui browser pada URL: `http://localhost:8000`.

## 📄 Lisensi

Proyek ini dibuat untuk keperluan internal Al Azhar Apps.

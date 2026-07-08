<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsSetupGuideArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryName = 'Knowledge Transfer Session (KTS)';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Dokumentasi hasil sesi transfer pengetahuan terkait proyek Fintech Al-Azhar Apps.',
            ]
        );

        $title = 'Panduan Setup & Build';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Panduan *Setup* Lingkungan & *Build* Aplikasi

Panduan ini berisi langkah-demi-langkah (step-by-step) untuk menjalankan dan membangun ulang (*build*) aplikasi **Fintech Al-Azhar Apps** dari awal (*from scratch*) baik di lingkungan lokal maupun peladen *staging*.

Proyek ini terbagi menjadi dua ranah utama: **Backend** (Microservices Golang) dan **Frontend** (Next.js Monorepo).

---

## 🏗️ 1. Persiapan Prasyarat Sistem (*Prerequisites*)
Pastikan mesin (komputer/server) Anda sudah terinstal:
- **Go / Golang** (Minimal versi `1.25.0`)
- **Node.js** (Minimal versi `18.x`) & **NPM** (versi `11.x`)
- **PostgreSQL** (Service database berjalan di *background*)
- **Redis** (Service *cache* berjalan di *background*)
- **Docker** (Opsional, sangat disarankan jika *deploy* ke Staging)

---

## ⚙️ 2. Membangun Layanan Backend (Microservices)

Karena arsitektur menggunakan *microservices*, langkah di bawah ini **harus diulangi** untuk setiap service (seperti `account-service-develop`, `transaction-service-develop`, dll).

### Langkah Menjalankan secara Lokal (Development)
1. Buka terminal dan masuk ke folder service yang dituju:
   ```bash
   cd d:/3-File\ App/GOLANG\ NEXTJS\ PROJECT/fintech-alazharapps/account-service-develop
   ```
2. Salin dan sesuaikan konfigurasi *environment*:
   Anda harus membuat file `.env` di dalam folder `config/`.
   ```bash
   cp ../backend-codebase-main/config.dev.env config/.env
   # Buka config/.env dan ubah host/password database sesuai PostgreSQL lokal Anda.
   ```
3. Unduh *dependencies* Go:
   ```bash
   go mod tidy
   ```
4. Jalankan aplikasi lokal:
   ```bash
   go run cmd/main.go
   # Server umumnya akan berjalan di port tertentu (misal localhost:8000)
   ```

### Langkah *Build* untuk Server Staging (Production-Ready)
Untuk lingkungan staging, disarankan membangun *binary* atau menggunakan Docker:
- **Cara Binary**:
  ```bash
  go build -o build/app cmd/main.go
  ./build/app
  ```
- **Cara Docker Container**:
  Terdapat file `Dockerfile` pada masing-masing service.
  ```bash
  docker build -t alazhar-account-service:latest .
  docker run -d -p 8000:8000 alazhar-account-service:latest
  ```

---

## 🎨 3. Membangun Layanan Frontend (Web Next.js)

Aplikasi *frontend* (`frontend-develop`) menggunakan arsitektur **Turborepo** (*Monorepo*), yang membungkus banyak proyek dalam satu wadah.

### Langkah Menjalankan secara Lokal (Development)
1. Buka terminal dan masuk ke folder frontend:
   ```bash
   cd d:/3-File\ App/GOLANG\ NEXTJS\ PROJECT/fintech-alazharapps/frontend-develop
   ```
2. Sesuaikan *Environment Variables*:
   Gunakan file `.env.development` yang sudah ada, atau buat duplikat:
   ```bash
   cp .env.development .env.local
   # Sesuaikan NEXT_PUBLIC_API_URL agar mengarah ke API Backend lokal/staging
   ```
3. Pasang semua pustaka JavaScript (Install Dependencies):
   Karena menggunakan versi NPM yang distandardisasi, jalankan:
   ```bash
   npm install
   ```
4. Jalankan *Development Server* (*Hot Reload*):
   Berkat *Turborepo*, perintah ini akan menjalankan semua *apps* yang ada di dalam *monorepo* secara paralel.
   ```bash
   npx turbo dev
   # Atau bisa dengan script bawaan: npm run dev
   # Aplikasi dapat diakses via http://localhost:3000
   ```

### Langkah *Build* untuk Server Staging (Production-Ready)
Untuk melakukan *deploy* statis/SSR ke server, lakukan kompilasi (*build*):
1. Mulai proses *build* terpusat:
   ```bash
   npx turbo build
   # Atau npm run build
   ```
2. Jalankan mode rilis (Production Start):
   Masuk ke spesifik *app* Next.js yang ingin dinyalakan (contoh: folder `apps/apps`) lalu start:
   ```bash
   cd apps/apps
   npm run start
   ```

> [!WARNING]
> Jika Anda akan men-*deploy* frontend secara utuh ke peladen semacam **Vercel** atau **Netlify**, Anda hanya perlu mengatur *Root Directory* di platform tersebut ke `apps/apps` dan perintah build ke `npm run build` (Turborepo akan secara otomatis meng-*cache* tugas).

---

## 📝 Kesimpulan Eksekusi Staging
Jika Anda membangun semuanya dari nol di server Staging kosong:
1. Nyalakan PostgreSQL & Redis.
2. Atur seluruh `.env` (isi dengan IP DB Staging dan *password* dari *DevOps*).
3. Nyalakan Microservices Golang (disarankan menggunakan **Docker Compose** agar semua *service* berjalan selaras).
4. *Build* dan jalankan Frontend Next.js.

EOT
        );

        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        while(Document::where('slug', $slug)->exists()) {
            $existingDoc = Document::where('slug', $slug)->first();
            if ($existingDoc->title === $title) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Document::updateOrCreate(
            ['slug' => $slug],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 8
            ]
        );
    }
}
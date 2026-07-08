<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsServerConfigurationArticleSeeder extends Seeder
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

        $title = 'Konfigurasi Server';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Dokumentasi Konfigurasi Server & Variabel Lingkungan

Berdasarkan tinjauan pada arsitektur kode (khususnya *file* `config.go` dan `Dockerfile`), berikut adalah panduan lengkap mengenai konfigurasi *server* dan *environment variables* yang menyokong berjalannya aplikasi Fintech Al-Azhar.

---

## 1. Variabel Lingkungan Krusial (`.env`)

Aplikasi ini menggunakan pustaka **Viper** (Golang) untuk membaca konfigurasi dari berkas `.env` ataupun *Remote Config* (Consul). Berikut adalah daftar *environment variables* yang wajib ada agar sistem berjalan:

### A. Konfigurasi Backend (Microservices)
- **Database & Cache**:
  - `DB.HOST`, `DB.PORT`, `DB.NAME`, `DB.USERNAME`, `DB.PASSWORD`: Kredensial pangkalan data PostgreSQL utama.
  - `DB_READ.*`: (Opsional) Kredensial untuk akses pangkalan data *Read-Replica* guna menyeimbangkan beban baca (*Load Balancing*).
  - `REDIS.HOST`, `REDIS.PORT`, `REDIS.PASSWORD`: Untuk penyimpanan *cache* berkinerja tinggi.
- **Kredensial Keamanan**:
  - `JWT.SECRET`: Kunci rahasia untuk menerbitkan dan memvalidasi JSON Web Token. **Sangat krusial** untuk otentikasi.
  - `FIREBASE.CREDENTIALS`: Lokasi menuju *file* rahasia `firebase-service-account.json` untuk pengiriman notifikasi/FCM.
- **Integrasi Pihak Ketiga & Komunikasi Antar-Layanan**:
  - `SMTP.*`: Detail akun *email* sistem.
  - `QONTAK.*` / `FONNTE.*` / `WA.PROVIDER`: *Endpoint* dan *Token* untuk layanan pengiriman WhatsApp.
  - `APP.PORT` (Web) & `APP.GRPC` (gRPC): Port jaringan yang didengarkan oleh layanan.
- **Remote Configuration (Tingkat Produksi)**:
  - Jika diatur `GO_ENV=PROD`, sistem akan mengabaikan file lokal `.env` dan menarik konfigurasi mutlak dari layanan rahasia terpusat **Consul** (`consul:8500`).

### B. Konfigurasi Frontend (Next.js)
- `NEXT_PUBLIC_API_URL`: Mengarahkan antarmuka web ke *endpoint* API Gateway *backend* (misal: `https://dev-api.alazhar.or.id/v1`).
- `NEXT_PUBLIC_RECAPTCHA_SITE_KEY` & `RECAPTCHA_SECRET_KEY`: Layanan keamanan Google reCAPTCHA.

---

## 2. Dokumentasi Konfigurasi Server (Docker & Nginx)

Proyek ini telah dikemas sangat rapi ke dalam kontainer (Docker) yang sangat siap rilis (*Production-Ready*).

### A. Konfigurasi Server Backend (Golang Dockerfile)
Sistem menggunakan pendekatan **Multi-stage Build** yang menghasilkan *image* server berukuran super kecil (skala *Megabytes*):
1. **Tahap Builder**: Menggunakan `golang:1.25-alpine`. Sistem akan menyuntikkan `.netrc` untuk menembus pengamanan GitLab lalu mengunduh modul-modul privat. Kode Golang dikompilasi ke bentuk biner statis (`CGO_ENABLED=0`).
2. **Tahap Scratch (Production Image)**: Alih-alih membungkus sistem operasi Linux utuh (Ubuntu/Alpine), arsitektur memindahkan hasil kompilasi ke dalam wadah `FROM scratch` (Wadah kosong sepenuhnya tanpa sistem operasi bawaan). 
3. **Isi Server**: Server aplikasi murni hanya berisi berkas *binary* `.exe`, *file* pengaturan `.env`, dan sertifikat otentikasi HTTPS bawaan. Server Golang berjalan independen mengekspos jaringan pada **Port 8080**.

### B. Konfigurasi Server Frontend (Next.js Dockerfile)
Sama halnya dengan *backend*, UI dikemas menggunakan *Multi-stage*:
1. **Tahap Builder**: Menarik konfigurasi Turborepo (`node:22.17-alpine`) dan menjalankan pembangunan aplikasi lokal.
2. **Tahap Runner**: 
   - **Tingkat Keamanan Tinggi**: Demi mencegah eksploitasi jika diserang *hacker*, *server* UI di-*run* menggunakan *user* tanpa hak akses super (*non-root*): `adduser --system --uid 1001 nextjs`.
   - **Output Standalone**: Memanfaatkan mode kompilasi **Next.js Standalone**, di mana server hanya membawa sedikit berkas esensial yang diperlukan untuk SSR (`server.js` di dalam folder `.next/standalone`), mengabaikan ukuran `node_modules` yang membengkak. *Server* berjalan terekspos di **Port 3000**.

### C. Di Mana Letak Nginx / Reverse Proxy?
Di dalam basis kode ini, tidak ditemukan adanya berkas pengaturan rute semacam `nginx.conf`. Hal ini menegaskan bahwa setiap kontainer secara langsung mengekspos aplikasi mereka melalui server internal milik Golang (*Fiber*) dan Next.js (*Node*). 

**Pengaturan rute (Reverse Proxy) kemungkinan besar di- *handle* di level infrastruktur Kubernetes (melalui Ingress Controller Nginx)** atau melalui API Gateway (seperti AWS ALB) yang posisinya berada di luar repositori kode aplikasi ini.

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
                'order' => 10
            ]
        );
    }
}
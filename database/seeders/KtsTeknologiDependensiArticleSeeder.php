<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsTeknologiDependensiArticleSeeder extends Seeder
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

        $title = 'Teknologi & Dependensi';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Dokumentasi Teknologi & Dependensi

Dokumen ini merangkum *technology stack* (tumpukan teknologi), kerangka kerja (framework), pustaka (library), serta versi *runtime* yang digunakan dalam proyek **Fintech Al-Azhar Apps**. Informasi ini didapatkan dari peninjauan pada berkas `go.mod` di sisi Backend dan `package.json` di sisi Frontend.

## 1. Backend (Microservices)

Lapisan backend dibangun menggunakan arsitektur microservices dengan basis bahasa pemrograman Go (Golang).

### ⚙️ Runtime & Core
- **Bahasa Pemrograman / Runtime**: `Go 1.25.0`
- **Web/HTTP Framework**: [Fiber](https://gofiber.io/) (`v2.52.9`) - Web framework Go yang ringan dan sangat cepat yang terinspirasi dari Express.js.
- **RPC Framework**: [gRPC](https://grpc.io/) (`v1.80.0`) & Protocol Buffers (`v1.36.11`) - Digunakan untuk komunikasi performa tinggi antar-*microservices*.

### 🗄️ Database & Penyimpanan
- **ORM (Object-Relational Mapping)**: [GORM](https://gorm.io/) (`v1.31.1`) - ORM paling populer di Golang.
- **Database Drivers**: Mendukung PostgreSQL (`driver/postgres v1.6.0`) dan MySQL.
- **In-Memory Store / Cache**: [Go-Redis](https://github.com/redis/go-redis) (`v9.18.0`) - Digunakan untuk manajemen *caching* dan Redis.

### 🔐 Keamanan & Autentikasi
- **JWT (JSON Web Token)**: `golang-jwt/jwt/v5` (`v5.2.3`) - Standar untuk membuat dan memvalidasi token akses.
- **Firebase Admin SDK**: `firebase.google.com/go/v4` (`v4.18.0`) - Integrasi sistem autentikasi dan notifikasi ke Google Firebase.
- **Go JOSE**: `go-jose/go-jose/v4` - Dukungan JSON Web Signature & Encryption.

### 🛠️ Utilitas Tambahan
- **Manajemen Konfigurasi**: [Viper](https://github.com/spf13/viper) (`v1.20.1`) - Mengelola variabel *environment* dan file `.env` maupun *remote config*.
- **Validasi Data**: `go-playground/validator/v10` (`v10.27.0`) - Memvalidasi *struct* pada tingkat API *request*.
- **Observability / Telemetri**: [OpenTelemetry](https://opentelemetry.io/) (`v1.43.0`) - Untuk melacak metrik (metrics), log, dan pelacakan (*tracing*) pada Gorm maupun Fiber.
- **Dokumen Generator**: 
  - Excelize (`v2.8.1`) untuk membaca/menulis file Excel (XLSX).
  - GoFPDF (`v1.16.2`) untuk pemrosesan file PDF.

---

## 2. Frontend (Web Application)

Antarmuka web dikelola dalam arsitektur **Monorepo** yang memungkinkan *sharing code* dan komponen antar aplikasi.

### ⚙️ Runtime, Core, & Build System
- **Runtime**: `Node.js >= 18`
- **Package Manager**: `npm@11.4.2`
- **Web Framework**: [Next.js](https://nextjs.org/) (`v16.0.7`) - React framework untuk *Server-Side Rendering* (SSR) dan *Static Site Generation* (SSG).
- **Core Library**: [React](https://react.dev/) (`v19.0.0`) & `react-dom` (`v19.0.0`)
- **Monorepo Tooling**: [Turborepo](https://turbo.build/) (`v2.5.5`) - Sistem kompilasi (*build system*) untuk JavaScript/TypeScript berkinerja tinggi.

### 🎨 Styling & UI
- **CSS Framework**: [Tailwind CSS](https://tailwindcss.com/) (`v3.4.17`)
- **Pre-processor**: `PostCSS` (`v8.4.24`) & `Autoprefixer` (`v10.4.14`)
- **Iconografi**: 
  - [Lucide React](https://lucide.dev/) (`v0.539.0`)
  - [React Icons](https://react-icons.github.io/react-icons/) (`v5.5.0`)

### 📦 Manajemen State & Data Fetching
- **State Management**: [Redux Toolkit](https://redux-toolkit.js.org/) (`v2.8.2`) & `react-redux` (`v9.2.0`).
- **HTTP Client**: [Axios](https://axios-http.com/) (`v1.10.0`) - Digunakan untuk memanggil REST API dari backend.

### 📊 Komponen Visualisasi Data
Digunakan untuk halaman *dashboard* admin atau keperluan pelaporan visual:
- **Chart.js**: `chart.js` (`v4.5.0`) terintegrasi melalui `react-chartjs-2` (`v5.3.0`).
- **ApexCharts**: `apexcharts` (`v5.3.5`) terintegrasi melalui `react-apexcharts` (`v1.7.0`).
- **Circular Progressbar**: `react-circular-progressbar` (`v2.2.0`).

### 📝 Formulir, Input & Interaksi
- **Form Handling**: [React Hook Form](https://react-hook-form.com/) (`v7.61.0`) - Validasi form secara efisien.
- **Rich Text Editor**: [Tiptap](https://tiptap.dev/) (`v3.0.7`) - Editor teks *WYSIWYG* berbasis *headless* (menyertakan ekstensi *starter-kit*, *color*, *text-align*).
- **Date & Input Utilities**: 
  - `react-datepicker` (`v8.9.0`)
  - `react-currency-input-field` (`v3.10.0`)
  - `react-select` (`v5.10.2`)
- **Keamanan**: `react-google-recaptcha` (`v3.1.0`).
- **Lainnya**: `swiper` (`v11.2.10`) untuk tampilan *carousel*/slider, dan `react-spinners` (`v0.17.0`) untuk animasi *loading*.

### 🔧 Development Tools
- **Bahasa**: TypeScript (`v5.8.2` / `v5.9.2`) - Digunakan untuk *static typing* di seluruh basis kode.
- **Linter & Formatter**: ESLint (`v9.31.0`) dan Prettier (`v3.6.2`).
- **Date / Waktu**: `date-fns` (`v4.1.0`) dan `hijri-converter` (`v1.1.1`) - Berguna untuk manipulasi dan konversi ke format kalender Hijriah.

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
                'order' => 2
            ]
        );
    }
}
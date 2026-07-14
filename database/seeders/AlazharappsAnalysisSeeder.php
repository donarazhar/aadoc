<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class AlazharappsAnalysisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Category for Analysis
        $category = Category::firstOrCreate(
            ['slug' => 'analisis-arsitektur-sistem'],
            [
                'name' => 'Analisis Arsitektur Sistem',
                'description' => 'Dokumentasi komprehensif terkait arsitektur ALAZHARAPPS',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        // Content 1: Arsitektur Global & Integrasi Sistem
        $content1 = <<<HTML
<p>ALAZHARAPPS adalah sistem informasi sekolah Al Azhar yang dibangun dengan arsitektur <strong>microservices</strong>. Sistem terdiri dari 8 backend services (Golang), 1 frontend monorepo (Next.js/Turborepo), 1 landing page (React/Vite), 1 shared Go library, 1 shared JWT library, dan 1 ETL pipeline (Python).</p>

<h3>1. Protokol Komunikasi API</h3>
<p><strong>Frontend → Backend:</strong> 100% menggunakan REST API (HTTP/JSON) via Axios. Frontend berkomunikasi melalui API Gateway (dev-api.alazhar.or.id/v1) dan tidak ada GraphQL atau gRPC yang digunakan pada sisi klien.</p>
<p><strong>Backend ↔ Backend:</strong> Komunikasi antar microservices sepenuhnya menggunakan gRPC (Protobuf). Setiap service menjalankan dual-protocol server (REST + gRPC).</p>

<h3>2. Dokumentasi API (Kontrak Data)</h3>
<p>Tidak ditemukan dokumentasi API yang terpusat seperti Swagger, OpenAPI, atau Postman Collection. Kontrak data didasarkan pada file proto untuk internal gRPC, dan antarmuka TypeScript di sisi frontend. Perubahan struktur respons harus dikomunikasikan secara manual.</p>

<h3>3. Pemisahan Logika Bisnis</h3>
<p>Logika bisnis utama (seperti perhitungan tagihan, settlement, dan otorisasi) dikelola 100% di sisi backend Golang dengan Clean Architecture. Frontend Next.js berfungsi murni sebagai <em>thin client</em> untuk presentasi data dan <em>state management</em> UI.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'analisis-arsitektur-global'],
            [
                'category_id' => $category->id,
                'title' => 'Analisis Arsitektur Global & Integrasi Sistem',
                'content' => $content1,
                'is_published' => true,
                'created_by' => 1,
                'order' => 1,
            ]
        );

        // Content 2: Pendalaman Backend Golang
        $content2 = <<<HTML
<p>Analisis ini berfokus pada implementasi backend Golang di ALAZHARAPPS, mengevaluasi arsitektur, manajemen resource, dan tingkat kesiapan produksi.</p>

<h3>Pola Arsitektur Kode (Clean Architecture)</h3>
<p>Sistem ini menerapkan Clean Architecture yang sangat terstruktur, memisahkan secara tegas antara layer:</p>
<ul>
    <li><strong>Infrastructure:</strong> Koneksi database (Postgres), Redis, dan provider eksternal.</li>
    <li><strong>Domain:</strong> Entitas inti dan interface repositori murni.</li>
    <li><strong>Usecase:</strong> Aturan bisnis aplikasi yang memanggil repositori.</li>
    <li><strong>Presentation:</strong> HTTP Controllers dan gRPC Handlers untuk menerima permintaan masuk.</li>
</ul>

<h3>Konkurensi & Goroutines</h3>
<p>Pemanfaatan goroutines digunakan secara masif dan aman. Pada <em>event mediator</em> dan pendengar antrean (Redis streams), <em>worker</em> diatur berjalan sebagai <em>background goroutines</em>. Untuk mencegah <em>memory leak</em>, sistem menerapkan pola <em>context cancellation</em> dan menggunakan pustaka <code>errgroup</code> untuk sinkronisasi sub-tugas.</p>

<h3>Manajemen Koneksi Database</h3>
<p>Koneksi PostgreSQL menggunakan ORM <strong>GORM</strong>. Sistem <em>connection pooling</em> dikonfigurasi dinamis via environment variables (<code>SetMaxOpenConns</code>, <code>SetMaxIdleConns</code>). Proyek ini juga mengimplementasikan teknik <strong>Read-Write Splitting</strong> menggunakan plugin <code>dbresolver</code> untuk mengalihkan query baca ke database replika, mencegah bottleneck utama.</p>

<h3>Penanganan Error & Observabilitas</h3>
<p>Selain penanganan error berstandar, ekosistem <em>logging</em> sangat matang karena mengimplementasikan <strong>OpenTelemetry (OTel)</strong>. Setiap request API dan query database secara otomatis dilampirkan <code>trace_id</code>, memungkinkan tim melacak secara visual alur kegagalan di log aggregator seperti SigNoz atau Jaeger.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'pendalaman-backend-golang'],
            [
                'category_id' => $category->id,
                'title' => 'Pendalaman Backend: Golang (Go)',
                'content' => $content2,
                'is_published' => true,
                'created_by' => 1,
                'order' => 2,
            ]
        );

        // Content 3: Pendalaman Frontend NextJS
        $content3 = <<<HTML
<p>Frontend ALAZHARAPPS dibangun menggunakan framework NextJS dalam ekosistem Turborepo. Berikut adalah evaluasi performa dan metodenya.</p>

<h3>Versi Router & Struktur</h3>
<p>Aplikasi ini berpusat pada <strong>NextJS App Router</strong> (direktori <code>/app</code>). Direktori lama <code>/pages</code> hanya disisakan untuk mengakomodasi beberapa API route terpisah. Namun, sebagian besar halaman utama dieksekusi menggunakan arahan <code>"use client"</code> di level puncak komponen.</p>

<h3>Strategi Perenderan (Rendering Strategy)</h3>
<p>Karena dominasi penggunaan komponen klien (Client Components), strategi perenderan yang dianut adalah murni <strong>Client-Side Rendering (CSR)</strong>. Server NextJS menyajikan kerangka dasar, dan data di-<em>fetch</em> setelah UI termuat di peramban pengguna. Strategi ini sangat cocok untuk dasbor admin tertutup, meski berisiko terhadap lambatnya <em>Time to Interactive</em> jika ukuran JavaScript terlalu besar.</p>

<h3>State Management & Caching Frontend</h3>
<p>Alih-alih menggunakan pustaka caching canggih seperti React Query, sistem manajemen keadaan memusatkan lalu lintas datanya menggunakan <strong>Redux Toolkit</strong>. Eksekusi API diimplementasikan dalam bentuk <em>thunk</em> (<code>createAsyncThunk</code>). Sistem sesi dan variabel penting aplikasi sangat bergantung pada manajemen <strong>Cookies</strong> lokal.</p>

<h3>Optimasi Aset Visual</h3>
<p>Manajemen visual telah sesuai dengan standar produksi dengan digunakannya komponen <strong><code>next/image</code></strong>. Praktik ini secara signifikan mengompresi ukuran gambar dan memberikan reservasi tata letak ruang (placeholder dimensi) untuk mencegah pergeseran fatal konten layar (<em>Cumulative Layout Shift/CLS</em>).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'pendalaman-frontend-nextjs'],
            [
                'category_id' => $category->id,
                'title' => 'Pendalaman Frontend: NextJS',
                'content' => $content3,
                'is_published' => true,
                'created_by' => 1,
                'order' => 3,
            ]
        );

        // Content 4: Keamanan & Autentikasi
        $content4 = <<<HTML
<p>Evaluasi keamanan terhadap jembatan komunikasi API menunjukkan sejumlah potensi kerentanan yang memerlukan perhatian serius sebelum produk dirilis secara publik.</p>

<h3>Mekanisme Autentikasi & Penyimpanan JWT</h3>
<p>Saat ini, JSON Web Token (JWT) yang dihasilkan dari backend dikirim sebagai respons biasa dan disimpan oleh frontend menggunakan skrip JavaScript murni ke dalam Cookies (<code>Cookies.set</code>). Mekanisme <strong>tanpa perlindungan HttpOnly</strong> ini sangat rentan terhadap eksploitasi peretasan <strong>Cross-Site Scripting (XSS)</strong> di mana pihak ketiga dapat mencuri token aktif milik pengguna.</p>

<h3>Miskonfigurasi CORS (Cross-Origin Resource Sharing)</h3>
<p>Ditemukan miskonfigurasi tingkat tinggi pada layanan GoFiber, di mana parameter akses diatur sangat terbuka (<code>AllowOrigins: "*"</code>). Hal ini memungkinkan domain manapun di internet menembakkan kueri lintas situs ke backend tanpa adanya pemblokiran dari sistem keamanan bawaan web peramban pengguna (rentan terhadap CSRF sekunder).</p>

<h3>Rate Limiting & Proteksi Serangan</h3>
<p>Tidak ditemukannya mekanisme <strong>Rate Limiter</strong> aktif pada ujung-ujung API krusial (seperti <code>/login</code> atau OTP). Absennya fitur keamanan ini membuka celah eksploitasi <em>Brute-Force</em> (tebak kata sandi ribuan kali) atau pembengkakan beban SMS (OTP Bombing).</p>

<h3>Skema Validasi Input</h3>
<p>Backend belum sepenuhnya mengintegrasikan kerangka <em>struct validation</em> ekstensif dari komunitas Go. Validasi pada tahap awal lebih sering menggunakan <em>if-statement</em> fungsional dasar, menjadikan logika penyaringan input kurang terpusat.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'keamanan-autentikasi'],
            [
                'category_id' => $category->id,
                'title' => 'Keamanan & Autentikasi',
                'content' => $content4,
                'is_published' => true,
                'created_by' => 1,
                'order' => 4,
            ]
        );

        // Content 5: DevOps, Deployment & Infrastruktur
        $content5 = <<<HTML
<p>Standar DevOps yang digunakan ALAZHARAPPS tergolong tinggi dengan integrasi alur berkelanjutan yang baik. Hal ini didukung oleh kematangan pengelolaan <em>container</em>.</p>

<h3>Containerization & Docker Multi-stage Build</h3>
<p>Seluruh repositori Golang dan NextJS dibungkus ke dalam arsitektur <em>Multi-stage build</em>. Dockerfile Golang menggunakan <em>base image</em> <code>scratch</code> (kosong dari OS) pada tahap akhir yang menghasilkan fail super ringan (belasan MB) tanpa celah serangan eksploitasi (Zero-Attack Surface). Dockerfile NextJS menugaskan user non-root (<code>nextjs</code>) secara eksplisit untuk keamanan mesin.</p>

<h3>NextJS Standalone Mode</h3>
<p>Parameter <code>output: 'standalone'</code> dipastikan aktif dalam berkas konfigurasi Next.js. Proses perakitan ini berhasil melucuti ratusan MB dependensi usang dalam <code>node_modules</code>, memastikan mesin <em>container</em> bekerja sangat optimal, gesit saat dijalankan, dan meminimalkan pemakaian memori Node.js pada server produksi.</p>

<h3>Pipeline CI/CD (Infrastructure as Code)</h3>
<p>Garis waktu rilis peranti lunak diotomasikan secara mutlak lewat GitLab CI. File konfigurasi utama <code>.gitlab-ci.yml</code> sengaja dipendekkan dengan cara memanggil pustaka terpusat (<em>include</em>) dari repositori infrastruktur internal (<code>al-azhar-iac</code>). Ini menjamin keseragaman standar pengujian untuk puluhan servis mikronya, sekaligus mempercepat tindakan mitigasi <strong>rollback</strong> kontainer yang lebih stabil saat terjadi kendala fatal.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'devops-deployment-infrastruktur'],
            [
                'category_id' => $category->id,
                'title' => 'DevOps, Deployment, & Infrastruktur',
                'content' => $content5,
                'is_published' => true,
                'created_by' => 1,
                'order' => 5,
            ]
        );
    }
}

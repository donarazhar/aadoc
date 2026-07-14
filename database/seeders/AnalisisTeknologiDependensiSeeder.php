<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisTeknologiDependensiSeeder extends Seeder
{
    public function run(): void
    {
        // Get Admin User dynamically
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        // Kategori: Analisis Sistem
        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Analisis Sistem ALAZHARAPPS')],
            ['name' => 'Analisis Sistem ALAZHARAPPS']
        );

        $content = <<<HTML
<p>Dokumen ini mendata secara komprehensif susunan teknologi utama (*tech stack*) dan pustaka pihak ketiga (*third-party dependencies*) yang digunakan untuk membangun aplikasi ALAZHARAPPS.</p>

<h3>1. Backend Stack (Golang)</h3>
<p>Berdasarkan analisis pada file <code>go.mod</code> dari beberapa layanan inti (seperti <code>account-service</code>), aplikasi ini dibangun di atas pondasi bahasa pemrograman <strong>Golang versi 1.20+</strong>.</p>
<ul>
    <li><strong>Web Framework (GoFiber):</strong> Tim pengembangan tidak menggunakan pustaka standar <code>net/http</code>, melainkan menggunakan <strong>Fiber (v2)</strong>, framework web Go yang terkenal sangat cepat dan mengadopsi gaya API yang mirip dengan Express.js.</li>
    <li><strong>Database ORM (GORM):</strong> Interaksi dengan sistem manajemen basis data ditangani oleh <strong>GORM</strong> (Go Object Relational Mapper). GORM dipilih untuk mempercepat penulisan skema dan manipulasi data melalui pendekatan berbasis *struct*.</li>
    <li><strong>Driver Database:</strong> Menggunakan <code>gorm.io/driver/postgres</code> untuk menghubungkan aplikasi ke *database* utama PostgreSQL.</li>
    <li><strong>Message Broker &amp; Caching (Redis):</strong> Ketergantungan terhadap <code>go-redis/redis/v8</code> ditemukan. Ini menandakan Redis diimplementasikan secara aktif, kemungkinan besar untuk penyimpanan sementara (*caching*) dari *query* yang berat, token sesi, atau pembatasan kecepatan request (*rate-limiting*).</li>
    <li><strong>Logging Terstruktur:</strong> Log aplikasi dan aktivitas *debugging* ditangani oleh pustaka pihak ketiga ternama seperti <strong>Logrus</strong> (<code>github.com/sirupsen/logrus</code>) dan <strong>Zap</strong> (dari Uber).</li>
    <li><strong>gRPC (Microservices Communication):</strong> Meskipun ada REST API, terdapat pustaka <code>google.golang.org/grpc</code> dan <code>protobuf</code> yang digunakan secara ekstensif, menunjukkan bahwa antar-microservice berkomunikasi di belakang layar (*backend-to-backend*) dengan kecepatan sangat tinggi melalui gRPC.</li>
</ul>

<h3>2. Frontend Stack (Node.js &amp; NextJS)</h3>
<p>Sisi antarmuka pengguna direpresentasikan oleh aplikasi di dalam folder <code>frontend/</code>. Lingkungan berjalannya menggunakan <strong>Node.js (v22.x)</strong>.</p>
<ul>
    <li><strong>Core Framework (NextJS):</strong> Menggunakan NextJS versi 14+ dengan implementasi hibrida (menggunakan direktori <code>/app</code> yang baru, meski perenderan berfokus pada mode klien - CSR).</li>
    <li><strong>Bahasa Penulisan (TypeScript):</strong> Keseluruhan aplikasi (100%) ditulis dalam bahasa <strong>TypeScript</strong> untuk memastikan *type-safety* (keamanan tipe data), mencegah *bug runtime*, dan meningkatkan produktivitas pengetikan kode (*IntelliSense*).</li>
    <li><strong>Pengaturan Paket (NPM/Turborepo):</strong> Menjalankan aplikasi dalam arsitektur Monorepo menggunakan <strong>Turborepo</strong> (<code>turbo.json</code>). Manajemen dependensi dilakukan menggunakan manajer paket standar NPM.</li>
    <li><strong>Manajemen Keadaan (Redux Toolkit):</strong> Status aplikasi global dipertahankan oleh pustaka ekosistem <code>@reduxjs/toolkit</code>.</li>
    <li><strong>Pengaturan UI (Tailwind CSS):</strong> Gaya visual dan CSS dibuat sangat efisien menggunakan <strong>Tailwind CSS</strong>, dibantu dengan PostCSS dan Autoprefixer untuk kompabilitas antar peramban.</li>
    <li><strong>Pustaka Komponen (Ant Design / MUI):</strong> Selain *styling* manual dengan Tailwind, kemungkinan besar komponen antarmuka juga menggunakan pustaka pihak ketiga yang kaya fitur untuk mempercepat pembuatan tabel atau *form*.</li>
</ul>

<h3>3. Dependensi Infrastruktur</h3>
<ul>
    <li><strong>Kontainer (Docker):</strong> Menjadi standar peluncuran seluruh layanan.</li>
    <li><strong>Continuous Integration (GitLab CI):</strong> Menggunakan <code>.gitlab-ci.yml</code> untuk automasi pembangunan paket dan peluncuran (Deployment).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('2. Dokumentasi Teknologi & Dependensi')],
            [
                'title' => '2. Dokumentasi Teknologi & Dependensi',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

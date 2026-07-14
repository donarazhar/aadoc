<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisSetupLingkunganSeeder extends Seeder
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
<p>Dokumen ini menyediakan tata cara (guideline) standar untuk membangun dan menjalankan seluruh layanan aplikasi ALAZHARAPPS secara lokal di mesin pengembang (Developer Machine).</p>

<h3>1. Persyaratan Sistem Lokal (Prerequisites)</h3>
<p>Sebelum mengompilasi kode, mesin pengembang wajib memiliki peranti lunak berikut:</p>
<ul>
    <li><strong>Golang (v1.20+)</strong>: Untuk melakukan kompilasi dan menjalankan *microservices* backend.</li>
    <li><strong>Node.js (v22+) &amp; NPM/PNPM</strong>: Untuk menjalankan *environment* Frontend (NextJS) dan ekosistem Turborepo.</li>
    <li><strong>Docker &amp; Docker Compose</strong>: Digunakan secara ekstensif untuk menjalankan layanan infrastruktur pendukung lokal (seperti PostgreSQL, Redis, dan simulasi Kafka/RabbitMQ) tanpa harus menginstalnya ke dalam OS utama pengembang.</li>
    <li><strong>Git</strong>: Untuk sinkronisasi versi dan integrasi dengan GitLab.</li>
</ul>

<h3>2. Panduan Eksekusi Backend (Golang)</h3>
<p>Karena arsitekturnya terpisah menjadi lebih dari 8 *repository* (seperti `account-service`, `student-service`), pengembang lokal tidak perlu menjalankan semuanya sekaligus kecuali sedang menguji fitur lintas-layanan.</p>
<ol>
    <li>Siapkan file konfigurasi: Salin <code>.env.example</code> menjadi <code>.env</code> di *root* folder layanan terkait.</li>
    <li>Nyalakan *database* lokal via Docker: <code>docker-compose up -d postgres redis</code> (jika tersedia di repo infrastruktur).</li>
    <li>Unduh modul dependensi Go: <code>go mod tidy</code></li>
    <li>Jalankan server: <code>go run cmd/main.go</code> (atau lokasi file utama yang memuat fungsi <code>main()</code>).</li>
    <li><em>(Opsional)</em> Jika ada pembaruan *Proto buffers* (gRPC), pengembang harus menginstal <code>protoc</code> dan menjalankan *script generate* sebelum *build*.</li>
</ol>

<h3>3. Panduan Eksekusi Frontend (NextJS Turborepo)</h3>
<p>Aplikasi Frontend disatukan dalam sebuah monorepo, yang mempermudah proses inisialisasi:</p>
<ol>
    <li>Masuk ke folder utama <code>frontend/</code>.</li>
    <li>Instal seluruh dependensi: <code>npm install</code> atau <code>npm ci</code>. Turborepo akan otomatis menautkan paket lokal (<em>hoisting</em>) dari <code>packages/</code> ke <code>apps/</code>.</li>
    <li>Pastikan file variabel lingkungan <code>.env.development</code> sudah terisi dengan alamat API lokal (contoh: <code>NEXT_PUBLIC_API_URL=http://localhost:8080/api/v1</code>).</li>
    <li>Jalankan server pengembangan: <code>npm run dev</code>. Turborepo akan memicu proses *watch* pada komponen dan menampilkan UI di <code>http://localhost:3000</code>.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('8. Panduan Setup Lingkungan & Build Aplikasi')],
            [
                'title' => '8. Panduan Setup Lingkungan & Build Aplikasi',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisKonfigurasiServerSeeder extends Seeder
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
<p>Dokumen ini mendokumentasikan pemetaan Variabel Lingkungan (Environment Variables) yang menjadi urat nadi konfigurasi dinamis seluruh <em>microservices</em> ALAZHARAPPS tanpa perlu mengubah (hardcode) kode sumber.</p>

<h3>1. Backend Environment (.env)</h3>
<p>Setiap repositori Golang (contohnya <code>account-service</code>) dikendalikan oleh puluhan variabel yang membedakan profil peluncurannya (Development, Staging, Production). Parameter kuncinya meliputi:</p>
<ul>
    <li><strong>Aplikasi (App Info):</strong> <code>APP_ENV=production</code>, <code>APP_PORT=8080</code> (Port *binding* untuk GoFiber), dan <code>GRPC_PORT=9090</code>.</li>
    <li><strong>Koneksi Database:</strong> <code>DB_HOST</code>, <code>DB_PORT</code>, <code>DB_USER</code>, <code>DB_PASSWORD</code>, <code>DB_NAME</code>, beserta parameter batas koneksi (<code>DB_MAX_IDLE_CONNS</code>, <code>DB_MAX_OPEN_CONNS</code>) untuk mencegah kebocoran koneksi.</li>
    <li><strong>Redis Caching:</strong> <code>REDIS_HOST</code>, <code>REDIS_PORT</code>, dan <code>REDIS_PASSWORD</code>.</li>
    <li><strong>Keamanan &amp; Autentikasi:</strong> <code>JWT_SECRET</code> (Sangat Rahasia! Kunci untuk memvalidasi token sesi) dan <code>JWT_EXPIRATION</code> (Durasi aktifnya token sebelum pengguna harus <em>login</em> ulang).</li>
    <li><strong>Koneksi Antar-Layanan (Service Discovery):</strong> <code>STUDENT_SERVICE_GRPC_URL</code>, <code>TRANSACTION_SERVICE_GRPC_URL</code> (Alamat internal agar servis bisa saling bertukar data).</li>
</ul>

<h3>2. Frontend Environment</h3>
<p>Di antarmuka NextJS, *environment variable* tidak semuanya dikirim ke peramban klien. Sesuai standar NextJS, hanya variabel dengan awalan tertentu yang diekspos secara publik.</p>
<ul>
    <li><strong>Eksplisit Publik (NEXT_PUBLIC_*):</strong> Variabel seperti <code>NEXT_PUBLIC_API_URL</code> atau <code>NEXT_PUBLIC_APP_NAME</code> wajib diatur, karena kode di dalam peramban (CSR) membutuhkannya untuk menembak API *backend*.</li>
    <li><strong>Server-side Secrets:</strong> Variabel tanpa awalan *NEXT_PUBLIC* (seperti <code>ENCRYPTION_KEY</code> lokal) hanya hidup di level server Node.js dan terjamin kerahasiaannya.</li>
</ul>

<h3>3. Manajemen Konfigurasi (Best Practices)</h3>
<p><strong>[TIP] Temuan Audit Konfigurasi:</strong> </p>
<p>Praktik yang diterapkan oleh ALAZHARAPPS sudah baik karena tidak melakukan *commit* file <code>.env</code> ke repositori Git (hanya menyertakan <code>.env.example</code>). Pada lingkungan *Production*, nilai-nilai asli dari variabel ini disuntikkan secara dinamis saat proses rilis (Deployment) berjalan, seringkali menggunakan <em>GitLab CI/CD Variables</em> atau <em>Kubernetes Secrets</em> untuk menyembunyikan kata sandi database dari staf non-Sistem Administrator.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('10. Dokumentasi Konfigurasi Server & Variabel Lingkungan')],
            [
                'title' => '10. Dokumentasi Konfigurasi Server & Variabel Lingkungan',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

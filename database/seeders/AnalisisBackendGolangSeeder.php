<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisBackendGolangSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id ?? 1;

        $category = Category::firstOrCreate(
            ['slug' => 'analisis-arsitektur-sistem'],
            [
                'name' => 'Analisis Arsitektur Sistem',
                'description' => 'Dokumentasi komprehensif terkait arsitektur ALAZHARAPPS',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

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
                'created_by' => $adminId,
                'order' => 2,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisKomunikasiAsinkronSeeder extends Seeder
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
<p>Dokumen ini memetakan diagram ketergantungan dan metode komunikasi asinkron yang terjadi antar layanan (*Microservices*) di dalam ekosistem ALAZHARAPPS dan LMSALAZHARAPPS.</p>

<h3>1. Dilema Microservices: Komunikasi Lintas Layanan</h3>
<p>Dalam arsitektur *monolith*, ketika tabel Tagihan butuh melihat nama Siswa, ia cukup melakukan <em>SQL JOIN</em>. Di ALAZHARAPPS, karena <code>transaction-service</code> dan <code>student-service</code> adalah dua server dengan *database* yang berbeda, mereka harus berbicara satu sama lain melalui jaringan.</p>

<h3>2. Solusi 1: Pemanggilan Langsung (gRPC)</h3>
<p>Kapan ini digunakan? Saat layanan butuh data <strong>secara instan (real-time)</strong> sebelum membalas *request* dari *Frontend*.</p>
<ul>
    <li><strong>Skenario:</strong> Guru membuka halaman <em>Input Nilai</em> di <code>lms-course-service</code>. Layanan LMS ini hanya tahu <code>student_id</code>, tapi butuh Nama dan NISN untuk ditampilkan di layar.</li>
    <li><strong>Pelaksanaan:</strong> LMS akan bertindak sebagai *Client* gRPC yang menembak <code>student-service</code> (berjalan di port 9090). Protokol ini mengemas data dalam biner (Protobuf), sehingga pertukaran ratusan data murid terjadi hanya dalam hitungan milidetik (*low-latency*).</li>
    <li><strong>Manajemen Kegagalan (Circuit Breaker):</strong> Jika <code>student-service</code> tiba-tiba mati, gRPC akan mengalami <em>Timeout</em>. Agar <code>lms-course-service</code> tidak ikut macet/hang, pengembang harus menyisipkan batas tunggu (*context deadline*), misalnya maksimal 2 detik. Jika gagal, LMS bisa me-return data kosong atau *cache* terakhir.</li>
</ul>

<h3>3. Solusi 2: Pendekatan Asinkron (Message Broker / Event-Driven)</h3>
<p>Kapan ini digunakan? Saat layanan <strong>tidak butuh menunggu balasan</strong> secara instan (proses berjalan di latar belakang / *fire-and-forget*).</p>
<ul>
    <li><strong>Skenario:</strong> Saat orang tua berhasil melunasi SPP di <code>transaction-service</code>.</li>
    <li><strong>Pelaksanaan:</strong> <code>transaction-service</code> tidak memanggil API notifikasi WhatsApp sambil menyuruh orang tua menunggu halaman *loading*. Sebaliknya, ia cukup melempar pesan *"SPP Lunas untuk Siswa A"* ke dalam antrean (Redis Pub/Sub, RabbitMQ, atau Kafka).</li>
    <li><strong>Konsumen (Consumer):</strong> Servis lain (misalnya <code>jurnal-service</code> atau servis notifikasi) yang sedang *subscribe* ke saluran tersebut akan "mendengar" pesan itu, lalu memproses jurnal keuangannya masing-masing di latar belakang tanpa mengganggu alur aplikasi utama.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('14. Komunikasi Asinkron antar Layanan (Inter-Service Mapping)')],
            [
                'title' => '14. Komunikasi Asinkron antar Layanan (Inter-Service Mapping)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

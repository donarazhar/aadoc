<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisManajemenDataSeeder extends Seeder
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
<p>Dokumen ini membahas strategi pengelolaan, pencadangan (backup), dan pengarsipan data di ALAZHARAPPS.</p>

<h3>1. Strategi Retensi Data Terstruktur (Soft Deletes)</h3>
<p>ALAZHARAPPS secara default mengimplementasikan prinsip perlindungan data maksimal di level kode aplikasi:</p>
<ul>
    <li>Tidak ada penghapusan data secara fisik (Hard Delete) pada tabel-tabel utama (seperti siswa, guru, tagihan, atau nilai).</li>
    <li>GORM dikonfigurasi untuk menggunakan fitur <em>Soft Delete</em>, di mana setiap pemanggilan fungsi Hapus (<code>db.Delete()</code>) tidak akan menjalankan kueri <code>DELETE FROM</code>, melainkan mengubah kuerinya menjadi <code>UPDATE table SET deleted_at = NOW()</code>.</li>
    <li><strong>Manfaat:</strong> Hal ini sangat vital di industri pendidikan untuk menghindari hilangnya jejak akademis atau keuangan akibat kecerobohan pengguna, sekaligus memungkinkan pemulihan (restore) instan langsung dari panel admin (jika fitur tersebut diaktifkan).</li>
</ul>

<h3>2. Pencadangan Basis Data (Database Backups)</h3>
<p>Karena arsitektur database mengikuti pola *Microservices* (banyak instance/skema yang terpisah per layanan), pencadangan tidak bisa mengandalkan satu skrip statis sederhana.</p>
<p><strong>Rekomendasi Arsitektural:</strong></p>
<ol>
    <li><strong>Infrastruktur Level:</strong> Back-up tidak didefinisikan di dalam baris kode Golang, melainkan harus ditangani di tingkat *Cloud Provider* atau kontainer pangkalan data (menggunakan alat seperti <code>pg_dumpall</code>) secara terjadwal (Cronjob).</li>
    <li><strong>Penyimpanan Dingin (Cold Storage):</strong> Hasil dump database harian idealnya dikompresi dan dikirim ke server penyimpanan pihak ketiga yang murah (seperti AWS S3 Glacier atau Backblaze B2) untuk mencegah kehilangan total (Data Loss) apabila data center utama terbakar atau diretas *ransomware*.</li>
</ol>

<h3>3. Pengarsipan Data (Data Archiving)</h3>
<p>Data aktivitas siswa dan LMS biasanya tumbuh secara eksponensial (membengkak dari hitungan MegaByte menjadi GigaByte dalam hitungan bulan akibat file ujian dan laporan).</p>
<p><strong>[IMPORTANT] Strategi yang Disarankan:</strong> Tim ALAZHARAPPS telah memisahkan layanan rekap historis ke dalam modul <code>etl</code> (Extract, Transform, Load) dan <code>report-service</code>. Disarankan agar sistem memiliki logika otomasi (bisa berbasis <em>cron scheduler</em> di Golang) untuk memindahkan data pendaftaran siswa atau nilai ujian yang sudah berumur lebih dari 5 tahun ajaran ke tabel terpisah (Tabel Arsip) atau ke *Data Warehouse* analitik, agar database operasional utama tetap ramping, cepat, dan ringan.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('6. Strategi Manajemen Data (Backup & Archiving)')],
            [
                'title' => '6. Strategi Manajemen Data (Backup & Archiving)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

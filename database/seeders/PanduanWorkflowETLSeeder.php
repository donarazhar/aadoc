<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowETLSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Skenario Workflow Lintas Sistem')],
            ['name' => 'Skenario Workflow Lintas Sistem']
        );

        $content = <<<HTML
<p>Artikel ini menjelaskan skenario di balik layar tentang bagaimana data dari sistem lama (<em>Legacy System</em> / SALAM) dipindahkan dan disinkronisasikan ke dalam ekosistem sistem baru ALAZHARAPPS tanpa mengganggu operasional sistem utama. Proses ini dikenal sebagai ETL (<em>Extract, Transform, Load</em>) yang dieksekusi menggunakan skrip Python otomatis.</p>

<h3>Diagram Urutan: Sinkronisasi Data Lintas Platform (ETL)</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant CRN as Cron Scheduler (Linux)
    participant ETL as ETL Worker (Python Script)
    participant OLD as Legacy DB (SALAM)
    participant NEW as PostgreSQL (ALAZHARAPPS)
    participant RED as Redis Cache

    %% Pemanggilan Skrip Otomatis
    Note over CRN,ETL: Berjalan Otomatis Pukul 01:00 AM
    CRN->>ETL: Jalankan Script Sinkronisasi

    %% Tahap 1: EXTRACT (Penarikan)
    Note over ETL,OLD: Tahap 1: EXTRACT (Ekstraksi)
    ETL->>OLD: Query: Ambil data perubahan (Mutasi Siswa, Pembayaran) 24 jam terakhir
    OLD-->>ETL: Return 10.000 Baris Data Mentah

    %% Tahap 2: TRANSFORM (Transformasi)
    Note over ETL: Tahap 2: TRANSFORM (Pembersihan Data)
    ETL->>ETL: Format Ulang Data (Penyesuaian Struktur Kolom)
    ETL->>ETL: Standarisasi Tipe Data (Tanggal, Angka)
    ETL->>ETL: Filter Data Ganda/Kotor (Data Cleansing)

    %% Tahap 3: LOAD (Pemuatan)
    Note over ETL,RED: Tahap 3: LOAD (Penyimpanan ke Sistem Baru)
    ETL->>NEW: Bulk Insert / Update Data Bersih (UPSERT)
    NEW-->>ETL: Konfirmasi Data Tersimpan
    ETL->>RED: Invalidate Cache (Hapus memori lama agar aplikasi refresh)
    RED-->>ETL: Cache Cleared
    
    %% Pelaporan
    ETL->>CRN: Laporan Selesai (Log Berhasil: 9.998, Gagal: 2)
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Infrastruktur ALAZHARAPPS yang mengusung <em>microservices</em> memiliki struktur <em>database</em> yang jauh berbeda dan terpisah-pisah dibandingkan dengan sistem monolitik SALAM yang lama. Untuk memastikan tidak ada data yang hilang selama masa transisi, atau jika ada sekolah yang masih memakai sebagian fitur di sistem lama, sebuah <strong>Pipa Data (Data Pipeline)</strong> sangat krusial.</p>

<h4>1. Pemicu Otomatis (Cron Job Scheduler)</h4>
<ul>
    <li>Proses sinkronisasi data besar-besaran (massal) sangat memakan memori (RAM) dan CPU. Jika dilakukan pada jam kerja (pagi-siang), hal ini dapat menyebabkan aplikasi lambat (<em>lag</em>) saat diakses oleh pengguna.</li>
    <li>Oleh karena itu, sistem operasi server menggunakan <code>cron job</code> untuk membangunkan skrip Python (ETL) secara otomatis pada jam-jam sunyi (misalnya pukul 01:00 dini hari setiap harinya).</li>
</ul>

<h4>2. Tahap Ekstraksi (Extract)</h4>
<ul>
    <li>Skrip Python akan terhubung secara aman ke <em>database</em> lama. Skrip ini hanya menarik data yang sifatnya baru ditambahkan atau diubah pada hari tersebut (disebut <em>Delta/Incremental Load</em>), bukan menarik seluruh data sekolah dari awal tahun. Hal ini membuat waktu penarikan sangat cepat.</li>
</ul>

<h4>3. Tahap Transformasi (Transform)</h4>
<ul>
    <li>Ini adalah tahap paling kompleks. Di sistem lama, kolom mungkin bernama <code>NAMA_MURID</code> bertipe teks biasa. Sedangkan di ALAZHARAPPS, kolomnya terpisah menjadi <code>first_name</code> dan <code>last_name</code>.</li>
    <li>Skrip Python melakukan "penerjemahan bahasa" antar-database. Data yang kotor (misal: nomor HP berisi huruf) akan dibersihkan atau ditolak.</li>
</ul>

<h4>4. Tahap Pemuatan (Load) & Sinkronisasi Cache</h4>
<ul>
    <li>Data yang sudah rapi disuntikkan ke dalam <em>database</em> PostgreSQL masing-masing <em>microservices</em> (ke <code>student-service</code> atau <code>transaction-service</code>). Sistem menggunakan metode <em>UPSERT</em> (Update or Insert) &mdash; jika data anak sudah ada maka diperbarui, jika belum ada maka dibuatkan data baru.</li>
    <li><strong>Sangat Penting:</strong> Karena ALAZHARAPPS membaca data dari <strong>Redis Cache</strong> (memori kecepatan tinggi agar aplikasi seluler terasa instan), skrip ETL <strong>WAJIB</strong> menghapus <em>cache</em> lama tersebut setelah menyuntikkan data baru. Dengan demikian, keesokan paginya saat orang tua membuka aplikasi, mereka langsung mendapatkan data tagihan/nilai terbaru (<em>fresh data</em>).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Sinkronisasi Data Lintas Platform (ETL Process)')],
            [
                'title' => 'Skenario Sinkronisasi Data Lintas Platform (ETL Process)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

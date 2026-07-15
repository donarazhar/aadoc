<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanProsesBisnisALAZHARSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Proses Bisnis')],
            ['name' => 'Buku Panduan Proses Bisnis']
        );

        $content = <<<HTML
<p>Dokumen ini memetakan alur kerja (<em>Business Process</em>) dari ujung ke ujung (*end-to-end*) khusus untuk ekosistem <strong>ALAZHARAPPS</strong>. Ekosistem ini berfokus pada dua tulang punggung utama yayasan: <strong>Administrasi Siswa (PMB)</strong> dan <strong>Mesin Keuangan (Financial Engine)</strong>.</p>

<h3>Diagram Alur Proses Bisnis ALAZHARAPPS</h3>
<pre><code class="language-mermaid">
flowchart TD
    A[Masyarakat / Orang Tua] -->|Melihat Info| B(Animo PMB)
    B -->|Membeli Formulir| C(Calon Murid)
    C -->|Ikut Tes Seleksi| D{Ujian Masuk}
    D -->|Lulus| E[Diterima / Data Calon Murid]
    D -->|Gagal| Z[Ditolak]
    
    E -->|Tagihan Muncul| F(Uang Pangkal)
    F -->|Bayar via DOKU| G{Payment Gateway}
    G -->|Webhook Sukses| H[Murid Aktif]
    
    H -->|Siklus Bulanan| I(Tagihan SPP)
    H -->|Siklus Tahunan| J(Naik Kelas & Tagihan Daftar Ulang)
    J -->|Akhir Jenjang| K(Kelulusan / Alumni)
</code></pre>

<h3>1. Proses Hulu: Penerimaan Murid Baru (PMB)</h3>
<p>Proses ini mengubah masyarakat umum menjadi siswa resmi sekolah.</p>
<ul>
    <li><strong>Tahap 1 (Setup Gelombang):</strong> Admin Pusat / Sekolah membuka "Keran" pendaftaran dengan mengatur nama gelombang, rentang tanggal pendaftaran, dan biaya formulir masuk.</li>
    <li><strong>Tahap 2 (Animo/Peminat):</strong> Orang tua mendaftar di portal web/mobile. Mereka baru sebatas membuat akun. Status anaknya di sistem disebut sebagai <strong>Animo</strong> (Peminat).</li>
    <li><strong>Tahap 3 (Pembelian Formulir):</strong> Orang tua melakukan pembayaran biaya formulir (biasanya via <em>Virtual Account</em>). Setelah lunas, status anak naik level menjadi <strong>Calon Murid</strong>. Di titik ini, mereka mendapatkan nomor ujian.</li>
    <li><strong>Tahap 4 (Seleksi & Ujian):</strong> Sekolah mengatur <em>Jadwal Ujian</em>. Calon murid datang untuk tes (tertulis/wawancara). Setelah tes selesai, Panitia PMB merapatkan hasil ujian.</li>
    <li><strong>Tahap 5 (Yudisium Kelulusan):</strong> Admin menekan tombol "Lulus" di sistem. Selamat! Anak tersebut kini siap menjadi warga sekolah, <strong>NAMUN</strong> statusnya belum aktif sepenuhnya sebelum ia menyelesaikan administrasi keuangan tahap awal.</li>
</ul>

<h3>2. Proses Inti: Mesin Keuangan & Payment Gateway</h3>
<p>Ini adalah siklus perputaran uang (*Cashflow*) yang diotomasikan oleh sistem.</p>
<ul>
    <li><strong>Tahap 1 (Kewajiban Uang Pangkal):</strong> Segera setelah siswa dinyatakan lulus PMB, sistem secara otomatis me-<em>generate</em> (menerbitkan) tagihan raksasa bernama <strong>Uang Pangkal</strong> (terdiri dari Uang Gedung, Seragam, Buku, dll).</li>
    <li><strong>Tahap 2 (Proses Pembayaran DOKU):</strong> Orang tua membuka Aplikasi Mobile, melihat tagihan Uang Pangkal (berwarna merah). Mereka memilih bank (Misal: Mandiri VA) lalu mentransfer uangnya.</li>
    <li><strong>Tahap 3 (Mekanisme Webhook):</strong> Server Bank memberi tahu server DOKU, lalu DOKU mengirim "Pesan Gaib" (*Webhook*) ke server <code>transaction-service</code> ALAZHARAPPS. Sistem memvalidasi *Signature* (Tanda tangan keamanan). Jika valid, status tagihan di *database* diubah menjadi Lunas (Hijau). <strong>Siswa tersebut kini resmi menjadi Murid Aktif.</strong></li>
    <li><strong>Tahap 4 (Siklus Berulang / Recurring Billing):</strong>
        <ul>
            <li><strong>Bulanan (SPP):</strong> Pada tanggal 1 setiap bulannya, sistem keuangan (*Cron Job / Scheduler*) otomatis menembakkan tagihan SPP ke HP seluruh orang tua.</li>
            <li><strong>Tunggakan & Notifikasi:</strong> Jika melewati batas Jatuh Tempo, sistem menembakkan notifikasi peringatan (*Push Notification*) ke HP penunggak secara berkala.</li>
        </ul>
    </li>
</ul>

<h3>3. Proses Hilir: Mutasi & Promosi (Akhir Tahun Ajaran)</h3>
<p>Siklus ini terjadi setiap bulan Juni/Juli saat pergantian tahun ajaran baru.</p>
<ul>
    <li><strong>Tahap 1 (Pembuatan Tahun Ajaran Baru):</strong> Admin menonaktifkan Tahun Ajaran lama dan mengaktifkan yang baru di menu Master Data.</li>
    <li><strong>Tahap 2 (Kenaikan Kelas Massal):</strong> Admin masuk ke menu "Kenaikan Kelas", memilih rombongan belajar lama (Misal: Kelas 1A) lalu memindahkan seluruh siswanya ke kelas baru (Misal: Kelas 2A).</li>
    <li><strong>Tahap 3 (Tagihan Daftar Ulang):</strong> Bersamaan dengan naiknya kelas siswa, Admin Keuangan menerbitkan tagihan tahunan <strong>Uang Daftar Ulang</strong>.</li>
    <li><strong>Tahap 4 (Kelulusan / Alumni):</strong> Untuk siswa tingkat akhir (Kelas 6, 9, 12), Admin mengeksekusi menu Kelulusan. Sistem memindahkan data mereka dari tabel "Siswa Aktif" menjadi "Alumni", sehingga mereka tidak akan pernah lagi ditagihkan SPP di bulan-bulan berikutnya.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Proses Bisnis Inti ALAZHARAPPS')],
            [
                'title' => 'Panduan Proses Bisnis: Siklus Administratif & Finansial ALAZHARAPPS',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSpesifikAngsuranSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Modul Operasional')],
            ['name' => 'Panduan Spesifik Modul Operasional']
        );

        $content = <<<HTML
<p>Dokumen ini adalah Panduan Spesifik (<em>Deep-Dive</em>) mengenai tata cara dan alur kerja (*Workflow*) fitur <strong>Pengajuan Angsuran (Cicilan Biaya)</strong> di sistem ALAZHARAPPS.</p>

<h3>Konteks Bisnis</h3>
<p>Komponen biaya besar seperti <strong>Uang Pangkal</strong> (yang bisa mencapai belasan juta rupiah) seringkali menjadi beban berat jika harus dibayar lunas sekaligus (<em>Lump Sum</em>) oleh orang tua di awal tahun. Oleh karena itu, sistem menyediakan fitur Angsuran/Cicilan agar tagihan raksasa tersebut bisa dipecah menjadi beberapa termin tagihan yang lebih kecil.</p>

<h3>Alur Kerja (SOP) Pengajuan Angsuran</h3>

<ol>
    <li>
        <strong>Tatap Muka & Negosiasi dengan Tata Usaha</strong>
        <ul>
            <li><strong>Skenario:</strong> Orang tua siswa menghadap bagian Keuangan/TU untuk meminta keringanan pembayaran secara bertahap (Misal: Uang Pangkal Rp12.000.000 ingin dicicil 3 kali).</li>
            <li><strong>Jejak UI (Admin TU):</strong> Membuka Web Backoffice &rarr; Sidebar <code>Administrasi</code> &rarr; <code>Biaya</code> &rarr; <code>Pengajuan Angsuran</code>.</li>
            <li><strong>Aksi UX:</strong> 
                <p>Admin menekan <strong>Tambah Angsuran</strong> dan memilih nama siswa. Sistem akan menampilkan UX <em>Dynamic Form</em> (Formulir Dinamis) di mana Admin bisa menekan tombol "+ Tambah Termin" berkali-kali.</p>
                <p>Admin mengisinya menjadi:</p>
                <ul>
                    <li>Termin 1: Rp5.000.000 (Jatuh Tempo: 1 Juli)</li>
                    <li>Termin 2: Rp4.000.000 (Jatuh Tempo: 1 Agustus)</li>
                    <li>Termin 3: Rp3.000.000 (Jatuh Tempo: 1 September)</li>
                </ul>
            </li>
            <li><strong>Auto-Calculate Validation:</strong> Secara UX, sistem tidak akan mau menyimpan (<em>Save button disabled</em>) jika total penjumlahan ketiga termin tersebut kurang atau lebih dari Rp12.000.000. Ini menjaga agar tidak ada selisih uang.</li>
        </ul>
    </li>
    <li>
        <strong>Validasi & Eksekusi Pemecahan Tagihan</strong>
        <ul>
            <li><strong>Skenario:</strong> Sama seperti mekanisme Diskon, pengajuan cicilan ini biasanya butuh persetujuan (<em>Approval</em>) Kepala Sekolah/Bendahara Utama.</li>
            <li><strong>Aksi UX:</strong> Kepala Sekolah menekan <strong>Approve</strong>.</li>
            <li><strong>Reaksi Sistem (Database Split):</strong> Begitu di-<em>approve</em>, keajaiban sistem terjadi di belakang layar. Tagihan raksasa Uang Pangkal yang awalnya hanya 1 baris *database*, akan <strong>dipecah (di-split)</strong> menjadi 3 baris tagihan baru yang terpisah.</li>
        </ul>
    </li>
    <li>
        <strong>Tampilan di Aplikasi Mobile Orang Tua</strong>
        <ul>
            <li><strong>Skenario (Bulan Juli):</strong> Orang tua membuka HP dan hanya akan melihat 1 tagihan berwarna merah yaitu "Uang Pangkal Termin 1". Mereka membayarnya via DOKU.</li>
            <li><strong>Skenario (Bulan Agustus):</strong> Saat tanggal 1 Agustus tiba (<em>Cron Job Scheduler</em> membaca Jatuh Tempo), sistem otomatis memunculkan tagihan "Uang Pangkal Termin 2" ke layar HP orang tua, disertai bunyi <em>Push Notification</em>.</li>
        </ul>
    </li>
</ol>

<blockquote>
<p><strong>Kenapa harus dipecah termin?</strong><br>
Hal ini memudahkan sistem Payment Gateway (DOKU) yang membutuhkan 1 Nomor Virtual Account spesifik untuk 1 tagihan pasti. Jika tidak dipecah, sistem akan bingung ketika orang tua mentransfer Rp5 juta padahal tagihan aslinya Rp12 juta (Status akan menggantung / <em>Partial Paid</em>).</p>
</blockquote>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Alur Pengajuan Angsuran')],
            [
                'title' => 'Panduan Spesifik: Alur Pengajuan Angsuran (Cicilan)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanRoleHierarkiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Pengguna (User Manual)')],
            [
                'name' => 'Panduan Pengguna (User Manual)'
            ]
        );

        $content = <<<HTML
<p>Dokumen ini memetakan hierarki peran (Role Levels) yang tertanam secara fundamental di dalam *source code* ALAZHARAPPS (khususnya <code>account-service</code>). Terdapat 7 tingkatan peran aktif yang memegang kunci kendali atas fitur-fitur di aplikasi Web maupun Mobile.</p>

<h3>1. Administrator (Level ID: 1)</h3>
<ul>
    <li><strong>Audiens:</strong> Superadmin / Staf IT Pusat Yayasan.</li>
    <li><strong>Kapasitas Akses:</strong> <em>Highest Privilege</em> (Tak Terbatas).</li>
    <li><strong>Fungsi Utama:</strong> Membuka akses untuk unit sekolah baru, mengatur <em>Payment Gateway</em> sentral, menetapkan kebijakan aplikasi, dan membagikan hak akses untuk Kepala Sekolah serta Admin Unit. Jika terjadi kendala fatal, peran ini yang akan melakukan intervensi sistem.</li>
</ul>

<h3>2. Admin Sekolah (Level ID: 9)</h3>
<ul>
    <li><strong>Audiens:</strong> Staf Tata Usaha / Admin Keuangan di masing-masing Unit Sekolah.</li>
    <li><strong>Kapasitas Akses:</strong> Dibatasi berdasarkan Unit (<em>Tenant-Isolation</em>). Admin SD tidak bisa mengintip data unit SMP.</li>
    <li><strong>Fungsi Utama:</strong> Jantung operasional *Backoffice*. Bertugas menerima siswa baru dari PPDB, membagi kelas (Rombel), menugaskan Wali Kelas, mengeksekusi tagihan SPP massal setiap tanggal 1, dan melayani pelunasan tunai (Kasir) di loket sekolah.</li>
</ul>

<h3>3. Guru (Level ID: 10)</h3>
<ul>
    <li><strong>Audiens:</strong> Tenaga Pendidik / Wali Kelas.</li>
    <li><strong>Kapasitas Akses:</strong> Terbatas pada kelas dan mata pelajaran yang diampunya.</li>
    <li><strong>Fungsi Utama:</strong> Motor penggerak akademik dan LMS. Mengunggah video/modul pembelajaran, meracik soal ujian (Computer Based Test), memberikan penilaian, dan <strong>wajib mengisi Jurnal Mengajar serta Presensi Harian Siswa</strong> yang akan terhubung ke laporan Kepala Sekolah.</li>
</ul>

<h3>4. Kepala Sekolah (Level ID: 11)</h3>
<ul>
    <li><strong>Audiens:</strong> Pimpinan Unit Sekolah.</li>
    <li><strong>Kapasitas Akses:</strong> Pemantau (Observer) di level Unit.</li>
    <li><strong>Fungsi Utama:</strong> Memonitor kesehatan sekolah secara keseluruhan. Menarik laporan persentase kehadiran siswa, melihat tren pelunasan SPP, serta melakukan sidak digital untuk memastikan Jurnal Guru telah diisi dengan disiplin.</li>
</ul>

<h3>5. Orang Tua (Level ID: 12)</h3>
<ul>
    <li><strong>Audiens:</strong> Wali Murid (Aplikasi Mobile).</li>
    <li><strong>Kapasitas Akses:</strong> Hanya dapat melihat data milik anak kandungnya sendiri. Jika memiliki 2 anak di unit berbeda, sistem menyatukannya dalam fitur <em>Switch Child</em>.</li>
    <li><strong>Fungsi Utama:</strong> Memantau transparansi keuangan (tagihan & riwayat SPP), menyalin nomor Virtual Account untuk bayar tagihan, serta memantau hasil rapor sementara dan jejak absensi anak dari layar <em>smartphone</em>.</li>
</ul>

<h3>6. Siswa (Level ID: 13)</h3>
<ul>
    <li><strong>Audiens:</strong> Peserta Didik (Aplikasi Mobile).</li>
    <li><strong>Kapasitas Akses:</strong> Terbatas pada kelasnya saat ini.</li>
    <li><strong>Fungsi Utama:</strong> Mengunduh materi bahan ajar, mengirim pekerjaan rumah (Assignment), dan melaksanakan ujian semester. Saat ujian, peran ini otomatis memicu <strong>Safe Exam Browser (SEB)</strong> untuk mengunci ponsel agar terhindar dari kecurangan.</li>
</ul>

<h3>7. Kasi &amp; Pengawas (Level ID: 14 &amp; 15)</h3>
<ul>
    <li><strong>Audiens:</strong> Kepala Seksi Bidang Pendidikan / Tim Audit Yayasan (Dinas).</li>
    <li><strong>Kapasitas Akses:</strong> Pemantau Lintas Unit (<em>Cross-Tenant Observer</em>).</li>
    <li><strong>Fungsi Utama:</strong> Berperan sebagai auditor. Mereka tidak bisa menambah tagihan atau mengubah nilai, namun bertugas menarik laporan komprehensif dari berbagai unit sekolah untuk mengawal standardisasi mutu kurikulum dan kinerja pendidik se-Yayasan Al-Azhar.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('9. Peta Hierarki Peran (Roles) & Fungsinya')],
            [
                'title' => '9. Peta Hierarki Peran (Roles) & Fungsinya',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

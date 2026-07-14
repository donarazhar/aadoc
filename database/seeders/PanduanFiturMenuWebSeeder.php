<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanFiturMenuWebSeeder extends Seeder
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
<p>Dokumen ini merangkum seluruh daftar fitur dan fungsi menu pada portal <strong>Backoffice Web ALAZHARAPPS</strong>, yang dirancang khusus sebagai ruang kendali bagi Staf Tata Usaha, Admin Keuangan, Kepala Sekolah, dan Guru.</p>

<h3>1. Dasbor Utama &amp; Pencarian Global (Global Search)</h3>
<p>Layar kontrol utama yang menyajikan ringkasan data harian.</p>
<ul>
    <li><strong>Grafik Statistik:</strong> Menampilkan rasio kehadiran siswa hari ini, persentase kelulusan ujian, dan grafik pemasukan dana SPP bulanan.</li>
    <li><strong>Student 360 Search:</strong> Kotak pencarian sakti di pojok kanan atas. Ketikkan nama atau NISN siswa, dan sistem akan merangkum seluruh identitas, nilai akademik, serta tunggakan tagihannya dalam satu halaman utuh, mempermudah layanan komplain orang tua di loket Tata Usaha.</li>
</ul>

<h3>2. Modul Master Data &amp; PPDB</h3>
<p>Jantung operasional untuk mengelola kerangka administrasi yayasan.</p>
<ul>
    <li><strong>Tahun Ajaran &amp; Unit Sekolah:</strong> Menu untuk membuka periode akademik baru (misal: Ganjil 2026/2027) dan mendaftarkan cabang unit sekolah.</li>
    <li><strong>Data Induk Siswa &amp; Pegawai:</strong> Daftar buku induk untuk menambah, menyunting, atau menonaktifkan siswa dan guru (misal jika ada yang lulus atau *resign*).</li>
    <li><strong>Panel Penerimaan Siswa Baru (PPDB):</strong> Tempat memverifikasi pendaftaran dari <em>Landing Page</em>, memvalidasi bukti transfer uang pangkal, hingga mengeksekusi penempatan siswa baru ke kelas aktif.</li>
</ul>

<h3>3. Modul Akademik &amp; LMS (Khusus Guru &amp; Kepsek)</h3>
<p>Ruang pengelolaan kegiatan belajar mengajar.</p>
<ul>
    <li><strong>Manajemen Ruang Kelas:</strong> Fitur untuk membagi siswa ke dalam kelas (10 IPA 1, 10 IPA 2) serta menugaskan Wali Kelas.</li>
    <li><strong>Bahan Ajar &amp; Bank Soal:</strong> Repositori digital tempat guru mengunggah materi pelajaran (Video/PDF) dan meracik soal ujian (Pilihan Ganda/Esai). Soal dapat diimpor massal menggunakan Excel.</li>
    <li><strong>Penugasan &amp; Ujian (CBT):</strong> Panel pengaturan jadwal ujian. Di sinilah guru menekan tombol wajib (<em>Toggle</em>) <strong>Gunakan Safe Exam Browser</strong> agar aplikasi ponsel siswa terkunci saat ujian berlangsung.</li>
    <li><strong>Jurnal Mengajar &amp; Presensi:</strong> Formulir rekam jejak harian wajib bagi guru untuk mencatat ringkasan materi yang baru diajarkan serta menandai absensi kehadiran siswa di kelas tersebut.</li>
</ul>

<h3>4. Modul Keuangan &amp; Akuntansi</h3>
<p>Dapur transaksi yang menangani arus kas masuk tanpa perlu pengecekan rekening koran manual.</p>
<ul>
    <li><strong>Generate Tagihan Massal:</strong> Alat andalan Admin Keuangan untuk menerbitkan ratusan *invoice* SPP secara otomatis di awal bulan hanya dengan satu klik.</li>
    <li><strong>Monitor Pembayaran Real-time:</strong> Log transaksi instan yang terhubung ke Midtrans/Xendit. Status tagihan siswa akan berubah menjadi hijau (Lunas) tepat di detik saat uang ditransfer.</li>
    <li><strong>Penerimaan Tunai (Kasir):</strong> Menu khusus jika ada orang tua yang datang ke sekolah membayar secara tunai. Sistem otomatis mencetak kwitansi fisik.</li>
    <li><strong>Laporan Jurnal Akuntansi:</strong> Fitur ekspor (*Download to Excel/CSV*) yang merangkum debet/kredit penerimaan sekolah untuk diserahkan ke sistem ERP Yayasan Pusat.</li>
</ul>

<h3>5. Modul Pengaturan Hak Akses (RBAC)</h3>
<p>Laci pengamanan sistem yang dikendalikan oleh Superadmin/Kepala Sekolah.</p>
<ul>
    <li><strong>Role &amp; Permissions:</strong> Fitur untuk menugaskan peran secara spesifik. (Contoh: Menutup akses menu "Keuangan" bagi pengguna yang berstatus "Guru", dan membatasi agar Kepala Sekolah unit TK tidak bisa mengintip data siswa unit SD).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('8. [Web] Fitur dan Fungsi Menu Lengkap Backoffice')],
            [
                'title' => '8. [Web] Fitur dan Fungsi Menu Lengkap Backoffice',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

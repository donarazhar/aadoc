<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWebDataSiswaSeeder extends Seeder
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
<p>Panduan ini ditujukan bagi <strong>Staf Tata Usaha (Admin Sekolah)</strong> untuk mengelola data siswa, tahun ajaran, dan penempatan kelas melalui Portal Backoffice (Web) ALAZHARAPPS.</p>

<h3>1. Mengakses Backoffice dan Login</h3>
<ol>
    <li>Buka *browser* di komputer/laptop (disarankan Google Chrome).</li>
    <li>Akses tautan resmi Dasbor Sekolah: <code>apps.alazhar.or.id</code>.</li>
    <li>Masukkan Email dan Kata Sandi Akun Admin Anda.</li>
    <li>Pastikan Anda memilih <strong>Unit Sekolah</strong> yang tepat di pojok kanan atas (jika akun Anda memiliki akses ke beberapa unit/jenjang).</li>
</ol>

<h3>2. Melengkapi Master Data (Di Awal Semester)</h3>
<p>Sebelum menempatkan siswa ke kelas, Admin harus memastikan kerangka tahun ajaran sudah dibuat.</p>
<ol>
    <li>Pilih menu <strong>Master Data &gt; Tahun Ajaran</strong>. Klik tombol "Tambah Data" untuk mengaktifkan tahun akademik baru (misalnya "Ganjil 2026/2027").</li>
    <li>Pilih menu <strong>Master Data &gt; Ruang Kelas</strong>. Daftarkan nama-nama kelas yang aktif (contoh: 10 IPA 1, 10 IPA 2). Anda juga bisa menetapkan Wali Kelas pada *form* ini.</li>
</ol>

<h3>3. Mendaftarkan atau Memutasi Siswa</h3>
<p>Setelah kelas siap, langkah selanjutnya adalah memasukkan siswa.</p>
<ul>
    <li><strong>Input Siswa Baru (Manual):</strong> Buka menu <strong>Siswa &gt; Data Induk Siswa</strong>, klik "Tambah Siswa". Isi form biodata lengkap (Nama, NISN, Nama Orang Tua). Pastikan email orang tua diisi dengan benar agar mereka bisa <em>login</em> di aplikasi *mobile*.</li>
    <li><strong>Siswa Baru dari PPDB:</strong> Buka menu <strong>PPDB &gt; Verifikasi Kelulusan</strong>. Pilih siswa yang sudah melunasi Uang Pangkal, klik tombol <strong>"Aktifkan Status Siswa"</strong>. Siswa ini akan otomatis berpindah ke Data Induk.</li>
    <li><strong>Penempatan Kelas (Mutasi Kelas):</strong> Buka menu <strong>Akademik &gt; Mutasi Kelas</strong>. Pilih daftar siswa yang ada, lalu pindahkan secara massal (<em>Bulk Action</em>) ke kelas tujuan (misalnya 10 IPA 1) pada Tahun Ajaran Ganjil 2026/2027.</li>
</ul>

<h3>4. Fitur Pencarian Rekam Jejak (Trace)</h3>
<p>Jika ada wali murid yang bertanya ke Tata Usaha terkait status anak mereka, gunakan <strong>Bilah Pencarian Global (Global Search)</strong> di bagian atas atas dasbor. Ketikkan NISN atau Nama, maka sistem akan menampilkan tab riwayat kelas, tagihan, dan nilai dalam satu layar ringkas (Student 360 View).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('4. [Web] Manajemen Data Siswa & Kelas (Admin)')],
            [
                'title' => '4. [Web] Manajemen Data Siswa & Kelas (Admin)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

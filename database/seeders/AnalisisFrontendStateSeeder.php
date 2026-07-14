<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisFrontendStateSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Frontend & Mobile Apps')],
            [
                'name' => 'Frontend & Mobile Apps',
                'description' => 'Arsitektur klien untuk Web dan Aplikasi Genggam',
                'order' => 3,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini membedah arsitektur antarmuka klien (Frontend) berbasis NextJS, dengan fokus pada bagaimana aplikasi mengelola lalu lintas data secara dinamis (State Management).</p>

<h3>1. Arsitektur Komponen NextJS</h3>
<p>Proyek di dalam repositori <code>frontend</code> menggunakan pola desain modern dari React/NextJS.</p>
<ul>
    <li><strong>Client vs Server Components:</strong> Mengingat ini adalah aplikasi dasbor (Backoffice) yang sangat interaktif (tabel dinamis, grafik, form pendaftaran), sebagian besar komponen ditandai dengan <code>"use client"</code> di baris teratasnya. Ini berarti proses perenderan UI (*rendering*) sangat bergantung pada komputasi *browser* pengguna.</li>
    <li><strong>Isolasi Logika Form (React Hook Form + Zod):</strong> Untuk menangani form yang sangat panjang (seperti form biodata pendaftaran murid baru PPDB), tim tidak menggunakan pengikatan state React biasa (*two-way binding*). Mereka menggunakan <code>React Hook Form</code> untuk performa tanpa *lag*, yang dipadukan dengan <code>Zod</code>. Zod memastikan bahwa jika orang tua lupa mengisi Nomor Induk Kependudukan (NIK), form akan ditolak sebelum sempat menembak server (Validasi sisi Klien).</li>
</ul>

<h3>2. Manajemen State Global (Redux Toolkit)</h3>
<p>Karena ALAZHARAPPS memiliki lusinan modul (Keuangan, Rapor, Akademik, PPDB), memindahkan data antar-halaman (*prop drilling*) sangat merepotkan. Solusinya adalah Redux Toolkit (RTK).</p>
<ul>
    <li><strong>Pemisahan Slice:</strong> Setiap modul bisnis memiliki ruang penyimpanan (Store Slice) sendiri. Terdapat irisan untuk <code>authSlice</code> (menyimpan nama dan peran pengguna yang login) dan <code>studentSlice</code> (menyimpan daftar siswa yang sedang difilter oleh guru).</li>
    <li><strong>Komunikasi Asinkron (RTK Query / Thunks):</strong> Saat pengguna mengklik tombol "Simpan Data", Redux Thunk atau RTK Query bertugas melakukan pemanggilan API (Axios/Fetch) ke *Backend* Golang, menampilkan ikon *loading* putar (Spinner), dan memperbarui *State* tabel ketika respons sukses diterima.</li>
</ul>

<h3>3. Keamanan Sesi (Auth State)</h3>
<p><strong>[IMPORTANT] Penanganan JWT di Frontend:</strong> Saat *login* berhasil, token JWT tidak boleh dibiarkan mengambang di memori JS. Tim idealnya mengonfigurasi NextJS (melalui *API Routes*) untuk menerima JWT dari Golang, lalu membungkusnya ke dalam *HttpOnly Cookie*. Hal ini memastikan keamanan mutlak sehingga peretas tidak bisa mencuri token lewat celah XSS (Cross-Site Scripting).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('1. Bedah Arsitektur Frontend & Manajemen State (NextJS & Redux)')],
            [
                'title' => '1. Bedah Arsitektur Frontend & Manajemen State (NextJS & Redux)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

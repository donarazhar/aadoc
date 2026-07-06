<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuPrestasiArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Prestasi';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Prestasi</strong> dalam naungan modul "Sekolah" didedikasikan untuk membangun rekam jejak (<i>track record</i>) penghargaan dan pencapaian kompetitif, baik yang diraih secara individu maupun berkelompok. Melalui antarmuka "Tambah Prestasi" ini, sistem mendemonstrasikan keluwesan (<i>flexibility</i>) tingkat tinggi dalam mewadahi beragam variabel data perlombaan.</p>

<h3>Struktur Formulir Pencapaian (Achievement Form)</h3>
<p>Sistem tetap mematuhi pola desain 2-kolom (<i>two-column grid</i>) untuk memadatkan 10 <i>field</i> spesifik tanpa memaksa admin melakukan <i>scrolling</i> panjang ke bawah.</p>

<h4>1. Logika Bersyarat (Conditional Logic &amp; Dependent Input)</h4>
<p>Dua baris pertama formulir adalah jantung dari kecerdasan UI (<i>Smart UI</i>) halaman ini. Sistem tidak langsung melempar semua kolom untuk diisi secara membabi-buta, melainkan merespons secara dinamis:</p>
<ul>
    <li><strong>Klasifikasi Akar:</strong> Langkah wajib pertama, pengguna harus mendefinisikan ranah <code>Bidang</code> (misal: Akademik, Ekstrakurikuler) dan tipe entitas <code>Peserta</code> (Individu atau Kelompok) lewat komponen <i>dropdown</i>.</li>
    <li><strong>Input Terkunci (Dependent Input):</strong> Perhatikan <i>field</i> pencarian <code>Nama User</code>. Kolom ini berstatus terkunci/abu-abu (<i>disabled</i>) secara <i>default</i>. Kolom pencarian pintar (*Searchable Dropdown* "Cari Dengan NIS Atau Nama Siswa") ini baru akan bereaksi dan membuka diri <strong>setelah</strong> tipe "Peserta" didefinisikan. Ini merupakan teknik <i>Error Prevention</i> kasta tertinggi, memastikan admin tidak secara keliru memasukkan nama perorangan jika penghargaan tersebut sebenarnya milik regu basket, dan sebaliknya.</li>
</ul>

<h4>2. Variabel Kompetisi &amp; Komponen Unggah (Upload)</h4>
<p>Sisa formulir menuntut pengisian detail histori kompetisi yang dijejerkan secara simetris:</p>
<ul>
    <li><strong>Anatomi Acara:</strong> Mencakup rincian spesifik seperti <code>Kegiatan Lomba</code>, <code>Jenis Lomba</code>, <code>Tingkat</code> (misal: Kota, Nasional), hingga <code>Penyelenggara</code> (institusi pembuat acara).</li>
    <li><strong>Bukti &amp; Waktu:</strong> Tersedia isian <code>Juara</code> dan <code>Tahun</code>.</li>
    <li><strong>Integrasi File Upload Modern:</strong> Hal yang paling memanjakan mata adalah desain kolom penutup <code>Upload File</code> (untuk mengunggah <i>scan</i> piagam). Ketimbang menggunakan desain tombol abu-abu kuno (<i>native HTML file input</i>) yang sering merusak harmoni estetika, halaman ini meracik desain kustom: sebuah kolom teks penampung nama <i>file</i> disandingkan rapi dengan tombol <code>Upload</code> berwarna biru solid di sudutnya. Desain ini terasa jauh lebih profesional dan terintegrasi (*seamless*) dengan elemen UI lainnya.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman "Tambah Prestasi" adalah panggung unjuk gigi bagi konsep <strong>Conditional UI (Antarmuka Bersyarat)</strong>. Keberadaan kolom "Nama User" yang pasif dan menanti komando dari kolom sebelumnya mencerminkan empati mendalam sang desainer terhadap <i>user journey</i>—sistem seakan menggandeng tangan admin selangkah demi selangkah. Ditunjang oleh komponen unggah (*upload*) yang dipoles modern, tugas klerikal (*clerical*) seperti merekam piagam siswa sukses disulap menjadi pengalaman digital yang memuaskan dan anti-salah (*fool-proof*).</p>
',
                'is_published' => true,
                'order' => 15
            ]
        );
    }
}

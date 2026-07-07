<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulJurnalERapotMenuIjazahArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Jurnal & E-Rapot Menu Ijazah';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Bertengger di posisi paling buncit pada hierarki menu vertikal, <strong>Ijazah</strong> (di bawah modul Jurnal &amp; E-Rapot) adalah garis finis (<i>finish line</i>) sesungguhnya dari siklus hidup (*lifecycle*) seorang anak di sekolah. Halaman ini berfungsi sebagai Pusat Penerbitan Sertifikat Kelulusan (<i>Diploma Generation Hub</i>). Antarmukanya mewarisi DNA desain defensif dari halaman E-Rapot, dengan penekanan pada prinsip kehati-hatian tingkat tinggi melalui metode <strong>Filter-First</strong>.</p>

<h3>Struktur Antarmuka (UI) Pusat Cetak Ijazah</h3>
<p>Ijazah adalah dokumen legal yang diakui negara. Oleh karenanya, antarmuka ini dirancang untuk menyandera kelalaian manusia (<i>human error prevention</i>). Berikut adalah anatomi keamanannya:</p>
<ul>
    <li><strong>Restriksi Pemuatan Data (Filter-First):</strong> Halaman ini mengunci tabel data dengan sebuah <i>banner</i> notifikasi preskriptif: <i>"Silahkan filter terlebih dahulu..."</i>. Admin Tata Usaha tidak bisa melihat apalagi mencetak dokumen apa pun sebelum mereka mendeklarasikan secara eksplisit kombinasi <code>Kelas</code>, <code>Rombel</code>, dan <code>Tahun Ajaran</code>. Mekanisme ini memastikan *server* tidak terbebani secara konyol, sekaligus mengamankan admin dari insiden salah cetak ijazah untuk angkatan yang keliru.</li>
    <li><strong>Injeksi Tanggal Legalitas:</strong> Selembar ijazah tak bernilai hukum bila tanpa tanggal pengesahan. Halaman ini merespons fakta tersebut dengan menancapkan *field* <code>Tanggal Kelulusan (Masehi)</code> tepat di hulu tabel cetak. Kotak <i>date picker</i> ini berfungsi sebagai pendikte (<i>dictator</i>) bahwa seluruh *file* ijazah yang akan di-*generate* untuk angkatan (Rombel) tersebut harus dipasangi stempel tanggal yang seragam dan sah.</li>
    <li><strong>Transisi Identitas Kritis (NIS ke NISN):</strong> Ada pergeseran mikro pada desain *header* tabel yang patut diacungi jempol. Berbeda dengan menu E-Rapot yang mengandalkan NIS (Nomor Induk Siswa lokal), kolom kedua di halaman ini secara tegas tertulis <strong>NISN</strong> (Nomor Induk Siswa Nasional). Perubahan label ini menegaskan kepatuhan aplikasi terhadap standar regulasi Kementerian Pendidikan RI, di mana NISN adalah elemen pengenal tunggal wajib pada lembar ijazah resmi.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Dalam topologi <i>workflow</i> ERP <i>Al Azhar Apps</i>, halaman <strong>Ijazah</strong> mendapuk peran sebagai <strong>"Monumen Penutup Siklus"</strong> (<i>The Grand Academic Closure</i>).</p>
<ul>
    <li><strong>Hulu Referensi (Prerequisite Check):</strong> Keberadaan data di halaman ini terikat kuat (<i>tightly coupled</i>) dengan modul <strong>Akademik &gt; Kenaikan Kelas &amp; Kelulusan</strong>. Hanya siswa yang status akhirnya telah diketuk palu sebagai "Lulus" di modul tersebut yang secara logis boleh muncul di tabel ini. Ia juga memanggil profil akhir siswa, secara spesifik menyedot nomor NISN dari tabel <strong>Data Murid</strong>.</li>
    <li><strong>Hilir Produksi (Final Deliverable):</strong> Menu ini adalah titik penghabisan. Ia tidak lagi melempar data mentah ke menu lain. Fungsinya adalah pabrik konversi: merangkai agregasi data profil dan nilai akhir menjadi sebuah wujud fisik digital (berkas PDF/cetak). Berkas inilah yang pada akhirnya menjadi produk final (<i>deliverable output</i>) yang diserahkan ke tangan siswa dan orang tua.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Antarmuka halaman "Ijazah" sukses mengeksekusi konsep desain pertahanan (<i>defensive UI</i>) secara elegan. Melalui mekanisme penguncian *Filter-First*, pemaksaan *input* "Tanggal Kelulusan", serta penyesuaian cermat kolom identitas ke "NISN", perancang sistem menjamin bahwa operator terisolasi dari potensi kelalaian malapraktik administratif. Secara keseluruhan, menu ini adalah segel paripurna yang menutup tuntas perjalanan historis sang murid (<i>user journey</i>) di dalam semesta aplikasi ini.</p>
',
                'is_published' => true,
                'order' => 30
            ]
        );
    }
}

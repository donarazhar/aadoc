<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulJurnalERapotMenuERapotArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Jurnal & E-Rapot Menu E-Rapot';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Terletak di penghujung peta navigasi sistem, menu <strong>E-Rapot</strong> di bawah modul "Jurnal &amp; E-Rapot" adalah muara agung dari seluruh keringat dan aktivitas akademik selama satu semester. Halaman ini difungsikan sebagai "Pusat Generator Dokumen" (<i>Document Generation Hub</i>). Dari segi UI/UX, halaman ini dengan teguh menerapkan paradigma <strong>Filter-First</strong> (Penyaringan Prioritas), sebuah desain defensif yang melarang sistem menampilkan data apa pun sebelum kriteria pencarian dikerucutkan.</p>

<h3>Struktur Antarmuka (UI) Pusat Cetak Rapor</h3>
<p>Merender data nilai ribuan siswa memakan daya komputasi yang masif. Untuk mencegah layar membeku (*freeze*) atau <i>server overload</i>, antarmuka ini dirakit dengan beberapa pembatas kognitif dan teknis:</p>
<ul>
    <li><strong>Blokade *Filter-First*:</strong> Saat halaman dibuka, layar data sengaja dibiarkan kosong, digantikan oleh *banner* notifikasi persuasif: <i>"Silahkan filter terlebih dahulu untuk menampilkan data"</i>. Admin atau wali kelas dipaksa (<i>forced-action</i>) untuk mendefinisikan <code>Kelas</code>, <code>Rombel</code>, dan <code>Tahun Ajaran</code> sebelum menekan tombol biru <code>Tampilkan</code>. Pendekatan ini adalah standar emas UX untuk aplikasi <i>database</i> skala besar.</li>
    <li><strong>Kolom Tanggal Esensial:</strong> Di luar blok filter, tepat di atas tabel siswa, terdapat kalender input <code>Tanggal Cetak Rapot</code>. Fitur ini sangat spesifik menjawab tata-tertib birokrasi sekolah. Rapor adalah dokumen legal formal; tanggal pengesahannya harus valid dan seragam. Label peringatan merah tajam ("Wajib diisi untuk download") adalah bentuk <i>Error Prevention</i> absolut agar staf tidak keliru mengunduh rapor yang cacat hukum (tanpa tanggal).</li>
    <li><strong>Tabel Matriks Berbasis Komponen:</strong> Tabel *output* tidak sekadar menampilkan satu nilai gelondongan. Sistem secara cerdas membedah nilai menjadi kolom-kolom komponen: <code>Kelengkapan Rapor</code>, nilai per caturwulan/term (<code>Term 3</code>, <code>Term 4</code>), serta nilai keislaman khas yayasan (<code>Rapor Adab</code> dan <code>Rapor Tahfizh</code>). Pemisahan kolom ini memungkinkan wali kelas melakukan inspeksi visual kilat (<i>quick visual scan</i>)—misalnya, mencari sel mana yang masih kosong—sebelum mengeklik tombol unduh.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Dalam anatomi <i>workflow</i> institusi pendidikan, halaman <strong>E-Rapot</strong> adalah <strong>"Stasiun Akhir Akademik"</strong> (<i>The Academic Terminus</i>).</p>
<ul>
    <li><strong>Agregator Data Ekstrem (Massive Data Aggregation):</strong> Halaman ini adalah konsumen data paling rakus di seluruh sistem. Ia menarik kerangka rombongan belajar dari modul <strong>Sekolah &gt; Rombel</strong>, memanggil identitas siswa dari <strong>Data Murid</strong>, dan puncaknya: ia mengompilasi, menghitung, dan merekapitulasi ribuan entri nilai mentah dari modul Jurnal Mengajar/LMS para guru menjadi satu matriks nilai akhir.</li>
    <li><strong>Hilir Eksekusi (Digital Output):</strong> Halaman ini memutus rantai aliran data ke tabel lain. Produk akhirnya (<i>deliverable</i>) berupa berkas digital (umumnya PDF). File E-Rapot yang di-<i>generate</i> dari halaman ini akan didistribusikan melalui dua jalur: dicetak fisik untuk acara pembagian rapor di kelas, atau ditembakkan via API ke aplikasi portal Wali Murid agar orang tua dapat mengunduhnya langsung dari rumah.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Antarmuka "E-Rapot" berhasil menjinakkan kerumitan matematika akademik ke dalam dasbor operator yang rapi dan terukur. Implementasi *Filter-First* adalah keputusan <i>engineering</i> yang teramat cerdas untuk menghemat <i>bandwidth</i> server. Sementara itu, pemaksaan pengisian "Tanggal Cetak" menunjukkan kedalaman pemahaman *UI Designer* terhadap proses bisnis legalitas pendidikan. Singkat kata, menu ini adalah gerbang pamungkas yang menutup babak panjang satu semester dengan sangat elegan dan profesional.</p>
',
                'is_published' => true,
                'order' => 29
            ]
        );
    }
}

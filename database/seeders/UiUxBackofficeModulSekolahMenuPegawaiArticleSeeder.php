<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuPegawaiArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Pegawai';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Tambah Personnel</strong> yang berada di dalam submenu "Sekolah &gt; Pegawai" berfungsi sebagai gerbang utama (<i>entry point</i>) untuk mendaftarkan staf, guru, atau karyawan baru ke dalam ekosistem sistem informasi sekolah. Mengingat banyaknya himpunan data yang dibutuhkan untuk urusan kepegawaian, formulir ini dirancang menggunakan teknik desain <strong>Form Chunking</strong> (pemecahan formulir logis).</p>

<h3>Struktur Formulir Kepegawaian</h3>
<p>Demi mencegah kelelahan visual (<i>visual fatigue</i>) akibat <i>endless scrolling</i>, puluhan <i>field</i> input di halaman ini tidak ditumpuk menjadi satu deretan panjang, melainkan dikelompokkan ke dalam tiga panel (<i>cards</i>) tematik yang tertata rapi:</p>

<h4>1. Card "Profil" (Data Pribadi &amp; Atribut Karir)</h4>
<p>Panel teratas dan terpanjang ini merangkum identitas fundamental serta legalitas profesional seorang pegawai:</p>
<ul>
    <li><strong>Identitas Pokok:</strong> Diawali dengan <i>field full-width</i> untuk <code>Nama Lengkap</code>, dilanjutkan dengan <i>grid</i> dua kolom padat yang memuat <code>Gelar Depan</code>, <code>Gelar Belakang</code>, <code>NIK</code> (Nomor Induk Kependudukan), <code>NIP</code>, hingga <code>NPWP</code>.</li>
    <li><strong>Demografi &amp; Fisik:</strong> Menyediakan input <code>Tempat Lahir</code>, <code>Tanggal Lahir</code> (dengan kalender interaktif / <i>Datepicker</i>), <code>Golongan Darah</code>, serta penggunaan komponen <strong>Radio Button</strong> untuk memilih <code>Jenis Kelamin</code> (Laki-laki / Perempuan) agar input lebih cepat.</li>
    <li><strong>Atribut Kepegawaian:</strong> Menampung rincian SK meliputi <code>No. SK</code>, <code>TMT Pegawai</code> (Tanggal Mulai Tugas), <code>Pangkat / Golongan</code>, <code>Status Kepegawaian</code>, serta penentuan <code>Jabatan</code> (contoh: diisi dengan "Guru").</li>
</ul>

<h4>2. Card "Informasi Tempat Tinggal" (Data Geografis)</h4>
<p>Panel kedua bertugas untuk merekam riwayat domisili spesifik guna keperluan korespondensi maupun pemetaan zonasi:</p>
<ul>
    <li><strong>Hierarki Wilayah (Cascading Dropdowns):</strong> Memanfaatkan sistem <i>dropdown</i> bertingkat yang saling terkait, mulai dari <code>Provinsi</code>, <code>Kab/Kota</code>, <code>Kecamatan</code>, hingga <code>Kelurahan/Desa</code>.</li>
    <li><strong>Detail Spesifik:</strong> Disediakan kolom berukuran kecil untuk pengisian manual <code>RT</code> dan <code>RW</code>, serta input panjang untuk <code>Alamat Tempat Tinggal</code> (nama jalan/komplek) demi presisi lokasi.</li>
</ul>

<h4>3. Card "Informasi Keluarga" (Data Tanggungan)</h4>
<p>Panel terakhir ini sangat penting untuk pendataan profil keluarga, yang nantinya berimplikasi pada perhitungan pajak, tunjangan porsi keluarga, maupun pendaftaran asuransi/BPJS:</p>
<ul>
    <li><strong>Status &amp; Legalitas:</strong> Penggunaan <i>Radio Button</i> sangat mempermudah penentuan <code>Status Perkawinan</code> (Kawin / Belum Kawin / Duda/Janda). Dilengkapi pula dengan form <code>Nomor KK</code> dan <code>Nama Suami/Istri</code>.</li>
    <li><strong>Tanggungan Anak:</strong> Pertanyaan singkat "Memiliki / Tidak Memiliki" anak disajikan interaktif sebagai penutup lembar profil.</li>
</ul>

<h4>Panel Aksi (Action Bar)</h4>
<p>Sama persis seperti halaman manajemen sebelumnya, formulir ini ditutup dengan blok <i>footer</i> independen yang memuat tombol <strong>"Batalkan"</strong> (tombol sekunder bergaris batas) dan tombol <strong>"Simpan"</strong> (tombol primer biru padat). Desain aksi yang konsisten (<i>consistent UX pattern</i>) ini memastikan admin tidak perlu meraba-raba kembali letak tombol validasi setiap kali membuka menu baru.</p>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman pendaftaran pegawai ini merupakan contoh sempurna dari keberhasilan metode <strong>Chunking Concept</strong> dalam desain antarmuka. Memecah lebih dari 25 kolom input ke dalam tiga <i>card</i> logis (Profil, Alamat, Keluarga) dan mengaturnya rapi dalam format dua kolom, secara instan meredam intimidasi (<i>cognitive overload</i>) pada *user* yang harus melakukan pendataan massal. Pemilihan komponen seperti <i>Radio Buttons</i> dan <i>Datepickers</i> alih-alih isian teks bebas, sangat esensial untuk memangkas waktu kerja (<i>data entry time</i>) dan menjaga integritas (standardisasi format) struktur <i>database</i> HRD.</p>
',
                'is_published' => true,
                'order' => 10
            ]
        );
    }
}

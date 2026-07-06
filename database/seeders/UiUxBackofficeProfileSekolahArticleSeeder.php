<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeProfileSekolahArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Profile Sekolah
        $title = 'Profile Sekolah';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Profile Sekolah</strong> merupakan formulir <i>Master Data</i> terpusat yang menyimpan identitas resmi, lokasi geografis, dan struktur manajerial dari sebuah unit sekolah (misalnya: TK Islam Al Azhar 6 Sentra Primer). Akurasi data di halaman ini amat penting karena informasi di dalamnya seringkali dipanggil oleh sistem untuk mencetak <i>kop</i> surat resmi, kuitansi tagihan, maupun pelaporan kelembagaan.</p>

<h3>Struktur Formulir (Form Sections)</h3>
<p>Mengingat banyaknya data yang harus di-<i>input</i>, antarmuka ini mengelompokkan formulir ke dalam tiga bagian (<i>sections</i>) utama secara vertikal. Pendekatan ini (<i>Chunking</i>) bertujuan agar <i>cognitive load</i> atau beban pikiran pengguna tidak terlalu berat saat mengisi data.</p>

<h4>1. Bagian "Profile" (Identitas &amp; Legalitas Instansi)</h4>
<p>Area ini mengakomodir data-data administratif. <i>Field</i> disusun menggunakan <i>layout</i> dua kolom (<i>two-column grid</i>) untuk memaksimalkan ruang horizontal layar:</p>
<ul>
    <li><strong>Data Pokok &amp; Izin:</strong> Memuat <code>NPSN</code>, <code>NIS</code>, <code>Nomor SK IJOP (Ijin Operasional)</code>, dan <code>NPWP</code>.</li>
    <li><strong>Informasi Dasar:</strong> Memuat <code>Jenjang</code> (misal: TKA), <code>Nama Sekolah</code>, <code>Tahun Berdiri</code>, <code>Tahun Akreditasi</code>, dan <code>Nilai Akreditasi</code>.</li>
    <li><strong>Afiliasi:</strong> Memuat <code>Kategori</code> status sekolah (misal: Cabang Langsung), <code>Nama Yayasan</code>, serta media kontak <code>Email</code> dan <code>Website</code> yayasan.</li>
</ul>

<h4>2. Bagian "Lokasi" (Hierarki Geografis &amp; Pemetaan Visual)</h4>
<p>Berfungsi untuk merekam koordinat dan alamat persis institusi. Desain antarmuka pada sesi ini menggabungkan fungsi teks, <i>dropdown</i> berjenjang, dan pemetaan interaktif:</p>
<ul>
    <li><strong>Hierarki Wilayah (Cascading Dropdowns):</strong> Tersedia <i>dropdown</i> yang otomatis saling menyaring (<i>filter</i>) dari skala besar ke kecil, mulai dari <code>Provinsi</code>, <code>Kab/Kota</code>, <code>Kecamatan</code>, hingga <code>Kelurahan/Desa</code>.</li>
    <li><strong>Alamat Spesifik:</strong> Dilengkapi dengan <i>field</i> manual untuk isian <code>RT</code>, <code>RW</code>, <code>Kode Pos</code>, dan teks area untuk <code>Alamat</code> rinci.</li>
    <li><strong>Integrasi Google Maps (Visual Validation):</strong> Sistem memfasilitasi <i>field</i> khusus <code>Lokasi Koordinat</code> berupa tautan (URL). Hebatnya, sistem langsung merender Peta Interaktif (Google Maps) di bagian bawahnya, memberikan validasi visual seketika agar admin yakin bahwa titik koordinat (*pinpoint*) sekolah tidak meleset.</li>
</ul>

<h4>3. Bagian "Struktur Pegawai" (Kontak Kepemimpinan &amp; TU)</h4>
<p>Menginventarisasi kontak krusial para pemangku kebijakan (<i>Decision Makers</i>) dan pelaksana administrasi. Bagian ini juga memanfaatkan <i>layout</i> dua kolom:</p>
<ul>
    <li><strong>Pimpinan:</strong> Disediakan baris isian untuk <code>Nama Kepala Sekolah</code>, <code>Email</code>, dan <code>Telepon/WA Kepala Sekolah</code>.</li>
    <li><strong>Wakil &amp; Staf Administrasi:</strong> Sistem juga mengakomodir struktur berlapis, memberikan <i>field</i> serupa untuk Wakil Kepala Sekolah 1 dan 2, berlanjut hingga jajaran staf Tata Usaha (TU 1 sampai TU 4).</li>
</ul>
<p>Di penghujung formulir panjang ini, terdapat satu tombol <strong>"Simpan"</strong> berwarna biru (<i>primary button</i>) yang diletakkan pas di sudut kanan bawah. Penempatan ini sejalan dengan arah baca alami manusia (<i>Z-pattern / F-pattern</i>).</p>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Desain formulir pada "Profile Sekolah" merupakan manifestasi dari penerapan <strong>Information Architecture</strong> yang matang. Pengelompokan isian data ke dalam blok logis (Profil, Lokasi, Pegawai) dipadankan dengan *grid* dua kolom sangat sukses menekan potensi kebosanan pengguna karena layar tidak terlihat "*endless scrolling*". Kehadiran peta interaktif yang tertanam langsung (*embedded map*) juga merupakan sentuhan <i>micro-interaction</i> cemerlang guna menghapus keraguan <i>human error</i> dalam hal pemetaan lokasi.</p>
',
                'is_published' => true,
                'order' => 6
            ]
        );
    }
}

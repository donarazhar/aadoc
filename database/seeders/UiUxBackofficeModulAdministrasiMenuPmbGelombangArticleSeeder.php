<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuPmbGelombangArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu PMB > Gelombang';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Gelombang Pendaftaran</strong> (atau Gelombang PMB) di dalam hierarki modul "Administrasi" bertugas sebagai <i>master control</i> untuk mengatur siklus waktu serta target kuota penerimaan siswa baru. Lewat antarmuka "Tambah Gelombang", kita disuguhkan demonstrasi bagaimana sebuah desain formulir (<i>form design</i>) dapat berevolusi mengakomodasi kepadatan data, beralih luwes dari komponen <i>dropdown</i> hingga ke pengaturan rentang kalender.</p>

<h3>Struktur Formulir Pengaturan Gelombang</h3>
<p>Halaman ini senantiasa mempertahankan fondasi visual <i>White Card</i> (panel putih) tunggal untuk merangkum semua spesifikasi pendaftaran. Yang menjadikannya unik adalah transisi <i>grid</i> yang dinamis (dari 2-kolom menjadi 3-kolom) untuk menyesuaikan dengan fungsi input yang spesifik.</p>

<h4>1. Konfigurasi Relasional &amp; Penguncian Unit (Two-Column Layout)</h4>
<p>Tiga baris pertama formulir dihuni oleh kombinasi parameter wajib dan input yang dikunci (<i>locked inputs</i>):</p>
<ul>
    <li><strong>Integritas Waktu &amp; Identitas:</strong> <i>Field</i> krusial seperti <code>Gelombang</code> dan <code>Tahun Ajaran</code> mutlak menggunakan <i>Dropdown</i>, tidak memberikan celah bagi pengetikan bebas (*free text*) demi memastikan penyeragaman data (<i>data uniformity</i>).</li>
    <li><strong>Komponen Chip Interaktif:</strong> Kolom <code>Jenjang</code> (misal: TKIA) dikunci rapat dengan latar abu-abu sebagai wujud <i>Error Prevention</i> standar aplikasi. Namun sorotan utama ada pada kolom <code>Nama Sekolah</code> (misal: TK Islam Al Azhar 6...). Alih-alih berupa teks mati, nilai tersebut direpresentasikan sebagai label interaktif bergaya <i>Chip/Tag</i> yang dibubuhi ikon silang (<code>x</code>). Konvensi visual UI ini mengindikasikan kapabilitas <i>multi-select</i> (pilihan jamak)—memungkinkan satu jadwal gelombang diaplikasikan secara sinkron ke beberapa cabang sekolah sekaligus.</li>
    <li><strong>Parameter Operasional:</strong> Disokong oleh <i>field</i> <code>Target Sekolah</code> untuk mendefinisikan batas maksimal pendaftar (kuota), dan <code>Status</code> guna mengendalikan visibilitas gelombang secara *real-time*.</li>
</ul>

<h4>2. Manajemen Penjadwalan Rapat (Three-Column Date Pickers)</h4>
<p>Baris penutup formulir adalah <i>masterclass</i> dalam efisiensi visual (<i>visual efficiency</i>):</p>
<ul>
    <li><strong>Pemampatan Horisontal:</strong> Untuk mengatur kronologi berjalannya PMB, desainer membelah layar menjadi 3 kolom identik: <code>Tanggal Mulai Dibuka</code>, <code>Tanggal Ditutup</code>, dan <code>Tanggal Jatuh Tempo</code>. Membariskan ketiganya secara sejajar terbukti sangat efektif memangkas tinggi halaman secara drastis (*reducing scrolling fatigue*).</li>
    <li><strong>Affordance Kalender:</strong> Ketiga kolom tersebut mengimplementasikan komponen <i>Date Picker</i> (pemilih kalender) yang *native*. Ikon kalender kecil yang disematkan di ujung kanan tiap-tiap kotak (<i>field</i>) merupakan penanda visual (<i>affordance</i>) yang jelas bahwa sistem mengharapkan *input* tanggal baku, bukan ketikan <i>string</i> manual.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Antarmuka halaman "Tambah Gelombang" memamerkan kecakapan luar biasa dalam menata <strong>Kepadatan Informasi (Information Density)</strong>. Daripada menyusun 9 variabel pengaturan yang kompleks secara runut ke bawah—yang pasti akan mengintimidasi admin—desainer meraciknya ke dalam blok-blok proporsional (2-kolom disusul 3-kolom). Diperlengkapi komponen cerdas semacam <i>Tags/Chips multi-select</i> untuk institusi dan <i>Triple Date Pickers</i> untuk linimasa, tata letak ini sanggup menyederhanakan konfigurasi kebijakan PMB yang sejatinya sangat rumit menjadi sebuah pengalaman <i>data-entry</i> yang mengalir dan kohesif.</p>
',
                'is_published' => true,
                'order' => 18
            ]
        );
    }
}

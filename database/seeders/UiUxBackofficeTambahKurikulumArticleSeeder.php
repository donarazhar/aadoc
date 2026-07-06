<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeTambahKurikulumArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Tambah Kurikulum (Mata Pelajaran)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Tambah Kurikulum</strong> yang berada di bawah modul "Sekolah &gt; Kurikulum" memegang peranan vital sebagai cetak biru (<i>blueprint</i>) aktivitas akademik. Melalui antarmuka inilah bagian kurikulum atau admin merancang struktur standar belajar, termasuk mengatur jam operasional sekolah dan mengalokasikan Mata Pelajaran (Mapel) pada jenjang kelas tertentu.</p>

<h3>Struktur Formulir Kurikulum</h3>
<p>Senada dengan pendekatan pada halaman pembuatan kelas, antarmuka ini mengusung pola <strong>Single-Page Workflow</strong>. Pengguna tak perlu lagi melompat-lompat antar halaman demi menuntaskan satu tugas. Halaman ini terbelah menjadi dua panel logis:</p>

<h4>1. Bagian Data Master Kurikulum (Grid Layout)</h4>
<p>Bagian atas halaman berfungsi untuk mengikat parameter fundamental dari kurikulum yang hendak dibentuk. Penggunaan <i>grid</i> dua kolom memberikan kesan formulir yang ringkas dan padat:</p>
<ul>
    <li><strong>Parameter Hierarki:</strong> <i>Dropdown</i> <code>Tahun Ajaran</code> dan <code>Tingkat Kelas</code> bertugas mengunci konteks spesifik dari kurikulum ini.</li>
    <li><strong>Sistem Kurikulum:</strong> <i>Dropdown</i> <code>Kurikulum</code> disediakan untuk memilih nama standar akademik yang diterapkan (contoh: Kurikulum Merdeka, K13, Kurikulum Cambridge, dll).</li>
    <li><strong>Alokasi Jam Operasional:</strong> Menghindari <i>human error</i> dalam pengetikan jam, sistem menyediakan dua input <strong>Time Picker</strong> lengkap dengan ikon jam analog untuk menentukan <code>Mulai Jam Belajar</code> dan <code>Selesai Jam Belajar</code>. Komponen ini sangat intuitif dan otomatis memformat input waktu secara seragam (misal: 07:00 - 15:00).</li>
</ul>

<h4>2. Bagian Detail Mata Pelajaran (Tabel &amp; Empty State)</h4>
<p>Di bagian paruh bawah, terdapat area fungsional untuk merincikan Mata Pelajaran apa saja yang dibebankan pada kurikulum yang sedang dirakit ini.</p>
<ul>
    <li><strong>Tombol Aksi "+ Tambah Mapel":</strong> Tombol navigasi berwana biru ini bertindak sebagai <i>Call-to-Action</i> utama untuk mengisi tabel. Saat ditekan, sistem kemungkinan memicu baris interaktif atau <i>modal pop-up</i> guna menyeleksi mapel.</li>
    <li><strong>Ilustrasi Kosong (Empty State):</strong> Salah satu keunggulan desain UX di halaman ini adalah penanganan data tabel yang nihil. Ketimbang menampilkan pesan error yang membingungkan atau tabel putih polos yang seolah "*nge-bug*", sistem menampilkan ilustrasi ikon dokumen yang elegan. Secara psikologis, grafis ini memberikan umpan balik (<i>feedback</i>) yang ramah bahwa sistem bekerja normal, hanya saja pengguna memang belum memasukkan data mapel satupun.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Arsitektur UI/UX pada halaman "Tambah Kurikulum" amat kental dengan prinsip <strong>Error Prevention (Pencegahan Kesalahan)</strong> dan <strong>System Status Visibility</strong>. Penerapan <i>Time Picker</i> yang membentengi pengguna dari kesalahan format input, dipadukan dengan desain *empty state* yang menenangkan pada bagian tabel Mapel, menciptakan perjalanan interaksi (*user journey*) yang sangat suportif, minim asumsi, dan bebas dari kebingungan teknis.</p>
',
                'is_published' => true,
                'order' => 8
            ]
        );
    }
}

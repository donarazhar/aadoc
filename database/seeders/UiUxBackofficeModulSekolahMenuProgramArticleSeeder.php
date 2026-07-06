<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuProgramArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Program';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Program</strong> (secara spesifik pada halaman <i>Tambah Program</i>) yang terletak di bawah hierarki modul "Sekolah" berfungsi untuk mendaftarkan jenis program pendidikan apa saja yang ditawarkan oleh institusi terkait. Halaman ini didesain sangat minimalis, tajam, dan terarah (<i>focused</i>), demi mencegah kompleksitas input yang tidak perlu.</p>

<h3>Struktur Formulir Program</h3>
<p>Berbanding terbalik dengan halaman <i>Master Data</i> lainnya yang umumnya sarat akan kolom isian, antarmuka "Tambah Program" tampil dengan sangat ringkas. Halaman ini hanya mengandalkan satu panel (<i>card</i>) formulir, yang diikuti oleh panel aksi di bagian bawahnya.</p>

<h4>1. Panel Pengisian Data (Data Entry Card)</h4>
<p>Formulir diatur menggunakan tata letak dua kolom (<i>two-column grid</i>). Sorotan utama pada aspek UI/UX di area ini adalah pemanfaatan <i>state</i> "<i>Disabled / Read-only</i>" yang dieksekusi secara brilian:</p>
<ul>
    <li><strong>Smart Defaults &amp; Penguncian Identitas:</strong> <i>Field</i> <code>Sekolah</code> dan <code>Jenjang</code> sengaja dikunci oleh sistem (ditandai dengan warna latar abu-abu/ter-<i>disable</i>). Sistem secara otomatis mendeteksi identitas institusi dari sesi admin yang sedang login (misal: memunculkan teks "TK Islam Al Azhar 6 Sentra Primer" dengan jenjang "TKIA"). Ini adalah penerapan UX yang fenomenal karena membebaskan pengguna dari tugas berulang untuk memilih nama sekolahnya sendiri, sekaligus memblokir absolut kemungkinan <i>human error</i> (salah pilih unit sekolah).</li>
    <li><strong>Input Utama yang Terfokus:</strong> Dengan terkuncinya kedua kolom di atas, perhatian pengguna kini bisa terpusat 100% hanya pada satu tugas: memilih <i>dropdown</i> <code>Nama Program</code> yang ingin diaktifkan (misal: Program Reguler, Bilingual, Akselerasi, dsb).</li>
</ul>

<h4>2. Panel Aksi (Action Bar)</h4>
<p>Tepat di bawah formulir pengisian, sistem menyediakan satu blok putih independen yang khusus mewadahi deretan tombol eksekusi. Pemisahan blok secara visual (<i>visual boundary</i>) ini mempertegas perbedaan antara "area mengetik" dan "area mengambil keputusan".</p>
<ul>
    <li><strong>Tombol Batalkan (Secondary Action):</strong> Memiliki gaya desain tombol sekunder (warna latar putih dengan garis batas abu-abu). Diposisikan di sebelah kiri tombol utama sebagai opsi jalan keluar (<i>escape hatch</i>) yang aman apabila pengguna urung menyimpan data.</li>
    <li><strong>Tombol Simpan (Primary Action):</strong> Didesain sebagai tombol utama (warna biru solid yang cerah) dan diperkuat dengan ikon <i>save</i>. Posisinya di sudut kanan bawah sangat sejalan dengan titik akhir pergerakan mata dan kursor dalam pola baca Z (<i>Z-pattern reading</i>), sehingga aksi penyelesaian terasa alami dan memuaskan.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman "Tambah Program" mencontohkan dengan sempurna bahwa tidak semua formulir harus panjang. Dengan mempraktikkan prinsip <strong>Smart Defaults</strong>—mengisi dan mengunci otomatis atribut Sekolah dan Jenjang—antarmuka ini berhasil memangkas drastis beban kognitif (<i>cognitive load</i>) pengguna. Kesederhanaan <i>layout</i> yang disajikan dipadukan dengan pemisahan panel aksi yang tegas, menjadikan alur kerja (<i>workflow</i>) penambahan program di halaman ini terasa luar biasa cepat, protektif terhadap kesalahan, dan sangat efisien.</p>
',
                'is_published' => true,
                'order' => 9
            ]
        );
    }
}

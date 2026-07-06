<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuEkstrakurikulerArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Ekstrakurikuler';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Ekstrakurikuler</strong> yang bernaung di bawah modul "Sekolah" berperan sebagai pusat pengelolaan kegiatan non-akademis bagi siswa. Melalui tangkapan layar antarmuka "Tambah Ekstrakurikuler", aplikasi mendemonstrasikan bagaimana sebuah formulir pendataan mampu dirancang secara amat minimalis, namun tetap mengakomodasi seluruh esensi fungsional yang dibutuhkan pengelola sekolah.</p>

<h3>Struktur Formulir Ekstrakurikuler</h3>
<p>Halaman ini mempertahankan keteguhan (*consistency*) arsitektur UI sistem dengan halaman <i>Master Data</i> lainnya: memusatkan <i>data entry</i> pada satu panel putih utama (<i>Card</i>), yang kemudian ditutup oleh panel eksekusi (<i>Action Bar</i>) di bagian bawah layar.</p>

<h4>1. Tata Letak Fleksibel (Mixed Grid Layout)</h4>
<p>Guna mengoptimalkan ruang layar (<i>screen real estate</i>) tanpa menciptakan kesan sesak, baris-baris formulir disusun dengan mengawinkan format rentang penuh (<i>full-width</i>) dan paruh rentang (<i>half-width</i>):</p>
<ul>
    <li><strong>Input Fundamental (Full-Width):</strong> Kolom isian <code>Nama Ekstrakulikuler</code> ditempatkan paling atas dengan lebar membentang 100%. Keputusan ini sangat natural secara UX karena ia merupakan penanda identitas primer (*primary identifier*). Format serupa diterapkan pada kolom penutup <code>Keterangan Kegiatan</code>; pemberian ruang lebar memanjakan admin untuk leluasa mengetikkan rincian deskripsi, target capaian, hingga jadwal latihan tanpa merasa teksnya terpotong sempit.</li>
    <li><strong>Input Pendukung (Half-Width):</strong> Diapit oleh kedua <i>field</i> raksasa tadi, terdapat kolom <code>Biaya</code> dan <code>Nama Pelatih</code> yang didesain berdampingan (pola <i>grid</i> 2 kolom). Ini adalah taktik desain (<i>design tactic</i>) yang brilian. Mengingat kedua data ini umumnya hanya membutuhkan beberapa karakter pendek (angka nominal rupiah dan nama pendek pelatih), merentangkannya secara penuh hanya akan menyisakan ruang putih kosong yang sia-sia (*wasted whitespace*).</li>
</ul>

<h4>2. Panel Aksi Independen (Action Bar)</h4>
<p>Sebagai pamungkas alur kerja (<i>workflow</i>), area penentuan keputusan diisolasi secara visual:</p>
<ul>
    <li>Tombol sekunder <strong>"Batalkan"</strong> hadir sebagai fitur jaring pengaman (<i>safety net</i>) bagi admin yang ingin mereset layar input.</li>
    <li>Tombol primer <strong>"Simpan"</strong> yang didominasi warna biru cerah menjadi sauh visual (<i>visual anchor</i>), memberi kepastian langkah akhir pendaftaran data ekskul baru.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Antarmuka pada halaman "Tambah Ekstrakurikuler" adalah manifestasi luar biasa dari filosofi <strong>"Less is More"</strong>. Dengan hanya mendayagunakan empat kotak input yang disusun atraktif (bermain pada kontras panjang-pendek isian), formulir ini terasa sangat ringan, mengalir (<i>flowing</i>), dan nihil <i>cognitive overload</i> (beban mental pengguna). Praktik UI ini menjamin kelancaran tata usaha sekolah, memastikan pendataan puluhan jenis ekskul di awal tahun ajaran dapat diselesaikan dengan sekejap mata.</p>
',
                'is_published' => true,
                'order' => 14
            ]
        );
    }
}

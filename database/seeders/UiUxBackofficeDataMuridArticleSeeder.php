<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeDataMuridArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Data Murid
        $title = 'Master Data Murid';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Data Murid</strong> yang berada di bawah modul "Sekolah" adalah antarmuka utama (<i>Master Data</i>) untuk mengelola seluruh profil siswa yang telah resmi terdaftar di institusi pendidikan terkait.</p>

<h3>Fungsi dan Komponen Antarmuka</h3>
<p>Halaman ini dirancang dengan elegan namun sarat akan fungsi esensial untuk memudahkan tim tata usaha (TU) atau admin sekolah dalam menginspeksi dan memutakhirkan profil setiap murid.</p>

<h4>1. Pencarian dan Filter Cerdas</h4>
<ul>
    <li><strong>Pencarian Global:</strong> Terdapat kolom pencarian (<i>Search bar</i>) berukuran besar di bagian paling atas untuk melacak data murid secara instan, cukup dengan mengetikkan nama atau NIS tanpa perlu mengatur parameter lainnya.</li>
    <li><strong>Panel Filter Ekstensif:</strong> Dengan menekan tombol hijau "Filter", sebuah panel putih interaktif akan muncul. Panel ini memuat empat opsi <i>dropdown</i> utama: <code>Tahun Ajaran</code>, <code>Kelas</code>, <code>Status</code> (semua, aktif, lulus, pindah, dll.), dan <code>Program</code>. Tersedia tombol "Terapkan" dan "Reset" agar kueri perpaduan filter dapat dieksekusi secara manual ke database, meminimalisir loading tak terduga.</li>
</ul>

<h4>2. Tabel Master Data</h4>
<p>Tabel disajikan secara horizontal dan informatif, mengakomodasi rincian fundamental dari profil siswa:</p>
<ul>
    <li><strong>Identitas Dasar:</strong> Menampilkan kolom <code>Nama Lengkap</code>, <code>NIS</code> (Nomor Induk Siswa), dan <code>Jenis Kelamin</code>.</li>
    <li><strong>Penempatan Akademis:</strong> Kolom <code>Tahun Ajaran</code>, <code>Kelas</code>, <code>Rombel</code> (Rombongan Belajar), dan <code>Program</code> memberikan kejelasan absolut mengenai penempatan siswa pada tahun ajaran yang sedang aktif.</li>
    <li><strong>Status:</strong> Diwakili oleh komponen <i>badge</i> atau label warna yang menonjol (contoh: label hijau pastel bertuliskan "Aktif"). Fitur visual ini mempercepat identifikasi apakah seorang murid masih aktif menempuh pendidikan, ataukah sudah berstatus alumni/mutasi.</li>
</ul>

<h4>3. Kolom Aksi (Action)</h4>
<p>Kolom paling kanan (<code>Aksi</code>) disisihkan secara eksklusif untuk tindakan manajerial per baris data, dengan memanfaatkan desain ikonografi untuk menghemat ruang:</p>
<ul>
    <li><strong>Icon Pensil (Edit):</strong> Berfungsi memicu formulir pembaruan atau koreksi biodata murid apabila terdapat perubahan informasi krusial (seperti pindah alamat, pergantian nomor handphone wali, dll).</li>
    <li><strong>Icon Kaca Pembesar (Detail):</strong> Berfungsi sebagai pintu masuk menuju halaman <i>Profil Detail Siswa</i> yang jauh lebih komprehensif, mencakup riwayat tagihan finansial, riwayat absensi, hingga catatan khusus lainnya.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman Master Data Murid menjunjung tinggi prinsip <strong>Clarity and Efficiency</strong>. Penyusunan <i>layout</i> tabel yang berjarak lega, status berbentuk <i>badge</i> yang kontras, serta mekanisme penyembunyian <i>form filter</i> tingkat lanjut di balik opsi <i>collapse/expand</i> (tombol "Filter"), berhasil menciptakan pengalaman pengguna yang bersih (<i>clean look</i>). Hal ini terbukti mampu menjaga konsentrasi admin sekolah meski harus memproses ribuan baris data siswa setiap harinya.</p>
',
                'is_published' => true,
                'order' => 5
            ]
        );
    }
}

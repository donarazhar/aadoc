<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeMuridArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Dashboard Murid
        $title = 'Dashboard Menu Murid';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Dashboard Murid</strong> merupakan pusat pemantauan analitik yang berfokus pada statistik kesiswaan, melingkupi proses Penerimaan Murid Baru (PMB) hingga status murid aktif pada tahun ajaran yang sedang berjalan.</p>

<h3>Komponen Utama Halaman</h3>

<h4>1. Proses PMB (Penerimaan Murid Baru)</h4>
<p>Bagian ini memberikan visibilitas penuh terhadap corong (funnel) pendaftaran siswa baru:</p>
<ul>
    <li><strong>Progress Bar Capaian vs Target:</strong> Indikator visual progres jumlah perolehan siswa dibandingkan dengan target yang ditetapkan.</li>
    <li><strong>Kartu Total Animo:</strong> Melacak prospek awal (animo). Menampilkan total animo beserta rincian yang "Sudah Bayar" dan "Belum Bayar" biaya pendaftaran/formulir.</li>
    <li><strong>Kartu Total Pendaftar:</strong> Melacak pendaftar yang sedang berproses. Menampilkan rincian status seperti Belum Melengkapi PMB, Lulus, Tidak Lulus, dan Cadangan.</li>
    <li><strong>Kartu Calon Murid:</strong> Melacak kandidat yang sudah lolos seleksi awal. Menampilkan rincian pembayaran Uang Pangkal (UP) yang "Sudah Bayar UP" dan "Belum Bayar UP".</li>
</ul>

<h4>2. Jumlah Murid Tahun Berjalan</h4>
<p>Menampilkan 4 metrik status murid pada tahun ajaran aktif melalui kartu indikator warna-warni:</p>
<ul>
    <li><strong>Total Aktif:</strong> Jumlah keseluruhan murid yang aktif bersekolah.</li>
    <li><strong>Total Daftar Ulang:</strong> Jumlah murid yang sudah melakukan daftar ulang untuk tahun ajaran selanjutnya.</li>
    <li><strong>Total Lulus:</strong> Jumlah murid yang telah lulus dari jenjang tersebut.</li>
    <li><strong>Pindah Keluar:</strong> Jumlah murid yang mutasi atau pindah sekolah.</li>
</ul>

<h4>3. Grafik Total Murid (Distribusi Status)</h4>
<p>Grafik batang interaktif yang memecah seluruh pergerakan status siswa (mulai dari Animo PMB hingga status akhir seperti Naik Kelas, Lulus, atau Pindah). Komponen ini memberikan gambaran komprehensif tentang distribusi populasi murid di semua tahapan administrasi.</p>

<h4>4. Grafik Jumlah Murid Per Kelas</h4>
<p>Grafik batang sekunder yang berfokus pada kepadatan rombongan belajar:</p>
<ul>
    <li>Dilengkapi filter <strong>Semester</strong> (Ganjil/Genap) dan <strong>Tahun Ajaran</strong>.</li>
    <li>Menampilkan jumlah murid per tingkat kelas (misalnya: Playgroup, TK A, TK B, Toddler) sehingga admin dapat memantau rasio dan kapasitas kelas.</li>
</ul>

<h4>5. Ringkasan Jumlah PMB</h4>
<p>Sebuah panel khusus yang memberikan kesimpulan cepat mengenai Target, Pendaftar, dan Perolehan akhir siswa baru untuk mempermudah evaluasi akhir panitia PMB.</p>

<h4>6. Daftar Calon Siswa Belum Membayar Formulir</h4>
<p>Tabel interaktif atau <i>actionable list</i> di bagian paling bawah yang menampilkan data calon siswa yang belum melunasi biaya formulir. Tabel ini mencakup detail seperti Nama Calon Siswa, Tujuan Sekolah, Program, Asal Sekolah, No HP, dan Status (contoh: "Belum Dikonfirmasi Ulang"). Fitur ini sangat penting untuk tim administrasi melakukan <i>follow-up</i> kepada orang tua/wali murid.</p>
',
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class PanduanMembacaAlurArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori Backoffice Al Azhar Apps ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Backoffice Al Azhar Apps')],
            ['name' => 'Backoffice Al Azhar Apps', 'description' => 'Artikel tentang sistem backoffice Al Azhar Apps', 'order' => 1]
        );

        // Buat artikel Panduan Membaca Alur (Flow) Utama Diagram
        $title = 'Panduan Membaca Alur (Flow) Utama Diagram';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p><strong>3. Panduan Membaca Alur (Flow) Utama Diagram</strong></p>
<p>Untuk memahami bagaimana data bergerak di dalam ERD dan aplikasi, berikut adalah 3 alur operasional utamanya:</p>

<h3>A. Alur PMB (Penerimaan Murid Baru)</h3>
<ol>
    <li><strong>Inisiasi:</strong> Pihak sekolah (Admin) membuat <code>GELOMBANG_PMB</code> yang dihubungkan ke <code>SEKOLAH</code> dan <code>TAHUN_AJARAN</code> tertentu.</li>
    <li><strong>Pendaftaran:</strong> Siswa baru masuk ke dalam tabel <code>CALON_MURID</code> (dimulai dari status Animo). Mereka memilih <code>PROGRAM</code> (misal: Reguler).</li>
    <li><strong>Seleksi:</strong> Admin membuat <code>JADWAL_UJIAN</code>. <code>CALON_MURID</code> kemudian dihubungkan ke jadwal tersebut dan masuk ke tabel <code>PESERTA_UJIAN</code>.</li>
    <li><strong>Kelulusan:</strong> Nilai diinput di <code>PESERTA_UJIAN</code>. Jika lolos, status <code>CALON_MURID</code> berubah menjadi Lulus. Setelah mereka membayar uang daftar ulang/pangkal, data mereka di-migrasi (atau direlasikan) untuk membuat record baru di tabel <code>MURID</code>.</li>
</ol>

<h3>B. Alur Akademik (Rombongan Belajar)</h3>
<ol>
    <li><strong>Persiapan Kelas:</strong> Admin membuat <code>ROMBEL</code> (Kelas). Rombel ini membutuhkan relasi ke <code>TAHUN_AJARAN</code>, <code>TINGKAT_KELAS</code>, dan membutuhkan satu orang <code>PEGAWAI</code> yang bertindak sebagai Wali Kelas.</li>
    <li><strong>Penempatan Murid:</strong> Data dari tabel <code>MURID</code> (baik murid baru dari PMB maupun murid lama) dipetakan / dimasukkan ke dalam <code>ROMBEL</code> tersebut.</li>
    <li><strong>Kenaikan Kelas:</strong> Di akhir tahun ajaran, sistem akan membaca data <code>MURID</code> di dalam suatu <code>ROMBEL</code>. Melalui fitur "Kenaikan Kelas", Foreign Key (ID Rombel) pada murid akan diperbarui ke Rombel di Tingkat Kelas yang lebih tinggi untuk Tahun Ajaran berikutnya.</li>
</ol>

<h3>C. Alur Keuangan &amp; Diskon</h3>
<ol>
    <li><strong>Generate Tagihan:</strong> Berdasarkan entitas <code>MURID</code> (dan Program/Tingkat Kelas mereka), sistem akan men-generate record di tabel <code>TAGIHAN_KEUANGAN</code> (seperti Uang Pangkal, SPP bulanan, atau Formulir untuk Calon Murid).</li>
    <li><strong>Pengajuan Diskon:</strong> Jika murid berprestasi atau memiliki kriteria tertentu (anak pegawai, saudara kandung), Admin menginput data ke tabel <code>DISKON</code>. Tabel ini berelasi langsung ke <code>MURID</code>.</li>
    <li><strong>Kalkulasi:</strong> Saat nominal <code>TAGIHAN_KEUANGAN</code> ditampilkan ke orang tua/murid, sistem akan menghitung: (Nominal Dasar - Potongan dari Tabel Diskon). Tagihan ini dilengkapi dengan Virtual Account (VA) untuk tracking otomatis status lunas atau belum (piutang).</li>
</ol>
',
                'is_published' => true,
                'order' => 3
            ]
        );
    }
}

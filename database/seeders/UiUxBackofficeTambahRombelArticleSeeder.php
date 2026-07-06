<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeTambahRombelArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Tambah Rombongan Belajar (Rombel)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Tambah Rombongan Belajar</strong> (sering disingkat <i>Rombel</i>) yang terdapat di dalam modul "Sekolah" dirancang untuk memfasilitasi admin atau bagian akademik dalam merakit sebuah kelas baru. Proses perakitan ini mencakup penentuan identitas kelas (tahun, jenjang, wali kelas) hingga memasukkan daftar siswa ke dalam kelas tersebut.</p>

<h3>Komponen Formulir Pembentukan Kelas</h3>
<p>Halaman ini mengusung pendekatan satu pintu (<i>single-page workflow</i>). Formulir dibagi ke dalam dua area fokus utama: <strong>Data Master Kelas</strong> di bagian atas dan <strong>Daftar Anggota Kelas</strong> di bagian bawah.</p>

<h4>1. Bagian Data Master Kelas (Grid 2 Kolom)</h4>
<p>Bagian atas layar didedikasikan untuk mendefinisikan "identitas" dari rombongan belajar itu sendiri. Kolom-kolom isian disusun dalam <i>layout</i> 2-kolom agar menghemat ruang vertikal namun tetap rapi dibaca:</p>
<ul>
    <li><strong>Afiliasi Akademik:</strong> Terdapat <i>dropdown</i> untuk memilih <code>Tahun Ajaran</code>, <code>Tingkat Kelas</code>, dan <code>Program</code> (contoh: Reguler atau Bilingual).</li>
    <li><strong>Identitas Spesifik:</strong> Terdapat isian <code>Nama Rombel</code> berupa teks bebas (misal: "A", "B", atau "Abu Bakar"). </li>
    <li><strong>Alokasi Fisik:</strong> Disediakan <i>dropdown</i> <code>Nama Ruangan</code> untuk menentukan di ruang fisik manakah kelas ini beroperasi nantinya.</li>
    <li><strong>Penanggung Jawab:</strong> Pengaturan <code>Nama Wali Kelas</code>. Mengingat jumlah guru/pegawai bisa mencapai puluhan hingga ratusan, <i>field</i> ini didesain sebagai <i>Searchable Dropdown</i> (terdapat indikator "<i>Ketik Untuk Mencari Data..</i>"), sehingga admin bisa mengetikkan nama untuk memfilter daftar guru dengan cepat.</li>
</ul>

<h4>2. Bagian Anggota Kelas (Tabel Siswa)</h4>
<p>Tepat di bawah formulir spesifikasi kelas, terdapat area tabel interaktif untuk langsung merajut atau mendaftarkan siswa-siswa ke dalam rombel yang sedang dibuat ini.</p>
<ul>
    <li><strong>Tombol "+ Tambah Siswa":</strong> Sebuah tombol aksi utama (<i>Primary Button</i> berwarna biru solid) diletakkan secara mencolok di sudut kanan atas area tabel. Tombol ini diposisikan untuk memicu aksi pemilihan siswa (biasanya akan membuka panel <i>modal / pop-up</i> yang memuat daftar murid yang belum mendapatkan kelas).</li>
    <li><strong>Tabel Anggota Sementara:</strong> Tabel responsif yang siap menampilkan rangkuman anggota rombel. Kolom yang disediakan meliputi: <code>No</code>, <code>Nama Siswa</code>, <code>NIS</code>, <code>Nomor Absen</code>, dan <code>Aksi</code>. Kolom <i>Aksi</i> di sini umumnya difungsikan untuk membatalkan/mencabut siswa dari daftar jika terjadi keliru pilih.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Desain antarmuka pada halaman "Tambah Rombel" berhasil menerapkan konsep <strong>Contextual Workflow</strong> yang cerdik. Daripada memecah proses menjadi dua alur kerja terpisah (misal: "Buat Kelasnya Dulu", lalu "Masuk ke Detail Kelas untuk Tambah Siswa"), sistem menyatukannya ke dalam satu layar yang berkesinambungan. Keputusan UI/UX ini terbukti secara drastis mampu memangkas jumlah perpindahan halaman (<i>page loads</i>) dan mempercepat kinerja bagian akademik dalam menghadapi rutinitas pembuatan kelas di awal tahun ajaran baru.</p>
',
                'is_published' => true,
                'order' => 7
            ]
        );
    }
}

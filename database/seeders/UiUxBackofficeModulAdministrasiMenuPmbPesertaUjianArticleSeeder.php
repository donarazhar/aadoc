<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuPmbPesertaUjianArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu PMB > Peserta Ujian';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Peserta Ujian</strong> yang terletak dalam direktori "Administrasi &gt; PMB" menampilkan sebuah tabel data (<i>data grid</i>) berdesain ringkas yang berfungsi sebagai pusat komando (<i>command center</i>) pemantauan seleksi siswa. Antarmuka "Daftar Peserta Ujian" ini memprioritaskan fungsi pencarian cepat dan rekapitulasi data lintas modul.</p>

<h3>Struktur Antarmuka (UI) Daftar Peserta Ujian</h3>
<p>Halaman ini menanggalkan komponen <i>form input</i> yang memakan tempat, dan sepenuhnya mendedikasikan ruang layar (<i>screen real estate</i>) untuk penyajian data tabel yang komprehensif.</p>
<ul>
    <li><strong>Kolom Pencarian Global (Search Bar):</strong> Bertengger strategis di sudut kiri atas tabel, fitur pencarian ini adalah nyawa dari UX halaman ini. Admin dapat langsung memfilter ratusan data secara <i>real-time</i> berdasarkan nama atau nomor registrasi tanpa perlu *loading* ulang halaman (*AJAX-based search*).</li>
    <li><strong>Arsitektur Kolom Tabel:</strong> Tabel ini adalah mahakarya kompilasi data (*data aggregation*). Ia tidak hanya merangkum identitas dasar (<code>No Registrasi</code>, <code>Nama Lengkap</code>, <code>Jenis Kelamin</code>), melainkan langsung menyandingkannya dengan konteks pendaftaran (<code>Gelombang</code>, <code>Asal Sekolah</code>, <code>Jenjang Kelas &amp; Program</code>, <code>Tahun Ajaran</code>). Desain ini mencegah admin dari birokrasi *klik* yang berlebihan (tidak perlu membuka profil siswa satu per satu hanya untuk mengecek jenjang kelasnya).</li>
    <li><strong>Kolom Evaluasi (Nilai &amp; Aksi):</strong> Kolom <code>Nilai</code> bertindak sebagai *focal point* (titik fokus) yang mengubah tabel ini dari sekadar daftar kontak menjadi papan skor (*scorecard*). Kolom <code>Aksi</code> di ujung kanan berfungsi sebagai pintu masuk untuk meng-<i>input</i> atau memodifikasi nilai tersebut.</li>
    <li><strong>Penanganan Empty State yang Elegan:</strong> Ketika <i>database</i> masih kosong (belum ada peserta yang dijadwalkan), sistem tidak menyuguhkan kotak putih kosong atau pesan <i>error</i> yang mengintimidasi. Sebaliknya, hadir ilustrasi dokumen yang estetik (<i>Empty State</i>) dengan keterangan "Data tidak ada", memberi sinyal positif bahwa sistem berjalan normal, hanya saja datanya belum tersedia.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Dari kacamata arsitektur sistem dan bisnis proses, menu <strong>Peserta Ujian</strong> memegang peranan krusial sebagai <strong>"Jembatan Transisi"</strong> (<i>Transition Bridge</i>) di paruh kedua siklus Penerimaan Murid Baru (PMB).</p>
<ul>
    <li><strong>Titik Hulu (Data Pull):</strong> Secara otomatis, halaman ini menarik dan menyaring data dari menu <strong>Data Calon Murid</strong> (memilih siswa yang berkas administrasinya sudah dinyatakan valid) dan menyilangkannya dengan referensi dari menu <strong>Jadwal Ujian</strong> serta <strong>Gelombang Pendaftaran</strong>. Dengan kata lain, nama-nama yang muncul di tabel ini adalah mereka yang telah sah memegang tiket (<i>eligible</i>) untuk mengikuti ujian seleksi.</li>
    <li><strong>Titik Hilir (Data Feed):</strong> Tabel ini memproduksi luaran (*output*) berupa skor ujian. Data yang diolah di sini—terutama konklusi dari kolom <strong>Nilai</strong>—selanjutnya akan didorong (<i>pushed</i>) ke menu akhir, yakni <strong>Kelulusan Peserta</strong>. Angka yang tertera di halaman Peserta Ujian inilah yang akan menjadi fondasi argumen logis (<i>logical parameter</i>) bagi pimpinan sekolah untuk mengeksekusi status akhir: "Diterima", "Cadangan", atau "Ditolak".</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Desain "Daftar Peserta Ujian" mendobrak stigma bahwa tabel administrasi selalu terasa kaku dan *overwhelming*. Dengan merangkum 9 kolom analitik terpenting dan membungkusnya dengan fitur pencarian responsif, desainer sukses menciptakan <i>dashboard</i> evaluasi yang padat informasi (*information-dense*) namun amat melegakan untuk dibaca. Bertindak sebagai persimpangan utama dalam <i>workflow</i> PMB, antarmuka ini menjembatani jurang antara fase pendaftaran administrasi (<i>data entry</i>) menuju fase krusial pengambilan keputusan akhir (<i>decision making</i>).</p>
',
                'is_published' => true,
                'order' => 19
            ]
        );
    }
}

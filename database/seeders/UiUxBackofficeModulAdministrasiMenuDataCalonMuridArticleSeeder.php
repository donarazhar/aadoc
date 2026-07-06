<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuDataCalonMuridArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Data Calon Murid';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Data Calon Murid</strong> yang bersandar di bawah modul utama "Administrasi" berperan sebagai repositori sentral (<i>central repository</i>) bagi seluruh rekam jejak kandidat pendaftar. Halaman ini melampaui batasan sebuah tabel data statis, bertransformasi menjadi <i>pipeline dashboard</i> (dasbor alur kerja) yang memperlihatkan secara <i>real-time</i> di tahap mana progres pendaftaran seorang anak sedang berada.</p>

<h3>Struktur Antarmuka (UI) Data Calon Murid</h3>
<p>Berfungsi sebagai <i>master data</i> sementara selama musim PMB, antarmuka halaman ini didesain agar sangat padat informasi (<i>information-rich</i>) namun tetap ramah dipindai oleh mata (<i>highly scannable</i>).</p>
<ul>
    <li><strong>Aksi Tingkat Tinggi (Top-Level Actions):</strong> Bersemayam di sudut kanan atas, terdapat tombol <code>Filter</code> (hijau) untuk penyaringan lanjutan (berdasarkan rentang waktu, gelombang, atau status), berdampingan dengan tombol <code>Export</code> (biru) untuk mengunduh laporan ke format <i>spreadsheet</i>. Isolasi penempatan tombol ini di luar area operasional tabel memastikan fungsi pelaporan (*reporting*) sangat mudah diakses oleh pimpinan manajerial.</li>
    <li><strong>Arsitektur Tabel Holistik:</strong> Kolom tabel membedah perjalanan kandidat dari A sampai Z. Dimulai dari penanda kronologi (<code>Tanggal Daftar</code>), profil dasar (<code>Nama Lengkap</code>, <code>Sekolah Asal</code>), hingga pemetaan *routing* penempatan (<code>Sekolah Tujuan</code>, <code>Program</code>, <code>Gelombang</code>).</li>
    <li><strong>Komunikasi Visual via Badges (Lencana Status):</strong> Ini adalah kekuatan UX paling fundamental di halaman ini. Kolom <code>Status</code> tidak menggunakan deretan teks hitam-putih yang monoton, melainkan disuntikkan lencana berwarna (<i>Color-coded Badges</i>):
        <ul>
            <li><strong>Lencana Kuning</strong> (<span style="color:#ca8a04; background:#fef08a; padding: 2px 8px; border-radius: 12px; font-size: 0.85em;">Waiting List</span>, <span style="color:#ca8a04; background:#fef08a; padding: 2px 8px; border-radius: 12px; font-size: 0.85em;">Menunggu Pembayaran DSP</span>): Secara psikologis mengindikasikan status <i>pending</i>, tertunda, atau butuh <i>follow-up</i> (intervensi admin).</li>
            <li><strong>Lencana Hijau</strong> (<span style="color:#16a34a; background:#bbf7d0; padding: 2px 8px; border-radius: 12px; font-size: 0.85em;">Terdaftar</span>): Memberikan sinyal <i>clearance</i>, bahwa kewajiban administrasi anak tersebut di tahap itu telah tuntas.</li>
        </ul>
        Strategi pewarnaan ini memungkinkan resepsionis atau kasir memprioritaskan siapa yang harus mereka telepon hari ini hanya melalui satu kali <i>scroll</i> cepat.
    </li>
    <li><strong>Aksi Kontekstual (Detail):</strong> Kolom <code>Status</code> paling kanan (di bawah kursor tabel) menyediakan tombol berikon kaca pembesar untuk "membedah" profil pendaftar lebih dalam (verifikasi berkas, riwayat cicilan tagihan, dsb).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Di dalam ekosistem arsitektur sistem sekolah, menu <strong>Data Calon Murid</strong> adalah <strong>"Stasiun Transit Utama"</strong> (<i>The Main Transit Hub</i>).</p>
<ul>
    <li><strong>Hulu Data (Input Source):</strong> Tabel ini bermuara dari dua saluran: tarikan data <i>leads</i> dari menu <strong>Animo</strong> (saat orang tua mengonfirmasi lanjut mendaftar) atau langsung dari portal pendaftaran publik <i>online</i> (<i>self-registration</i>).</li>
    <li><strong>Koneksi Paralel (Cross-Module Integration):</strong> Munculnya status seperti "Menunggu Pembayaran" membuktikan bahwa tabel ini terintegrasi erat dengan modul <strong>Keuangan (Biaya)</strong>. Sementara itu, kandidat yang sudah berstatus hijau ("Terdaftar") akan disuplai secara otomatis ke menu <strong>PMB &gt; Peserta Ujian</strong> untuk mendapatkan jadwal tes seleksi.</li>
    <li><strong>Hilir Data (Final Destination):</strong> Setelah seorang kandidat merampungkan seluruh siklus (Ujian, Kelulusan, Daftar Ulang) dan mengantongi status akhir "Diterima", entitas datanya akan dieksekusi (<i>pushed</i>) secara permanen ke <i>database</i> utama, yakni menu <strong>Sekolah &gt; Data Murid</strong>. Di titik inilah identitas mereka bertransmutasi secara sah dari "Calon" menjadi "Siswa Aktif".</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Desain halaman "Data Calon Murid" sangat brilian dalam menerjemahkan kerumitan birokrasi PMB ke dalam satu kanvas pemantauan visual. Penggunaan <i>color-coded badges</i> (lencana warna) adalah praktik penerapan <i>Cognitive Load Reduction</i> (pengurangan beban kognitif) yang amat menolong pengguna. Secara <i>workflow</i>, halaman ini bertindak sempurna sebagai integrator (*the grand integrator*) yang mempertemukan operasional tim Pendaftaran (Front Office), tim Keuangan (Kasir), dan tim Akademik (Penyeleksi) dalam satu dasbor yang sama.</p>
',
                'is_published' => true,
                'order' => 21
            ]
        );
    }
}

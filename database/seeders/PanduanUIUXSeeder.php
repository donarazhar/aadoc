<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUXSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Pengguna (User Manual)')],
            ['name' => 'Buku Panduan Pengguna (User Manual)']
        );

        $content = <<<HTML
<p>Artikel ini menjabarkan anatomi antarmuka pengguna (UI) dan pengalaman pengguna (UX) dari ekosistem ALAZHARAPPS. Sistem ini dibagi menjadi dua antarmuka utama: <strong>Web Backoffice</strong> (bagi staf/guru) dan <strong>Aplikasi Mobile</strong> (bagi orang tua murid).</p>

<h3>Diagram Arsitektur Navigasi UI</h3>
<pre><code class="language-mermaid">
mindmap
  root((UI/UX ALAZHARAPPS))
    Web Backoffice (NextJS)
      Master Data
        Wilayah & Agama
        Tahun Ajaran
      Akademik
        Kurikulum & Kelas
        Presensi Guru
      PPDB & Keuangan
        Gelombang Daftar
        Tagihan SPP & UP
        Diskon & Cicilan
    Mobile App (Flutter)
      Dashboard Utama
        Widget Adzan
        Kartu Siswa (ID)
        Notifikasi Badges
      Akademik Siswa
        Rapor Digital
        Jadwal & Absensi
      Transaksi
        Riwayat & Pending
        Gateway DOKU (VA/QRIS)
      Multi-Child Switcher
</code></pre>

<h3>1. Anatomi UI/UX Web Backoffice (Admin & Guru)</h3>
<p>Backoffice didesain dengan konsep <em>Sidebar Navigation</em> yang masif. Tata letak (<em>Layout</em>) dipisahkan secara modular untuk mencegah pengguna kebingungan (<em>Cognitive Overload</em>).</p>

<h4>A. Modul Master Data (Tulang Punggung Sistem)</h4>
<ul>
    <li><strong>Relasi Kolom (UX):</strong> Data yang di-input di dalam form Master (seperti daftar Agama, Provinsi, atau Pekerjaan) akan secara otomatis terhubung (<em>relational bind</em>) menjadi menu <em>Dropdown</em> di formulir pendaftaran pada Aplikasi Mobile. Artinya, jika Admin menambahkan "Wiraswasta" di Master Pekerjaan, keesokan harinya opsi tersebut muncul di layar HP orang tua yang sedang mengisi form PMB.</li>
    <li><strong>Tahun Ajaran & Status:</strong> Terdapat tombol (<em>Toggle</em>) Aktif/Non-Aktif. Sistem UX mencegah adanya dua Tahun Ajaran yang berstatus aktif secara bersamaan untuk mencegah bentrok data nilai siswa.</li>
</ul>

<h4>B. Modul Akademik & Pegawai</h4>
<ul>
    <li><strong>Penugasan Guru (Assignment):</strong> Tampilan tabel matriks (Grid). Kepala Sekolah mengaitkan Guru dengan Mata Pelajaran dan Kelas. </li>
    <li><strong>Dampak Relasi UX:</strong> Ketika relasi Kelas dan Wali Kelas disimpan, otomatis Guru tersebut mendapatkan akses khusus di aplikasinya untuk memvalidasi Rapor kelas tersebut, tanpa perlu pengaturan otorisasi tambahan.</li>
</ul>

<h4>C. Modul PPDB, Animo & Keuangan</h4>
<ul>
    <li><strong>Alur Konversi Siswa (Funneling):</strong> Berawal dari menu <code>Animo</code> (peminat) &rarr; <code>Calon</code> (Membayar formulir) &rarr; <code>Murid Aktif</code>. Di setiap fase, UI menggunakan Indikator Warna (Merah=Belum Lunas, Hijau=Lunas).</li>
    <li><strong>Manajemen Diskon (Approval UI):</strong> Pada tabel pengajuan diskon, terdapat kolom Aksi (<em>Action</em>) berlogo "Ceklis" (Setuju) atau "Silang" (Tolak). Jika ditekan Setuju, sistem langsung merefleksikannya ke perhitungan <em>Grand Total</em> tagihan siswa di hari yang sama.</li>
</ul>

<h3>2. Anatomi UI/UX Mobile App (Orang Tua Murid)</h3>
<p>Aplikasi genggam didesain dengan filosofi <em>Frictionless</em> (Minim Hambatan). Tidak banyak menu bertingkat yang membingungkan; segala fitur harian dapat dijangkau dalam maksimal dua ketukan (<em>2 Taps</em>).</p>

<h4>A. Dashboard (Beranda Utama) & Engagement UX</h4>
<ul>
    <li><strong>Widget Adzan & Cuaca:</strong> Di area paling atas (<em>Header</em>), aplikasi menanamkan jadwal sholat harian (melakukan <em>fetch API</em> berdasarkan lokasi terkini *Nearest City*). Hal ini secara UX memaksa aplikasi agar "sering dibuka" oleh orang tua setiap hari, bukan hanya saat jatuh tempo bayar SPP.</li>
    <li><strong>Student Card (Kartu Pelajar Digital):</strong> Menggantikan fungsi ID Card plastik. Barcode yang ada di layar bisa di-*tap* ke pemindai (*Scanner*) di gerbang sekolah.</li>
    <li><strong>Notification Badges (Titik Merah):</strong> Terletak pada ikon Lonceng atau ikon Tagihan. Membantu memberikan sinyal visual bawah sadar jika ada tunggakan atau rapor baru yang belum dibaca.</li>
</ul>

<h4>B. Multi-Child Switcher (Relasi Keluarga)</h4>
<ul>
    <li><strong>Tantangan UX:</strong> Bagaimana jika satu orang tua punya 3 anak (TK, SD, SMP) di Al-Azhar?</li>
    <li><strong>Solusi UI:</strong> Terdapat menu <em>Dropdown Switcher</em> (Avatar anak) di pojok atas. Ketika profil diubah dari si Sulung ke si Bungsu, seluruh layar di bawahnya (tagihan, rapor, nilai, jadwal ekskul) secara seketika (*State Management*) akan berganti memuat data si Bungsu tanpa perlu <em>Logout</em>.</li>
</ul>

<h4>C. UI Transaksi (Payment Gateway)</h4>
<ul>
    <li><strong>List Tagihan Berjalan:</strong> Dipisahkan menjadi dua Tab: <em>Unpaid</em> (Belum Dibayar) dan <em>History</em> (Riwayat).</li>
    <li><strong>Flow UX Pembayaran:</strong> Saat tagihan di-klik, muncul opsi bank (Mandiri, BSI, dll) dan QRIS. Setelah menekan salah satu, muncul sebuah <em>Bottom Sheet</em> (Jendela Bawah) yang menampilkan nomor Virtual Account DOKU beserta tombol "Salin (Copy)". Saat pembayaran lunas, layar langsung memunculkan animasi centang hijau (via Webhook) secara otomatis tanpa orang tua perlu me-*refresh* layarnya.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Anatomi UI UX Web Backoffice dan Mobile App')],
            [
                'title' => 'Panduan Anatomi UI/UX (Web Backoffice & Mobile App)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

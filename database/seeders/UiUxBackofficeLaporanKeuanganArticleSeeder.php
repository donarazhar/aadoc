<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeLaporanKeuanganArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Laporan Keuangan
        $title = 'Laporan Keuangan (Keuangan Murid & Transaksi Murid)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Modul <strong>Laporan Keuangan</strong> pada sistem Al Azhar Apps merupakan pusat pelaporan finansial yang sangat vital bagi pihak manajemen sekolah dan yayasan. Modul ini dipecah menjadi dua sub-menu utama yang saling melengkapi, yakni <i>Keuangan Murid</i> dan <i>Transaksi Murid (Kode Biaya)</i>. Keduanya dirancang khusus untuk memberikan transparansi dan kemudahan <i>tracking</i> arus kas secara detail.</p>

<h3>1. Sub-menu: Keuangan Murid</h3>
<p>Halaman ini berfokus pada pencatatan <i>ledger</i> atau buku besar status finansial secara spesifik per individu murid. Antarmuka ini dirancang agar admin keuangan dapat dengan cepat menelusuri riwayat tagihan dan identitas pembayaran masing-masing siswa.</p>

<h4>Komponen Pencarian &amp; Filter Lanjutan</h4>
<ul>
    <li><strong>Filter Multi-Dimensi:</strong> Berada di dalam panel putih (card) teratas, admin dapat memfilter data dengan presisi menggunakan 5 parameter sekaligus: <code>Sekolah</code>, <code>Tahun Ajaran</code>, <code>Kelas</code>, <code>Program</code>, dan <code>Tipe</code> (misal: Penerimaan).</li>
    <li><strong>Tombol Aksi (Terapkan &amp; Reset):</strong> Memberikan kendali kapan kueri pencarian dieksekusi ke <i>database</i>, menghindari beban <i>loading</i> berlebih saat admin masih mengatur beberapa filter secara bersamaan.</li>
    <li><strong>Export Data:</strong> Terdapat tombol <code>Export</code> (biru) di pojok kanan atas yang sangat krusial untuk kebutuhan pelaporan eksternal atau audit, memungkinkan data diunduh langsung ke format <i>spreadsheet</i> (Excel/CSV).</li>
</ul>

<h4>Struktur Tabel Data</h4>
<p>Tabel disajikan mendatar dengan menonjolkan kolom-kolom identifikasi finansial seperti: <code>NIS/No Registrasi</code>, <code>Nama Murid</code>, <code>No Reference</code>, dan <code>VA (Virtual Account)</code>. Ketersediaan nomor <i>Virtual Account</i> secara langsung di tabel mempermudah tim <i>finance</i> saat harus melakukan rekonsiliasi atau pencocokan silang secara manual dengan <i>dashboard bank</i>.</p>

<h3>2. Sub-menu: Transaksi Murid (Kode Biaya)</h3>
<p>Berbeda dengan halaman sebelumnya yang berbasis profil individu murid, halaman <strong>Transaksi Murid</strong> sepenuhnya berorientasi pada <i>cash-flow</i> (arus kas) masuk berdasarkan rentang waktu operasional dan pemisahan rekening bank.</p>

<h4>Komponen Filter Berbasis Waktu &amp; Rekening</h4>
<ul>
    <li><strong>Filter Rekening &amp; Tanggal:</strong> Halaman ini menggunakan komponen <i>dropdown</i> <code>Pilih Rekening</code> yang disandingkan dengan sepasang <i>Date Range Picker</i> (Pilih tanggal awal dan akhir). Desain filter ini adalah standar industri yang sangat ideal untuk rutinitas tutup buku harian (<i>daily closing</i>) atau bulanan (<i>month-end closing</i>).</li>
</ul>

<h4>Struktur Tabel Data Transaksional</h4>
<p>Tabel membeberkan baris transaksi historis dengan penekanan pada detail sumber dan peruntukan dana. Kolom seperti <code>Sekolah</code>, <code>Asal Sekolah</code>, dan <code>Bulan</code> (misalnya rincian: "Uang Sekolah Jul 2026") memungkinkan akuntan untuk membedah secara akurat komponen pendapatan (kode biaya) apa saja yang telah berhasil dicairkan pada periode tertentu.</p>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Pendekatan desain antarmuka (UI/UX) pada modul Laporan Keuangan ini sangat mengedepankan prinsip <strong>Data Density &amp; Accessibility</strong> (Kepadatan &amp; Keteraksesan Data). Penempatan formulir filter yang membentang horizontal di atas (<i>top filter bar</i>) bertujuan untuk menyisakan ruang vertikal layar semaksimal mungkin bagi tabel data, sehingga mengurangi kelelahan akibat <i>scrolling</i> panjang. Hadirnya fitur pencarian cepat global dan fasilitas <i>Export</i> menjadikannya sebuah *tool* pelaporan keuangan yang tangguh dan memanjakan penggunanya.</p>
',
                'is_published' => true,
                'order' => 4
            ]
        );
    }
}

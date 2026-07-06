<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuPmbArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu PMB';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>PMB (Penerimaan Murid Baru)</strong> yang terletak di bawah payung modul "Sekolah" dirancang secara khusus untuk bertindak sebagai <i>dashboard</i> rekapitulasi (<i>executive summary</i>). Berbeda dengan menu Transaksi PMB yang dipenuhi deretan data mentah para calon siswa, antarmuka halaman ini difokuskan pada penyajian analitik tingkat tinggi (<i>high-level metrics</i>) guna memantau performa rekrutmen siswa dari satu periode ke periode lainnya.</p>

<h3>Struktur dan Tata Letak (Layout) Halaman</h3>
<p>Keseluruhan antarmuka didesain dengan mengedepankan prinsip <i>data readability</i> (keterbacaan data yang cepat). Tata letaknya meliputi komponen berikut:</p>

<h4>1. Panel Filter Data (Penyaringan Rentang Waktu)</h4>
<p>Sistem menyediakan mekanisme filter interaktif yang bisa dipanggil lewat tombol hijau "Filter" di sudut kanan atas. Ketika diekspansi, panel putih ini memuat:</p>
<ul>
    <li><strong>Dropdown Rentang Waktu:</strong> Mengingat performa PMB diukur per siklus akademik, pengguna diwajibkan melakukan penyaringan (*filtering*) berbasis <code>Tahun Ajaran</code>. Fitur ini sangat krusial bagi manajemen untuk melihat grafik penerimaan pada satu angkatan tertentu.</li>
    <li><strong>Tombol Reset &amp; Terapkan:</strong> Penyediaan tombol <i>Reset</i> (berwarna merah) tepat di samping tombol eksekusi <i>Terapkan</i> (berwarna biru) merupakan penerapan kaidah UX yang solid. Ini memberikan keleluasaan bagi admin untuk membatalkan skenario pencarian (*clear filters*) dengan cukup satu ketukan.</li>
</ul>

<h4>2. Tabel Rekapitulasi Performa (Data Grid)</h4>
<p>Bintang utama dari halaman ini adalah struktur tabel data bergaris bersih (<i>clean layout</i>) yang merangkum rapor pencapaian tim PMB:</p>
<ul>
    <li><strong>Kolom Metrik Strategis:</strong> Tabel ini secara cerdas menyingkirkan kerumitan nama-nama siswa individual, lalu menggantinya dengan perbandingan langsung antara <code>Target</code> (kuota bangku sekolah), <code>Pendaftar</code> (jumlah animo yang masuk), dan <code>Perolehan</code> (realisasi akhir siswa yang sah mendaftar ulang). Deretan kolom ini adalah amunisi sempurna bagi kepala sekolah untuk menghitung <i>conversion rate</i> (tingkat keberhasilan) pendaftaran.</li>
    <li><strong>Kolom Sinkronisasi Waktu:</strong> Di ujung kanan tabel, sistem membubuhkan kolom <code>Update</code> (*timestamp*). Kehadiran kolom kecil ini membawa dampak psikologis yang besar: memberikan kepastian mutlak (*trust*) kepada level pimpinan bahwa angka-angka yang mereka lihat adalah data *real-time* detik itu juga.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman "PMB Sekolah" mengadopsi pendekatan desain <strong>Minimalist Analytics Dashboard</strong> dengan sangat gemilang. Dengan membuang detail operasional (*noise*) dan langsung menyuguhkan metrik kuantitatif (Target vs Perolehan) yang dibalut tabel responsif, antarmuka ini amat memanjakan *Top-level management* (Kepala Sekolah/Yayasan) dalam menyerap informasi secara sekilas (*glanceable*) untuk perumusan strategi promosi di masa mendatang.</p>
',
                'is_published' => true,
                'order' => 12
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanDashboardBackofficeSeeder extends Seeder
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
<p>Halaman <em>Dashboard</em> (Beranda) Backoffice ALAZHARAPPS bukan sekadar halaman penyambut. Ia adalah pusat komando (<em>Command Center</em>) berbasis data analitik yang ditopang oleh dua mesin utama: <code>report-service</code> dan <code>school-service-new</code>. Artikel ini membedah 5 sub-menu Dashboard yang disesuaikan dengan kebutuhan setiap departemen.</p>

<h3>Diagram Modul Dashboard Analytics</h3>
<pre><code class="language-mermaid">
mindmap
  root((Dashboard Backoffice))
    Pusat Yayasan (Admin Pusat)
      Demografi Persebaran Sekolah
      Total Target Siswa
    Keuangan (Finance)
      Grafik Penerimaan Harian
      Rasio Lunas vs Tunggakan
      Kesehatan Cashflow
    Marketing (PMB & Animo)
      Rasio Konversi Calon ke Murid
      Target Pencapaian PMB
    Murid (Kesiswaan)
      Tren Demografi Siswa
      Persebaran Akademik
    Akademik (LMS)
      Prestasi & Pelanggaran
      Kualitas KBM
</code></pre>

<h3>1. Dashboard Admin Pusat (Yayasan & Sekolah)</h3>
<p><strong>Fokus:</strong> Gambaran Makro (<em>Helicopter View</em>) tentang kondisi Yayasan.</p>
<ul>
    <li><strong>Persebaran Wilayah (Demografi):</strong> Menampilkan grafik (<em>Progress Chart</em> & <em>Bar Chart</em>) jumlah sekolah berdasarkan provinsi dan tingkat pendidikan (TK, SD, SMP, SMA). Data ditarik dari fungsi <code>SchoolCountByProvince</code> dan <code>SchoolCountByEducationLevel</code>.</li>
    <li><strong>Target Siswa Global:</strong> Menampilkan seberapa dekat yayasan dengan target kapasitas total siswa (<em>Target Students</em>) di tahun ajaran tersebut.</li>
    <li><strong>Aksesibilitas:</strong> Hanya dapat dilihat oleh Superadmin (Level 1) dan Pimpinan Yayasan.</li>
</ul>

<h3>2. Dashboard Keuangan (Finance)</h3>
<p><strong>Fokus:</strong> Kesehatan Arus Kas (<em>Cashflow</em>) dan mitigasi gagal bayar (Tunggakan).</p>
<ul>
    <li><strong>Grafik Penerimaan Harian (ChartPenerimaanHarian):</strong> Menampilkan kurva (<em>Line Chart</em>) pendapatan yang masuk setiap harinya. Membantu Bendahara melihat tren tanggal berapa orang tua paling sering membayar SPP.</li>
    <li><strong>Rasio Penerimaan vs Tunggakan (Acceptance vs Arrear):</strong> Komparasi ekstrem (<em>Pie Chart</em> / <em>Doughnut</em>) antara tagihan yang sudah menjadi uang (<em>Revenue</em>) versus tagihan yang macet (<em>Arrears</em>).</li>
    <li><strong>Ekspor Laporan (Excel/CSV):</strong> Terdapat tombol ajaib untuk mengunduh laporan keuangan lintas sekolah berdasarkan Kode Biaya (<em>Cost Code</em>) seperti "Laporan Khusus Uang Gedung".</li>
</ul>

<h3>3. Dashboard Marketing (PPDB & Animo)</h3>
<p><strong>Fokus:</strong> Mengevaluasi strategi pemasaran dan konversi siswa baru.</p>
<ul>
    <li><strong>Corong Penjualan (PMB Summary & Ratio):</strong> Menganalisa berapa banyak orang tua yang sekadar mendaftar (Animo), membeli formulir (Calon), hingga akhirnya lunas Uang Pangkal (Murid). Rasio (<em>PMB Ratio</em>) yang kecil berarti ada hambatan (<em>bottleneck</em>) dalam pelayanan atau biaya.</li>
    <li><strong>Target Achievement:</strong> Menampilkan persentase pencapaian kuota bangku yang tersedia per gelombang pendaftaran.</li>
</ul>

<h3>4. Dashboard Murid</h3>
<p><strong>Fokus:</strong> Retensi dan Demografi Siswa Aktif.</p>
<ul>
    <li><strong>Grafik Tren Tahunan (StudentCountByAcademicYear):</strong> Menampilkan apakah grafik jumlah siswa mengalami kenaikan atau penurunan selama 5 tahun terakhir.</li>
    <li><strong>Dashboard Interaktif:</strong> Jika Kepala Sekolah mengklik salah satu batang grafik (misalnya "Siswa SD"), sistem akan menampilkan rincian usia dan gender siswa tersebut tanpa berpindah halaman.</li>
</ul>

<h3>5. Dashboard Akademik & LMS</h3>
<p><strong>Fokus:</strong> Kualitas Pendidikan dan Karakter Siswa.</p>
<ul>
    <li><strong>Papan Prestasi (Award / Magazine):</strong> Menampilkan statistik jumlah prestasi kejuaraan yang dimenangkan oleh siswa-siswa sekolah tersebut dalam tahun berjalan.</li>
    <li><strong>Metrik Kegiatan Belajar:</strong> (Relasi dengan <em>Learning Agenda</em>) Memantau seberapa banyak kelas yang berjalan sesuai dengan rencana RPP harian.</li>
</ul>

<hr>
<blockquote>
<p><strong>Catatan Teknis (UX Performance):</strong> Karena Dashboard ini melakukan kalkulasi matematika jutaan data baris keuangan dan siswa dari seluruh sekolah, <code>report-service</code> menggunakan teknik <strong>Caching (Redis)</strong>. Hal ini memastikan halaman Dashboard akan langsung terbuka dalam hitungan milidetik tanpa membebani (<em>query lock</em>) database utama.</p>
</blockquote>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Analisa Mendalam Menu Dashboard Backoffice')],
            [
                'title' => 'Analisa Mendalam Menu Dashboard Backoffice',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

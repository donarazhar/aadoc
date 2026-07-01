<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UpgradingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori Prologue ada
        $category = Category::firstOrCreate(
            ['slug' => 'prologue'],
            ['name' => 'Prologue', 'description' => 'Pendahuluan dan pengenalan aplikasi', 'order' => 1]
        );

        // Buat artikel Upgrading
        $title = 'Roadmap Upgrading Al Azhar Apps: Resolusi Teknologi & Ekosistem Terpadu';
        
        $content = '
<p>Berdasarkan cetak biru "Tabel Upgrading Al Azhar Apps" yang diterbitkan pada tanggal 12 Mei 2026, Yayasan Pesantren Islam Al-Azhar (YPIA) secara resmi melakukan lompatan kuantum di sisi teknologi dan layanan. Pembaruan ini bukan sekadar penambahan fitur, melainkan revolusi arsitektur dan operasional demi menyajikan aplikasi yang super cepat, aman, dan dapat dikontrol secara mandiri.</p>

<p>Berikut adalah tafsir komprehensif dari poin-poin utama pembaruan (<em>upgrading</em>) yang diimplementasikan:</p>

<h2>1. Lompatan Pondasi Teknologi: Dari Monolitik ke Microservices</h2>
<p>Pembaruan terbesar terjadi pada jantung aplikasi, di mana YPIA secara total memisahkan antarmuka (<em>Frontend</em>) dan logika bisnis (<em>Backend</em>):</p>
<ul>
    <li><strong>Bahasa Pemrograman Modern:</strong> Meninggalkan arsitektur <em>fullstack</em> tradisional (seperti Laravel), kini <em>Frontend</em> dibangun dengan <strong>Next.js</strong> (memastikan <em>render</em> halaman yang sangat cepat dan ramah SEO), sedangkan <em>Backend</em> ditenagai oleh <strong>Go-Lang</strong>. Go-Lang dipilih karena performa <em>concurrency</em>-nya yang luar biasa tinggi dan sangat efisien dalam penggunaan sumber daya server.</li>
    <li><strong>Auto-Healing & High Availability:</strong> Sistem tidak lagi bergantung pada perbaikan manual saat *down*. Mekanisme <em>Auto-healing</em> akan secara otomatis memindahkan *traffic* dari komponen yang gagal ke komponen cadangan yang sehat, memastikan *downtime* nyaris nol.</li>
    <li><strong>Pemisahan Jalur Read/Write:</strong> Operasi membaca (melihat dashboard/rapor) dan operasi menulis (menyimpan data pembayaran) kini dilayani oleh *database* yang berbeda secara independen. Pendekatan ini memecahkan masalah *bottleneck* saat lalu lintas padat.</li>
</ul>

<h2>2. Kedaulatan Data & Jaringan Server (Cloud Multi-Region)</h2>
<p>Dalam hal pengelolaan *server*, YPIA mengambil langkah tegas untuk melindungi kedaulatan data umat:</p>
<ul>
    <li><strong>Multi-Region 100% Indonesia:</strong> Seluruh pusat data ditempatkan di berbagai wilayah dalam yurisdiksi Indonesia. Selain mematuhi regulasi lokal, hal ini menekan nilai <em>latency</em> hingga ke titik terendah.</li>
    <li><strong>Zero Network Cost:</strong> Penggunaan *cloud* dikonfigurasi sedemikian rupa agar tidak membebankan biaya *inbound/outbound network* tambahan saat *microservices* saling bertukar data atau melakukan proses <em>backup & recovery</em> masif.</li>
</ul>

<h2>3. Fitur Mutakhir, Keamanan, & Sentuhan Religius</h2>
<p>Aplikasi ini dirancang bukan hanya untuk menjadi alat administratif, melainkan pendamping harian yang aman bagi ekosistem keluarga Al-Azhar:</p>
<ul>
    <li><strong>Pengamanan Biometrik:</strong> Otentikasi ganda (2FA) diperkuat dengan perlindungan <em>Face Recognition</em> (Pengenalan Wajah) dan Sidik Jari (<em>Fingerprint</em>) ditambah enkripsi data di setiap API.</li>
    <li><strong>Integrasi Layanan Islami:</strong> Aplikasi menyediakan jadwal sholat otomatis dan notifikasi Adzan yang cerdas menyesuaikan secara dinamis dengan lokasi GPS pengguna saat bepergian.</li>
    <li><strong>UI/UX Tematik & Pemantauan Anak:</strong> Tampilan aplikasi (UI/UX) kini bersifat dinamis dan akan otomatis berubah merespons momen keagamaan atau nasional (misal: nuansa Idul Fitri). Selain itu, Orang Tua Murid (OTM) kini bisa memantau kehadiran anak, jadwal, serta nilai rapor secara *real-time* dari genggaman.</li>
</ul>

<h2>4. Manajemen Data: Single Source of Truth & Integrasi Pembayaran</h2>
<p>YPIA menghilangkan kultur data yang terkotak-kotak (<em>Silo</em>) antara divisi keuangan dan sekolah:</p>
<ul>
    <li><strong>Integritas Data Terpadu:</strong> Perubahan status di satu sistem (misal: pembayaran spp) akan seketika (<em>real-time</em>) ter-<em>update</em> di sistem absensi dan akademik karena seluruh <em>microservice</em> mengakses repositori data terpadu.</li>
    <li><strong>Payment Aggregator:</strong> Alih-alih membangun koneksi rumit satu-per-satu ke bank (<em>host-to-host</em>), aplikasi menggunakan kanal Agregator Pembayaran. Ini membuat opsi metode bayar (Virtual Account, QRIS, Kartu Kredit) menjadi tak terbatas dan biaya pemeliharaannya sangat rendah.</li>
    <li><strong>Analytics Dashboard:</strong> Laporan operasional tak lagi dibuat manual. Terdapat dasbor <em>Descriptive Analytic</em> PDF/Excel yang dapat dikembangkan menuju <em>Predictive Analytics</em> untuk memprediksi pola pembayaran atau tren keuangan di masa mendatang.</li>
</ul>

<h2>5. Performa Super Maksimal & Business Continuity</h2>
<p>Hasil uji beban (<em>Load Test</em>) yang dicantumkan dalam dokumen memberikan fakta angka yang impresif atas infrastruktur baru ini:</p>
<ul>
    <li><strong>Performa Fantastis:</strong> Mampu menangani hingga <strong>3.700 pengguna per detik</strong> secara bersamaan. Kecepatan respon (<em>Latency Response</em>) tercatat hanya <strong>0,092 detik</strong> (dibawah 0,1 detik!), dengan tingkat kegagalan (*error rate*) di bawah 1%.</li>
    <li><strong>Monitoring Terpusat:</strong> Seluruh ekosistem diawasi melalui <em>Control Tower</em> berbasis <strong>SigNoz dan Grafana</strong>, lengkap dengan peringatan dini langsung ke Telegram tim IT jika ada anomali.</li>
</ul>

<blockquote>
    <strong>Ownership Source Code 100%:</strong> Yang paling fundamental dari transformasi ini adalah kepastian kelangsungan bisnis (<em>Business Continuity</em>). Baik <em>Database</em> maupun <em>Source Code</em> aplikasi sepenuhnya (100%) menjadi hak milik YPIA, memastikan kebebasan untuk pengembangan mandiri yang berkesinambungan di masa depan tanpa keterikatan mutlak pada pihak ketiga.
</blockquote>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 4
            ]
        );
    }
}

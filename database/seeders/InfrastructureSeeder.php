<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class InfrastructureSeeder extends Seeder
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

        // Buat artikel Infrastruktur
        $title = 'Topologi Infrastruktur Cloud-Native: Skalabilitas, Keamanan, & High Availability';
        
        $content = '
<p>Di balik antarmuka aplikasi yang cepat dan responsif, Al-Azhar Apps ditopang oleh arsitektur infrastruktur <em>Cloud-Native</em> yang sangat tangguh. Diagram topologi di atas menjabarkan bagaimana sistem dirancang untuk mencapai tingkat ketersediaan tinggi (<em>High Availability</em>), keamanan berlapis, dan siklus pengembangan yang otomatis. Berikut adalah bedah mendalam dari setiap lapisan arsitektur tersebut:</p>

<h2>1. Traffic Gateway & Proxy Layer (Lapisan Jaringan Publik)</h2>
<p>Setiap permintaan (<em>request</em>) yang datang dari <strong>Internet</strong> tidak langsung menyentuh <em>server</em> aplikasi. Lalu lintas ini diatur dan disaring terlebih dahulu oleh node <strong>STG-PROXY</strong> dan <strong>PROXY1/UTILITY</strong>. Lapisan ini bertindak sebagai pintu gerbang utama yang melakukan <em>load balancing</em>, terminasi SSL, serta perlindungan awal terhadap serangan siber sebelum meneruskan rute trafik ke klaster aplikasi di belakangnya.</p>

<h2>2. Kubernetes Orchestration Layer (Lapisan Orkestrasi)</h2>
<p>Jantung dari ekosistem Al-Azhar Apps adalah teknologi kontainerisasi yang diorkestrasi oleh <strong>Kubernetes</strong>. Diagram menunjukkan adanya infrastruktur <em>cluster</em> yang sangat matang:</p>
<ul>
    <li><strong>High Availability (HA) Cluster:</strong> Klaster utama (di sisi kanan) menggunakan arsitektur <em>Multi-Master</em> (<strong>STG-MASTER 1, 2, 3</strong>) beserta jajaran <em>Worker Node</em> (<strong>STG-WORKER 1, 2, 3</strong>). Jika salah satu <em>server master</em> mengalami kegagalan <em>(downtime)</em>, sistem akan tetap berjalan tanpa henti karena <em>master</em> lainnya akan mengambil alih kendali secara instan.</li>
    <li><strong>Utility Cluster:</strong> Terdapat klaster terpisah di sisi kiri yang didedikasikan untuk menjalankan beban kerja utilitas dan manajemen, guna memastikan proses internal tidak mengganggu performa aplikasi publik.</li>
</ul>

<h2>3. CI/CD Pipeline (Pipa Integrasi & Pengiriman Berkelanjutan)</h2>
<p>Perjalanan kode dari <strong>Developer</strong> hingga menjadi fitur yang siap pakai sangat terotomatisasi:</p>
<ol>
    <li>Pengembang menyimpan kode pada repositori <strong>GITLAB</strong>.</li>
    <li>Perubahan kode akan memicu <strong>RUNNER 1</strong> dan <strong>RUNNER 2</strong> untuk melakukan <em>build</em> dan pengujian secara otomatis.</li>
    <li>Hasil <em>build</em> (berupa <em>image container</em>) akan didorong ke <strong>STG-REGISTRY</strong> (repositori privat).</li>
    <li>Dari <em>registry</em> ini, aplikasi didistribusikan secara otomatis ke dalam klaster Kubernetes. Rantai pasok <em>software</em> ini menjamin bahwa peluncuran fitur baru berlangsung cepat, aman, dan tanpa mengorbankan stabilitas sistem.</li>
</ol>

<h2>4. Data & Storage Layer (Lapisan Basis Data & Penyimpanan)</h2>
<p>Keamanan dan keutuhan data adalah prioritas absolut. Sistem penyimpanan dibagi menjadi dua tulang punggung utama:</p>
<ul>
    <li><strong>Relational Database:</strong> Menggunakan klaster <strong>PostgreSQL (STG-DB 1 & STG-DB 2)</strong> yang saling bereplikasi (ditunjukkan oleh tanda panah dua arah). Hal ini menjamin bahwa jika satu <em>server database</em> mati, data tidak akan hilang dan <em>server database</em> cadangan akan langsung menggantikannya.</li>
    <li><strong>Object Storage:</strong> Untuk file tak terstruktur (dokumen, gambar, media), sistem menggunakan penyimpanan berstandar S3 (<strong>STG-S3</strong>) di atas infrastruktur <strong>RUSTFS</strong> yang dirancang secara terdistribusi untuk melayani file dalam skala masif.</li>
</ul>

<h2>5. Observability & Security (Pemantauan & SOC)</h2>
<p>Infrastruktur hebat membutuhkan pengawasan yang sama hebatnya. Di sudut kiri bawah, terdapat tim <strong>SOC (Security Operations Center) dan DevOps</strong> yang didukung oleh tumpukan (<em>stack</em>) visibilitas penuh:</p>
<ul>
    <li><strong>STG-MONIT & STG-LOKI:</strong> Seluruh log sistem, metrik <em>server</em>, dan telemetri ditarik secara <em>real-time</em> ke dalam sistem pemantauan terpusat. Hal ini memungkinkan tim DevOps mendeteksi anomali <em>hardware</em> atau potensi serangan keamanan sebelum berdampak pada pengguna.</li>
</ul>

<blockquote>
    <strong>Catatan Penting:</strong> Desain infrastruktur ini mencerminkan arsitektur berskala Enterprise (<em>Enterprise-grade</em>). Dengan menggabungkan Kubernetes HA, CI/CD otomatis, database tereplikasi, serta pemantauan proaktif, Al-Azhar Apps dibangun untuk menjawab tantangan masa depan dengan slogan yang terbukti benar: <em>"One Platform, Endless Possibilities."</em>
</blockquote>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 3
            ]
        );
    }
}

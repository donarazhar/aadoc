<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class ArchitectureSeeder extends Seeder
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

        // Buat artikel Transformasi Arsitektur
        $title = 'Evolusi Arsitektur Sistem: Monolitik ke Microservices';
        
        $content = '
<h2>Latar Belakang Transformasi</h2>
<p>Seiring dengan berkembangnya ekosistem digital Yayasan Pesantren Islam Al-Azhar, kompleksitas aplikasi dan volume data terus meningkat secara eksponensial. Hal ini menuntut adanya pembaharuan fundamental pada arsitektur sistem agar tetap tangguh, responsif, dan mudah dikembangkan. Gambar arsitektur di atas memvisualisasikan lompatan strategis dari arsitektur <strong>Monolitik</strong> (Sistem Salam Lama) menuju arsitektur <strong>Microservices</strong> (Al-Azhar Apps modern).</p>

<h2>Analisis Arsitektur Lama: SALAM Architecture (Monolitik)</h2>
<p>Pada arsitektur sistem Salam yang lama, aplikasi dibangun menggunakan pendekatan monolitik klasik. Seperti yang terlihat pada diagram sebelah kiri, komponen <strong>User Interface</strong>, <strong>Business Logic</strong>, dan <strong>Data Access Layer</strong> tergabung secara erat <em>(tightly coupled)</em> dalam satu kesatuan sistem besar.</p>
<ul>
    <li><strong>Satu Database Terpusat:</strong> Seluruh modul dan fungsi berbagi satu <em>database</em> yang sama. Beban komputasi menjadi sangat berat ketika terjadi lonjakan pengguna.</li>
    <li><strong>Ketergantungan Modul:</strong> Perubahan kecil pada satu bagian <em>business logic</em> mengharuskan seluruh sistem di-<em>deploy</em> ulang, meningkatkan risiko <em>downtime</em>.</li>
    <li><strong>Hambatan Skalabilitas:</strong> Sulit untuk meningkatkan performa pada satu fitur spesifik saja tanpa harus memperbesar kapasitas <em>server</em> untuk seluruh aplikasi.</li>
</ul>

<h2>Paradigma Baru: AL-AZHAR APPS Architecture (Microservices)</h2>
<p>Diagram sebelah kanan menunjukkan bagaimana Al-Azhar Apps didesain ulang secara radikal menggunakan arsitektur <strong>Microservices</strong>. Sistem besar dipecah menjadi layanan-layanan kecil (<em>microservices</em>) yang berdiri sendiri dan berpusat di sekitar <strong>User Interface</strong> terpadu.</p>
<ul>
    <li><strong>Desentralisasi Database:</strong> Setiap <em>microservice</em> kini memiliki <em>database</em> independennya masing-masing. Isolasi data ini mencegah fenomena <em>single point of failure</em>. Jika satu database layanan bermasalah, layanan lain tetap beroperasi normal.</li>
    <li><strong>Independensi Deployment:</strong> Tim pengembang dapat melakukan <em>update</em>, <em>maintenance</em>, atau penambahan fitur pada satu layanan tanpa mengganggu sistem yang lain. Rilis pembaruan menjadi jauh lebih cepat dan aman.</li>
    <li><strong>Skalabilitas Presisi:</strong> Jika layanan Pembayaran (contohnya) sedang mengalami lonjakan akses pada masa pendaftaran, kita cukup melakukan <em>scaling up</em> khusus pada <em>microservice</em> tersebut, tanpa membebani layanan akademik lainnya.</li>
</ul>

<blockquote>
    <strong>Kesimpulan Strategis:</strong> Transisi dari Monolitik ke Microservices ini bukan sekadar pembaruan teknis, melainkan investasi strategis jangka panjang. Infrastruktur baru Al-Azhar Apps memastikan bahwa sistem akan selalu siap beradaptasi dengan inovasi teknologi baru dan melayani komunitas Al-Azhar tanpa kompromi pada performa dan keandalan.
</blockquote>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}

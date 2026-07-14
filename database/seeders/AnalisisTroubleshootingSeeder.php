<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisTroubleshootingSeeder extends Seeder
{
    public function run(): void
    {
        // Get Admin User dynamically
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        // Kategori: Analisis Sistem
        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Analisis Sistem ALAZHARAPPS')],
            ['name' => 'Analisis Sistem ALAZHARAPPS']
        );

        $content = <<<HTML
<p>Dokumen ini menyajikan panduan praktis (Playbook) bagi tim IT/DevOps Internal untuk melakukan mitigasi, pelacakan masalah (Troubleshooting), dan pemulihan sistem (Disaster Recovery) saat krisis terjadi di ALAZHARAPPS.</p>

<h3>1. Melacak Galat (Error Tracing) di Kontainer</h3>
<p>Saat laporan *bug* masuk (misalnya: "Gagal memuat detail tagihan murid"), administrator harus segera meninjau rekaman (Log) dari *microservice* yang bersangkutan (dalam hal ini, <code>transaction-service</code>).</p>
<ul>
    <li><strong>Masuk ke Server Produksi:</strong> Akses mesin via SSH (<code>ssh root@server_ip</code>).</li>
    <li><strong>Membaca Log Realtime:</strong> Gunakan perintah Docker: <code>docker logs -f transaction-service</code> (ganti nama kontainer sesuai yang bermasalah).</li>
    <li><strong>Analisis Log Berstruktur:</strong> Karena aplikasi Golang ALAZHARAPPS menggunakan pustaka *Logger* mumpuni (seperti Logrus/Zap), *error* akan muncul dalam format JSON yang bersih (contoh: <code>{"level":"error", "msg":"failed to connect to db", "time":"..."}</code>). Perhatikan pesan kunci seperti <em>Timeout</em>, <em>Connection Refused</em>, atau <em>Null Pointer</em>.</li>
</ul>

<h3>2. Skenario Pemulihan Bencana (Disaster Scenarios)</h3>
<p>Berikut adalah beberapa insiden umum dan langkah pertolongan pertamanya (First Aid):</p>
<ol>
    <li><strong>Layanan Tiba-Tiba Mati (Crash/OOM):</strong> Jika lonjakan pengguna (misalnya saat hari pembukaan ujian LMS) menghabiskan RAM server (Out Of Memory), kontainer mungkin mati. 
        <br><em>Aksi:</em> Cek status kontainer <code>docker ps -a</code>. Jika statusnya *Exited (137)*, segera *restart* layanan dengan <code>docker-compose restart lms-course-service</code>, lalu pertimbangkan untuk memperbesar batas memori (*scale-up resource*) di server.
    </li>
    <li><strong>Database Terkunci (Deadlock) atau Lambat:</strong> Jika kueri terasa macet total, kemungkinan besar ada *Database Lock* atau lonjakan batas maksimal koneksi (Max Open Connections terpenuhi).
        <br><em>Aksi:</em> *Restart* kontainer *microservice* agar ia memutus paksa kumpulan koneksi (Connection Pool) yang menggantung. Jika tak mempan, *restart* paksa pangkalan data PostgreSQL.
    </li>
</ol>

<h3>3. Rollback (Kembali ke Versi Lama)</h3>
<p>Jika masalah terjadi tepat setelah pembaruan kode (Deployment terbaru memiliki *bug* fatal), jangan panik. Tim tidak perlu membedah kode di *Production*.</p>
<ul>
    <li>Buka *pipeline* GitLab CI/CD dari repositori yang bersangkutan.</li>
    <li>Cari status *pipeline Deployment* sebelumnya (yang berwarna hijau/lulus dan stabil).</li>
    <li>Klik tombol <strong>Rollback</strong> atau jalankan ulang (<em>Retry/Re-deploy</em>) *pipeline* versi lama tersebut. Dalam hitungan menit, *image* Docker lama akan kembali menimpa versi yang *buggy*, meredakan krisis selagi pengembang mencari solusinya di lingkungan lokal.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('15. Panduan Troubleshooting & Pemulihan Bencana (Disaster Recovery)')],
            [
                'title' => '15. Panduan Troubleshooting & Pemulihan Bencana (Disaster Recovery)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

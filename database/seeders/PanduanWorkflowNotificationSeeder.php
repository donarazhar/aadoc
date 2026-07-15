<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowNotificationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Skenario Workflow Lintas Sistem')],
            ['name' => 'Skenario Workflow Lintas Sistem']
        );

        $content = <<<HTML
<p>Artikel ini membongkar rahasia dapur bagaimana ALAZHARAPPS menangani pengiriman ratusan ribu pesan pemberitahuan (<em>Broadcast/Push Notification</em>) ke ponsel orang tua tanpa menyebabkan aplikasi melambat atau <em>server crash</em>. Pusat dari orkestrasi ini adalah <code>account-service</code> yang didukung oleh arsitektur antrean (<em>Message Queue</em>).</p>

<h3>Diagram Urutan: Skenario Broadcast & Push Notification</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant BO as Backoffice (Web)
    participant ACC as Account Service
    participant MQ as Redis/Event Bus (Antrean)
    participant FCM as Firebase Cloud Messaging
    participant WA as WhatsApp Gateway (Qontak/Fonnte)
    participant OTM as Orang Tua (Mobile)

    %% Fase Trigger Broadcast
    BO->>ACC: Submit "Kirim Pengumuman Libur" (ke 5.000 Siswa)
    ACC->>MQ: Terbitkan 5.000 Tugas (Publish Event)
    ACC-->>BO: Response Cepat: "Pengumuman sedang diproses"
    
    %% Fase Asinkron (Latar Belakang)
    Note over ACC,MQ: Background Worker mengambil tugas satu per satu
    
    loop Setiap Pesan di Antrean
        MQ->>ACC: Konsumsi Pesan (Consume)
        ACC->>ACC: Format Pesan & Ekstrak Device Token / No WA
        
        par Pengiriman Paralel
            ACC->>FCM: API Call: Send Push Notif
            FCM-->>OTM: Muncul Pop-up di Layar HP
        and
            ACC->>WA: API Call: Send WhatsApp Message
            WA-->>OTM: Pesan WA Masuk
        end
    end
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Mengirim 1 pesan WhatsApp membutuhkan waktu sekitar 1 detik. Jika sekolah mengirim 5.000 pengumuman kelulusan secara bersamaan menggunakan metode konvensional (sinkron), admin Backoffice harus menatap layar <em>loading</em> selama hampir 1,5 jam, dan server kemungkinan besar akan <em>timeout</em>. Untuk mencegah bencana tersebut, ALAZHARAPPS menggunakan metode <strong>Asinkron (Asynchronous Worker)</strong>.</p>

<h4>1. Pemisahan Tugas (Fire and Forget)</h4>
<ul>
    <li>Saat Admin Sekolah menekan tombol <strong>Kirim Pengumuman</strong> di Backoffice, sistem <code>account-service</code> <strong>TIDAK</strong> langsung menghubungi pihak ketiga (Firebase atau WhatsApp).</li>
    <li>Sebaliknya, sistem hanya menaruh daftar 5.000 tugas pengiriman tersebut ke dalam sebuah keranjang antrean berkecepatan tinggi (seperti Redis Streams atau Event Mediator lokal).</li>
    <li>Karena hanya menyimpan data ke <em>memory</em>, proses ini selesai dalam hitungan milidetik. Sistem langsung memberikan respons "Berhasil" ke layar admin, membebaskan admin untuk mengerjakan tugas lain.</li>
</ul>

<h4>2. Background Worker (Pekerja Latar Belakang)</h4>
<ul>
    <li>Di belakang layar, terdapat <em>Goroutine Worker</em> (kumpulan <em>thread</em> kecil spesifik Golang) yang tidak pernah tidur. Mereka terus-menerus memantau keranjang antrean tadi.</li>
    <li>Worker ini akan mengambil tugas (misal 50 pesan sekaligus) dan mulai memprosesnya secara paralel (<em>concurrency</em>).</li>
</ul>

<h4>3. Integrasi Pihak Ketiga (Firebase & WhatsApp)</h4>
<ul>
    <li><strong>Firebase Cloud Messaging (FCM):</strong> Untuk <em>Push Notification</em> (notifikasi pop-up berlambang lonceng di atas layar HP). Worker akan mencari <code>fcm_token</code> milik orang tua di database, menyusun format JSON (Judul, Isi Pesan, Gambar), dan menembakkannya ke server Google Firebase.</li>
    <li><strong>WhatsApp Gateway (Fonnte/Qontak):</strong> Untuk notifikasi yang bersifat sangat krusial (seperti Tagihan Telat atau OTP Login), sistem akan merangkai pesan teks dan menembakkannya ke penyedia layanan WhatsApp Resmi. <em>Rate Limiting</em> diterapkan di sini agar nomor pengirim tidak diblokir oleh pihak Meta/WhatsApp karena dianggap <em>Spam</em>.</li>
</ul>

<h4>4. Penanganan Kegagalan (Retry Mechanism)</h4>
<ul>
    <li>Jika server WhatsApp Gateway sedang mati atau koneksi ke Firebase terputus, pesan yang gagal <strong>tidak akan hilang</strong>.</li>
    <li>Worker akan menandai pesan tersebut sebagai "Gagal", dan memasukkannya kembali ke dalam antrean untuk dicoba lagi (<em>Retry</em>) beberapa menit kemudian (<em>Exponential Backoff</em>).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Engine Notifikasi Terpusat (Broadcast & Worker)')],
            [
                'title' => 'Skenario Engine Notifikasi Terpusat (Broadcast & Worker)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

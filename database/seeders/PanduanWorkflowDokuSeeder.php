<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowDokuSeeder extends Seeder
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
<p>Artikel ini membongkar rahasia dapur arsitektur keuangan tanpa kasir (<em>Cashless</em>) di ALAZHARAPPS. Sistem ini terintegrasi secara mulus dengan <strong>DOKU Payment Gateway</strong> melalui metode API B2B (<em>Server-to-Server</em>). Artikel ini akan fokus pada mekanisme <em>Virtual Account (VA)</em> dan <em>QRIS</em> beserta pengamanan tingkat tinggi (<em>Bank-Grade Security</em>) yang diterapkan.</p>

<h3>Diagram Urutan: Integrasi DOKU Payment Gateway</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Orang Tua (Mobile)
    participant TXN as Transaction Service (ALAZHARAPPS)
    participant DKU as DOKU Server (Payment Gateway)
    participant BNK as Jaringan Perbankan (Bank)
    participant EVT as Event Bus (Worker Latar Belakang)

    %% Fase 1: Request (Pembuatan Tagihan)
    Note over OTM,DKU: Tahap 1: Pembuatan Kode Bayar
    OTM->>TXN: Buka Tagihan & Klik "Bayar via VA Mandiri"
    TXN->>DKU: Request API: Create Virtual Account (Kirim Nominal & Data Siswa)
    DKU-->>TXN: Response: Nomor VA Unik (Mis: 888123456)
    TXN-->>OTM: Tampilkan Nomor VA di Layar Aplikasi
    
    %% Fase 2: Pembayaran (Di Luar Sistem Kita)
    Note over OTM,BNK: Tahap 2: Pembayaran Fisik
    OTM->>BNK: Buka M-Banking / ATM, Transfer ke Nomor VA
    BNK->>DKU: Jaringan Antar-Bank Mengkonfirmasi Dana Masuk
    
    %% Fase 3: Rekonsiliasi Real-Time (Webhook)
    Note over DKU,EVT: Tahap 3: Webhook & Validasi Keamanan
    DKU->>TXN: Webhook Callback HTTP POST (Kirim Notifikasi Lunas)
    TXN->>TXN: Validasi HMAC Signature & Access Token (Mencegah Hacker)
    
    alt Jika Tanda Tangan Valid (Sah)
        TXN->>EVT: Publish Event "VirtualAccountPaid" (Asinkron)
        TXN-->>DKU: HTTP 200 OK (ResponseCode: 2002500)
    else Jika Invalid (Serangan Siber)
        TXN-->>DKU: HTTP 401 Unauthorized (Ditolak)
    end
    
    %% Fase 4: Penyelesaian Asinkron
    Note over EVT,OTM: Tahap 4: Eksekusi Latar Belakang
    EVT->>EVT: Worker Membaca Event (Tanpa Membuat Server Lag)
    EVT->>EVT: Update Database Status Tagihan = PAID
    EVT-->>OTM: Tembakkan Push Notification "Terima Kasih, Tagihan Lunas!"
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Banyak sistem sekolah hancur (<em>down</em>) ketika ribuan orang tua membayar tagihan secara serentak di tanggal 1 setiap bulannya. ALAZHARAPPS mengatasi masalah ini dengan memisahkan jalur pembayaran (DOKU) dan jalur penyelesaian database (<em>Event Bus Worker</em>).</p>

<h4>1. Pembuatan Kode Bayar (Generate VA/QRIS)</h4>
<ul>
    <li>Saat Orang Tua menekan "Bayar", <code>transaction-service</code> tidak membuat nomor sendiri. Sistem bertindak sebagai perantara yang menembakkan <em>API Request</em> ke server DOKU.</li>
    <li>DOKU membalas dengan Nomor Virtual Account atau kode QRIS yang unik untuk anak tersebut. Jika QRIS, sistem akan merendernya menjadi gambar *barcode* di layar HP orang tua.</li>
</ul>

<h4>2. Webhook Callback (Titik Paling Krusial)</h4>
<ul>
    <li>ALAZHARAPPS <strong>TIDAK</strong> pernah melakukan pengecekan berulang-ulang ke server Bank ("Apakah sudah dibayar?"). Hal tersebut akan menghabiskan kuota server.</li>
    <li>Sistem menggunakan metode pasif bernama <strong>Webhook</strong>. Saat uang masuk, server DOKU lah yang proaktif "mengetuk pintu" server ALAZHARAPPS untuk memberitahu bahwa tagihan telah lunas.</li>
</ul>

<h4>3. Keamanan Tingkat Bank (Anti-Hacker)</h4>
<ul>
    <li>Bagaimana jika ada <em>Hacker</em> yang iseng mengirim pesan palsu ke <em>Webhook</em> kita agar tagihannya dianggap lunas? ALAZHARAPPS mencegahnya dengan ketat pada <code>webhook_controller.go</code>.</li>
    <li>Sistem memeriksa <strong>HMAC Signature</strong> (Tanda Tangan Kriptografi) dan <strong>Access Token</strong> yang hanya diketahui oleh DOKU dan ALAZHARAPPS. Jika ada satu huruf saja yang meleset, permintaan akan ditendang dengan status <code>401 Unauthorized</code>.</li>
</ul>

<h4>4. Penyelesaian Asinkron (Asynchronous Event Bus)</h4>
<ul>
    <li>Jika validasi berhasil, sistem <strong>tidak langsung mengubah database saat itu juga</strong>. Hal ini karena jika database sedang sibuk (<em>Lock</em>), Webhook DOKU bisa <em>Timeout</em> dan DOKU akan mengira sistem kita mati.</li>
    <li>Sebagai gantinya, sistem melempar kejadian ini ke dalam <strong>Event Bus</strong> (<code>event.VirtualAccountPaid</code>), lalu dengan sangat cepat membalas DOKU dengan status "Sukses".</li>
    <li>Di belakang layar, <em>Worker</em> (Pekerja) akan mengambil <em>Event</em> tersebut secara perlahan dan mengubah status tagihan di database menjadi <code>PAID</code> serta menembakkan notifikasi kuitansi ke orang tua. Inilah rahasia mengapa server ALAZHARAPPS tidak pernah <em>down</em> di tanggal gajian!</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Integrasi Payment Gateway (DOKU & Webhook)')],
            [
                'title' => 'Skenario Integrasi Payment Gateway (DOKU & Webhook)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

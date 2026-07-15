<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowFinanceSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan alur penyelesaian transaksi keuangan, mulai dari <em>Generate</em> Tagihan Massal oleh pihak sekolah (Backoffice) hingga rekonsiliasi pembayaran secara <em>Real-time</em> melalui Payment Gateway.</p>

<h3>Diagram Urutan: Siklus Tagihan & Pembayaran (Billing Cycle)</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant KEU as Admin Keuangan (Backoffice)
    participant TXN as Transaction Service
    participant OTM as Orang Tua (Mobile)
    participant PG as Payment Gateway (Third-Party)
    participant DB as Database (PostgreSQL)

    %% Fase Penerbitan Tagihan
    KEU->>TXN: Klik "Generate SPP Bulan Ini"
    TXN->>DB: Query seluruh Murid Aktif
    TXN->>DB: Bulk Insert Data Tagihan (Status: UNPAID)
    TXN-->>OTM: Kirim Push Notification (Firebase): "Tagihan Baru Muncul"

    %% Fase Pembayaran
    OTM->>TXN: Buka Menu Tagihan, Pilih SPP & Klik Bayar
    TXN->>PG: Request Virtual Account / QRIS
    PG-->>TXN: Return Nomor VA & Total Pembayaran
    TXN-->>OTM: Tampilkan Nomor VA / QRIS di Layar HP
    OTM->>PG: Transfer Dana via Bank/E-Wallet (M-Banking)

    %% Fase Settlement & Real-time Update
    PG->>TXN: Callback Webhook: Pembayaran Sukses (Status LUNAS)
    TXN->>DB: Update Status Tagihan = PAID & Simpan Jurnal
    TXN->>TXN: Eksekusi Event-Bus Settlement
    TXN-->>OTM: Push Notification: "Terima Kasih, Pembayaran Berhasil"
    
    %% Sinkronisasi Laporan
    KEU->>DB: Tarik Laporan Realisasi Pendapatan (Real-time)
    DB-->>KEU: Data Dashboard Update
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Sistem ini dirancang untuk menghapus beban rekonsiliasi manual. Peran utama ada di <code>transaction-service</code> yang bertindak sebagai jembatan antara aplikasi dan Pihak Ketiga (Bank/Payment Gateway).</p>

<h4>1. Penerbitan Tagihan Otomatis / Massal</h4>
<ul>
    <li>Proses dimulai oleh Administrator Keuangan (atau secara otomatis melalui <em>Cron Job / Scheduler</em>) pada tanggal tertentu setiap bulannya.</li>
    <li>Sistem (backend) tidak lagi membuat tagihan satu per satu, melainkan menggunakan mekanisme <strong>Bulk Insert</strong> untuk ribuan murid sekaligus. Hal ini memangkas waktu pemrosesan dari jam menjadi hanya beberapa detik.</li>
    <li>Sistem menggunakan arsitektur antrean (<em>Message Broker / Goroutine Worker</em>) untuk menembakkan <em>Push Notification</em> massal agar server tidak tercekik (<em>Timeout</em>).</li>
</ul>

<h4>2. Proses Pembayaran di Aplikasi (Seamless Checkout)</h4>
<ul>
    <li>Saat Orang Tua Murid (OTM) membuka notifikasi, tagihan akan otomatis muncul di <strong>Menu Tagihan</strong>.</li>
    <li>Pengguna dapat langsung menekan tombol "Bayar". Di sini, <code>transaction-service</code> bertindak meminta <em>Virtual Account</em> (VA) atau kode QRIS unik langsung ke Payment Gateway (seperti Midtrans/Xendit) secara dinamis. Opsi metode pembayaran menjadi tak terbatas tanpa sistem sekolah perlu membuka saluran <em>Host-to-Host</em> ke masing-masing bank.</li>
</ul>

<h4>3. Rekonsiliasi Real-Time (Webhook Callback)</h4>
<ul>
    <li><strong>Kunci utama otomatisasi ada di sini:</strong> Ketika orang tua mentransfer dana dari M-Banking mereka, uang akan masuk ke Payment Gateway. Detik itu juga, Payment Gateway menembakkan HTTP POST Request (disebut <em>Webhook / Callback</em>) ke titik akhir (<em>endpoint</em>) milik <code>transaction-service</code>.</li>
    <li>Sistem memvalidasi keabsahan <em>Webhook</em> (melalui tanda tangan rahasia / <em>Signature Key</em>), lalu <strong>tanpa campur tangan manusia</strong>, mengubah status tagihan di tabel database dari <code>UNPAID</code> menjadi <code>PAID</code>.</li>
    <li>Sistem juga langsung menembakkan notifikasi pembayaran berhasil ke ponsel orang tua sebagai tanda terima (Kwitansi Digital).</li>
</ul>

<h4>4. Single Source of Truth bagi Manajemen</h4>
<p>Karena setiap status transaksi (Sukses, Pending, Expired) selalu tersinkronisasi di satu <em>database</em> terpusat, fitur Dasbor Keuangan di portal Backoffice akan menampilkan angka realisasi pendapatan yang 100% akurat dan ter-<em>update</em> setiap detik tanpa perlu penarikan (<em>download</em>) mutasi rekening koran manual.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Keuangan, Penagihan & Webhook (Billing Cycle)')],
            [
                'title' => 'Skenario Keuangan, Penagihan & Webhook (Billing Cycle)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

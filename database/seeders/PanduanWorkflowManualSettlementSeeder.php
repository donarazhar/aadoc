<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowManualSettlementSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan skenario penanganan "Pengecualian Pembayaran" (<em>Payment Exceptions</em>). Skenario ini terjadi ketika Orang Tua Murid tidak melakukan pembayaran melalui aplikasi (Virtual Account/QRIS otomatis), melainkan mentransfer langsung uang tunai ke rekening Yayasan (misal melalui Teller Bank atau mesin EDC). ALAZHARAPPS menangani hal ini melalui modul <strong>Manual Settlement & Rekonsiliasi Berbasis File (CSV/Excel)</strong>.</p>

<h3>Diagram Urutan: Skenario Rekonsiliasi Bank Manual</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Orang Tua / Wali
    participant BNK as Pihak Bank (Teller/EDC)
    participant ADM as Admin Keuangan (Backoffice)
    participant TXN as Transaction Service
    participant DB as Database (PostgreSQL)

    %% Fase Transaksi Offline
    Note over OTM,BNK: Transaksi di Luar Sistem
    OTM->>BNK: Transfer Dana Langsung ke Rekening Yayasan
    BNK-->>OTM: Berikan Struk Fisik Bukti Transfer
    
    %% Fase Penarikan Mutasi
    Note over BNK,ADM: Tarik Mutasi Rekening (Harian/Mingguan)
    ADM->>BNK: Download Mutasi (Koran Bank) format CSV/Excel
    
    %% Fase Pratinjau (Preview) Rekonsiliasi
    Note over ADM,TXN: Proses di Portal Backoffice
    ADM->>TXN: Upload File Mutasi CSV (Menu Rekonsiliasi)
    TXN->>TXN: Parsing File (Ekstrak Nomor Referensi / VA / Nominal)
    TXN->>DB: Pencocokan (Matching) Data Bank vs Data Tagihan (UNPAID)
    TXN-->>ADM: Tampilkan Layar "Preview Settlement" (Valid/Invalid)
    
    %% Fase Eksekusi & Penyelesaian
    alt Jika Data Matching (Sesuai)
        ADM->>TXN: Klik "Proses Settlement"
        TXN->>DB: Ubah Status Tagihan = PAID
        TXN->>DB: Simpan Laporan Settlement (Settlement Report)
        TXN-->>OTM: Push Notification: "Pembayaran Manual Diterima"
    else Jika Data Tidak Cocok (Anomaly)
        TXN-->>ADM: Tandai Baris Merah (Kekurangan Bayar / Referensi Salah)
        ADM->>TXN: Lakukan Koreksi Manual (Dispute Resolution)
    end
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Dalam operasional keuangan sekolah berskala besar, mustahil mengharapkan 100% orang tua menggunakan aplikasi. Seringkali dana miliaran rupiah masuk langsung ke rekening bank yayasan. Modul Rekonsiliasi di <code>transaction-service</code> diciptakan khusus untuk meringankan kerja Admin Keuangan agar tidak perlu mencontreng (mencocokkan) tagihan satu per satu secara manual.</p>

<h4>1. Persiapan File Mutasi (Extract)</h4>
<ul>
    <li>Admin Keuangan tidak perlu menginput data pelunasan satu demi satu. Admin cukup mengunduh file mutasi rekening (berformat CSV atau Excel) langsung dari portal perbankan milik sekolah.</li>
</ul>

<h4>2. Proses Pratinjau Cerdas (Preview Settlement)</h4>
<ul>
    <li>Admin mengunggah file tersebut ke dalam portal Backoffice. Fungsi <code>PreviewSettlement</code> di dalam <code>transaction-service</code> akan bekerja membaca ribuan baris file Excel tersebut.</li>
    <li>Sistem menggunakan algoritma pencocokan (<em>matching</em>) untuk mencari <strong>Nomor Virtual Account</strong>, <strong>Student Cost Code (Kode Biaya Siswa)</strong>, atau <strong>Nomor Induk</strong> yang tertera pada deskripsi transfer bank.</li>
    <li>Setelah sistem selesai menghitung, layar Backoffice akan menampilkan tabel perbandingan: Sebelah kiri adalah uang yang masuk di bank, sebelah kanan adalah tagihan yang belum lunas (<em>UNPAID</em>) di database.</li>
</ul>

<h4>3. Penyelesaian Sengketa (Dispute & Anomaly Handling)</h4>
<p>Ini adalah fitur paling krusial untuk mencegah kebocoran dana:</p>
<ul>
    <li><strong>Cocok (Matched):</strong> Jika nominal transfer bank persis sama dengan nominal tagihan SPP anak tersebut, sistem akan menandainya dengan warna hijau (Siap dieksekusi).</li>
    <li><strong>Kekurangan Bayar (Underpaid):</strong> Jika tagihan Rp 1.000.000 namun transfer hanya Rp 900.000, sistem menandainya dengan warna kuning/merah. Admin harus memutuskan apakah menolak pelunasan atau membiarkan sisa Rp 100.000 menjadi piutang.</li>
    <li><strong>Tidak Dikenali (Unknown):</strong> Uang masuk tanpa deskripsi (<em>blank</em>). Sistem akan meminta Admin untuk mencari siswa mana yang memiliki dana tersebut dan memasangkannya (<em>pairing</em>) secara manual di layar.</li>
</ul>

<h4>4. Finalisasi Kuitansi & Laporan</h4>
<ul>
    <li>Setelah Admin menekan tombol <strong>Proses Settlement</strong>, fungsi <code>CreateSettlement</code> akan berjalan.</li>
    <li>Ribuan tagihan yang berstatus UNPAID akan secara serentak (<em>concurrent</em>) berubah menjadi PAID.</li>
    <li>Sistem menyimpan riwayat eksekusi dalam bentuk <code>SettlementReport</code> untuk keperluan Audit Keuangan Yayasan di akhir tahun.</li>
    <li>Walaupun orang tua membayar secara tunai/luring, sistem tetap menerbitkan Kuitansi Digital (berformat PDF via fungsi <code>DownloadReceiptsPDF</code>) dan mengirimkan notifikasi lunas ke aplikasi HP orang tua.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Rekonsiliasi Pembayaran Manual (Settlement Upload)')],
            [
                'title' => 'Skenario Rekonsiliasi Pembayaran Manual (Settlement Upload)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

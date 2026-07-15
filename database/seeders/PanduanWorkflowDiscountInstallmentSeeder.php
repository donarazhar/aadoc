<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowDiscountInstallmentSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan skenario fleksibilitas pembayaran di ALAZHARAPPS, yaitu pengajuan <strong>Diskon (Potongan Biaya)</strong> dan <strong>Angsuran (Cicilan)</strong>. Alur ini menyoroti bagaimana <code>transaction-service</code> menangani kalkulasi finansial menggunakan arsitektur <em>Hybrid Discounting</em> (Otomatis & Manual) serta hierarki persetujuan (<em>Approval</em>).</p>

<h3>Diagram Urutan: Skenario Diskon Hybrid & Skema Angsuran</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Orang Tua (Mobile/Offline)
    participant ADM as Admin Keuangan (Backoffice)
    participant TXN as Transaction Service (Backend)
    participant KEP as Kepala Sekolah / Dir. Keuangan
    participant DB as Database (PostgreSQL)

    %% Skenario Diskon Otomatis
    Note over OTM,DB: Skenario 1A: Diskon Otomatis (Alumni / Anak Pegawai)
    OTM->>TXN: Pendaftaran Siswa (Submit NIK)
    TXN->>TXN: Goroutine: Cek Kelayakan Alumni / Pegawai
    TXN->>DB: Terbitkan Tagihan Didiskon (Status: ACTIVE, Note: System Generated)
    TXN-->>OTM: Tagihan Baru Muncul di Aplikasi

    %% Skenario Diskon Manual
    Note over OTM,DB: Skenario 1B: Diskon Manual (Saudara Kandung / Prestasi)
    OTM->>ADM: Serahkan Syarat Dokumen Fisik (KK / Sertifikat)
    ADM->>TXN: Input Nominal/Persentase Diskon di Backoffice
    TXN->>DB: Buat Record Diskon (Status: PENDING_APPROVAL)
    
    TXN-->>KEP: Kirim Notifikasi Permintaan Persetujuan Diskon
    KEP->>TXN: Klik "Setuju" (Approve)
    TXN->>DB: Update Status Diskon = ACTIVE & Potong Tagihan Utama
    TXN-->>OTM: Tagihan Baru (Sudah Didiskon) Muncul di Aplikasi

    %% Skenario Angsuran
    Note over OTM,DB: Skenario 2: Pengajuan Skema Angsuran Uang Pangkal
    OTM->>ADM: Memohon Skema Pembayaran Dicicil
    ADM->>TXN: Pilih Skema (Misal: 3x Cicilan, Termin 1 = 50%)
    
    alt Cicilan Standar (<= 3 Kali)
        ADM->>TXN: Setujui Pengajuan Secara Mandiri (Level Sekolah)
    else Cicilan Khusus (> 3 Kali)
        ADM->>TXN: Submit Pengajuan Cicilan Panjang
        TXN-->>KEP: Eskalasi ke Direktorat Keuangan Yayasan
        KEP->>TXN: Review & Berikan Persetujuan (Approve)
    end
    
    TXN->>DB: Nonaktifkan (Sembunyikan) Tagihan Induk Lunas
    TXN->>DB: Generate Sub-Tagihan Termin 1
    TXN-->>OTM: Tagihan Termin 1 Muncul di Aplikasi Mobile
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Dua fitur ini menunjukkan kehebatan mesin transaksi ALAZHARAPPS dalam memberikan fleksibilitas finansial tanpa mengorbankan integritas data dan standar operasional yayasan.</p>

<h4>1. Alur Pengajuan Diskon (Hybrid Discounting Architecture)</h4>
<p>Berdasarkan struktur pada <code>discount_handler.go</code>, sistem menerapkan dua model pemberian diskon:</p>
<ul>
    <li><strong>Diskon Otomatis (System Generated):</strong> Berlaku untuk kategori <strong>Lulusan YPI (Alumni)</strong> dan <strong>Anak Pegawai</strong>. Saat orang tua mendaftar, sistem mengeksekusi <em>Goroutine</em> di latar belakang untuk melakukan pencocokan NIK. Jika terdeteksi kelayakan, sistem langsung memotong harga secara otomatis tanpa campur tangan Admin (Tanpa Approval).</li>
    <li><strong>Diskon Manual (Approval Based):</strong> Berlaku untuk <strong>Saudara Kandung (Siblings)</strong>, <strong>Prestasi</strong>, dan <strong>Hafalan Al-Quran</strong>. Validasi dokumen fisik (seperti Kartu Keluarga atau Sertifikat) diperlukan. Admin menginput diskon ini di Backoffice, yang menghasilkan status <code>PENDING_APPROVAL</code>. Kepala Sekolah harus menyetujui pengajuan ini sebelum fungsi <code>ActivateDiscountBill</code> memotong tagihan asli.</li>
</ul>

<h4>2. Alur Skema Angsuran (Cicilan Uang Pangkal)</h4>
<ul>
    <li><strong>Konteks:</strong> Membantu orang tua yang ingin memecah 1 tagihan besar (seperti Uang Pangkal) menjadi beberapa termin pembayaran bulanan.</li>
    <li><strong>Persetujuan Bertingkat:</strong>
        <ul>
            <li>Jika dicicil standar (maksimal 3 kali), Admin Keuangan Sekolah bisa langsung menyetujuinya.</li>
            <li>Jika kelonggaran dicicil lebih dari 3 kali, sistem akan mengunci otorisasi Sekolah dan menge-eskalasi permohonan ke <strong>Direktorat Keuangan Yayasan</strong>.</li>
        </ul>
    </li>
    <li><strong>Rekayasa Tagihan (Magic Billing):</strong> Saat skema cicilan diaktifkan, sistem akan <strong>menyembunyikan</strong> Tagihan Induk dari pandangan aplikasi orang tua. Sebagai gantinya, sistem menerbitkan <strong>Sub-Tagihan (Termin 1)</strong>.</li>
    <li><strong>Penagihan Otomatis Termin Selanjutnya:</strong> Sistem penjadwalan (<em>Cron Job / Scheduler</em>) akan memantau tanggal jatuh tempo. Saat mendekati batas waktu Termin 2, sistem secara diam-diam membangkitkan tagihan selanjutnya dan mengirim <em>Push Notification</em> pengingat.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Pengajuan Diskon dan Skema Angsuran')],
            [
                'title' => 'Skenario Pengajuan Diskon (Hybrid) dan Skema Angsuran',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

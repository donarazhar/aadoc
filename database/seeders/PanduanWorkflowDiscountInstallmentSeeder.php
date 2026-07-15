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
<p>Artikel ini mendokumentasikan skenario fleksibilitas pembayaran di ALAZHARAPPS, yaitu pengajuan <strong>Diskon (Potongan Biaya)</strong> dan <strong>Angsuran (Cicilan)</strong>. Alur ini menyoroti bagaimana <code>transaction-service</code> menangani kalkulasi finansial dan hierarki persetujuan (<em>Approval</em>) secara otomatis.</p>

<h3>Diagram Urutan: Skenario Diskon & Skema Angsuran</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Orang Tua (Mobile/Offline)
    participant ADM as Admin Keuangan (Backoffice)
    participant TXN as Transaction Service (Backend)
    participant KEP as Kepala Sekolah / Dir. Keuangan
    participant DB as Database (PostgreSQL)

    %% Skenario Diskon
    Note over OTM,DB: Skenario 1: Pengajuan Diskon (Potongan Biaya)
    OTM->>ADM: Serahkan Syarat Diskon (Mis: Saudara Kandung / Alumni)
    ADM->>TXN: Input Nominal/Persentase Diskon di Backoffice
    TXN->>DB: Buat Record Diskon (Status: PENDING_APPROVAL)
    
    TXN-->>KEP: Kirim Notifikasi Permintaan Persetujuan Diskon
    KEP->>TXN: Klik "Setuju" (Approve)
    TXN->>DB: Update Status Diskon = ACTIVE
    TXN->>TXN: Kalkulasi Ulang: Potong Nilai Tagihan Utama
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
    
    OTM->>TXN: Bayar Tagihan Termin 1
    TXN->>DB: Ubah Status Murid = AKTIF
    
    Note over TXN,OTM: Bulan Berikutnya (Mendekati Jatuh Tempo Termin 2)
    TXN->>DB: Scheduler/Cron Job Membaca Tanggal Jatuh Tempo
    TXN->>DB: Generate Sub-Tagihan Termin 2
    TXN-->>OTM: Push Notification: Tagihan Termin 2 Tersedia
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Dua fitur ini menunjukkan kehebatan mesin transaksi ALAZHARAPPS dalam memberikan fleksibilitas finansial tanpa mengorbankan integritas data dan standar operasional yayasan.</p>

<h4>1. Alur Pengajuan Diskon (Potongan Harga)</h4>
<ul>
    <li><strong>Konteks:</strong> Berlaku untuk potongan harga khusus seperti Diskon Saudara Kandung, Diskon Alumni, atau Diskon Anak Pegawai Yayasan (Internal).</li>
    <li><strong>Langkah Operasional:</strong> Orang tua menyerahkan dokumen pendukung ke sekolah. Admin Keuangan membuka profil siswa di Backoffice dan menginput persentase diskon.</li>
    <li><strong>Hierarki Persetujuan (Approval):</strong> Sistem tidak langsung memotong harga. Tagihan diskon akan berstatus <code>PENDING_APPROVAL</code>. Kepala Sekolah (atau pimpinan terkait) harus me-<em>review</em> dan menyetujui pengajuan tersebut melalui portal Backoffice.</li>
    <li><strong>Eksekusi Otomatis:</strong> Saat disetujui, fungsi <code>ActivateDiscountBill</code> di <em>backend</em> akan mencari tagihan induk, memotong nominalnya secara <em>real-time</em>, dan menerbitkan tagihan baru yang lebih kecil ke aplikasi mobile Orang Tua.</li>
</ul>

<h4>2. Alur Skema Angsuran (Cicilan)</h4>
<ul>
    <li><strong>Konteks:</strong> Membantu orang tua yang ingin memecah 1 tagihan besar (seperti Uang Pangkal) menjadi beberapa termin pembayaran bulanan berdasarkan tanggal jatuh tempo.</li>
    <li><strong>Persetujuan Bertingkat:</strong>
        <ul>
            <li>Jika orang tua meminta skema standar (misalnya dicicil maksimal 3 kali), Admin Keuangan Sekolah bisa langsung menyetujuinya di sistem.</li>
            <li>Jika orang tua meminta kelonggaran mencicil lebih dari 3 kali (skema khusus), sistem akan mengunci hak otorisasi Admin Sekolah. Permohonan akan diteruskan secara sistem (eskalasi) ke <strong>Direktorat Keuangan Yayasan</strong> untuk di-<em>review</em>.</li>
        </ul>
    </li>
    <li><strong>Rekayasa Tagihan (Magic Billing):</strong> Saat skema cicilan diaktifkan, sistem akan <strong>menyembunyikan</strong> Tagihan Induk dari pandangan aplikasi orang tua. Sebagai gantinya, sistem menerbitkan <strong>Sub-Tagihan (Termin 1)</strong> (misal 50% dari total tagihan).</li>
    <li><strong>Aktivasi Status Siswa:</strong> Saat orang tua melunasi Termin 1 via Payment Gateway, sistem akan menganggap syarat finansial awal telah terpenuhi dan mengubah status murid menjadi <strong>AKTIF</strong>.</li>
    <li><strong>Penagihan Otomatis Termin Selanjutnya:</strong> Sistem memiliki mesin otomatis (<em>Cron Job / Scheduler</em>). Saat kalender mendekati tanggal jatuh tempo Termin 2, sistem secara diam-diam akan membangkitkan tagihan Termin 2 dan melempar <em>Push Notification</em> pengingat ke aplikasi orang tua.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Pengajuan Diskon dan Skema Angsuran')],
            [
                'title' => 'Skenario Pengajuan Diskon dan Skema Angsuran',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

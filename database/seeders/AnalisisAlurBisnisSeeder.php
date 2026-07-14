<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisAlurBisnisSeeder extends Seeder
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
<p>Dokumen ini memetakan Alur Logika Bisnis Inti (Core Business Workflows) pada aplikasi ALAZHARAPPS, dengan fokus pada modul finansial (Fintech) pendidikan, yaitu siklus pembayaran SPP dan pendaftaran murid baru (PPDB).</p>

<h3>1. Siklus Pembayaran SPP (Billing &amp; Payment Gateway)</h3>
<p>Proses ini melibatkan interaksi intensif antara Frontend, <code>transaction-service</code>, dan pihak ketiga (Payment Gateway).</p>
<ol>
    <li><strong>Pembuatan Tagihan (Invoicing):</strong> Setiap awal bulan, sistem (melalui *cron job* atau *event-driven scheduler* di backend) secara massal menghasilkan tagihan (invoice) SPP untuk seluruh siswa aktif berdasarkan jenjang kelas dan kebijakan yayasan (ditarik dari <code>school-service-new</code>).</li>
    <li><strong>Akses Tagihan oleh Orang Tua:</strong> Orang tua login via aplikasi *Mobile* atau portal Web, menembak endpoint <code>GET /api/v1/transactions/bills</code>. Kueri ini akan menampilkan daftar tagihan tertunda (Unpaid).</li>
    <li><strong>Inisiasi Pembayaran:</strong> Saat orang tua mengklik "Bayar", frontend mengirim instruksi ke <code>transaction-service</code>. Servis ini kemudian berkomunikasi dengan Payment Gateway (seperti Midtrans/Xendit) via API HTTP untuk membuat <em>Virtual Account (VA)</em> atau tautan pembayaran dompet digital (e-Wallet).</li>
    <li><strong>Callback (WebHook) Payment Gateway:</strong> Setelah orang tua mentransfer dana via ATM/M-Banking, Payment Gateway akan memanggil rute *callback* publik di ALAZHARAPPS (misal: <code>POST /api/v1/payments/webhook</code>). 
        <br><em>*Catatan Kritis: Di titik inilah transaksi *Database* berjalan ketat. Sistem akan memverifikasi *Signature Key* dari webhook untuk mencegah pemalsuan pembayaran.</em>
    </li>
    <li><strong>Pencatatan Jurnal Otomatis:</strong> Setelah tervalidasi, <code>transaction-service</code> mengubah status tagihan menjadi "Lunas", lalu secara asinkron memicu pembentukan entri jurnal akuntansi (Buku Besar) yang mendebit Kas dan mengkredit Pendapatan SPP. Notifikasi lunas kemudian dikirim ke WhatsApp/Email orang tua via layanan terintegrasi (seperti Fonnte).</li>
</ol>

<h3>2. Proses Pendaftaran Murid Baru (PPDB)</h3>
<p>Proses PPDB (Penerimaan Peserta Didik Baru) merupakan gerbang awal masuknya data ke dalam <code>student-service</code>.</p>
<ol>
    <li><strong>Pendaftaran Akun Awal:</strong> Calon orang tua mengakses situs <code>landing-page</code> dan membuat akun dasar (hanya email dan telepon). Data ini masuk ke <code>account-service</code> dengan *role* khusus (misal: <code>prospective_parent</code>).</li>
    <li><strong>Pengisian Formulir Induk:</strong> Melalui *dashboard* PPDB, calon orang tua melengkapi formulir identitas siswa dan riwayat kesehatan. Data JSON dikirim ke <code>student-service</code>. Sistem mengizinkan penyimpanan berulang (*save as draft*) hingga formulir di-<em>submit</em> final.</li>
    <li><strong>Pembayaran Formulir/Uang Pangkal:</strong> Mirip dengan alur SPP, modul <code>transaction-service</code> menerbitkan tagihan pendaftaran. Jika belum dibayar, orang tua tidak dapat mencetak Kartu Ujian Masuk.</li>
    <li><strong>Validasi &amp; Penempatan (Placement):</strong> Setelah siswa lulus tes dan melunasi Uang Pangkal, admin sekolah (melalui <code>frontend</code>) mengubah status siswa di <code>student-service</code> dari *Candidate* menjadi *Active*. Pada fase ini, Nomor Induk (NISN/NIS) di-<em>generate</em> secara unik dan siswa dimasukkan ke relasi tabel kelas pada tahun ajaran yang sedang berjalan.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('12. Alur Logika Bisnis Inti (Siklus Finansial & PPDB)')],
            [
                'title' => '12. Alur Logika Bisnis Inti (Siklus Finansial & PPDB)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowPMBSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan secara rinci perjalanan alur <strong>Penerimaan Murid Baru (PMB) End-to-End</strong>, mulai dari tindakan Orang Tua di aplikasi Mobile hingga pemrosesan dokumen dan pembayaran di portal Backoffice. Alur di bawah ini mencerminkan logika bisnis aktual yang terprogram di dalam <em>student-service</em> dan <em>transaction-service</em>.</p>

<h3>Diagram Urutan Skenario PMB (Sequence Diagram)</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Orang Tua (Mobile)
    participant BO as Backoffice (Web)
    participant SYS as Sistem (Database)

    %% Persiapan
    Note over BO,SYS: Tahap A.1 Persiapan
    BO->>SYS: Set Gelombang PMB & Tarif (UP/SPP)

    %% Pendaftaran Awal
    Note over OTM,SYS: Tahap A.2 Pendaftaran Awal
    OTM->>SYS: Daftar Anak via Aplikasi
    SYS-->>OTM: Buat Record: Status ANIMO
    SYS-->>OTM: Terbitkan Tagihan Formulir Pendaftaran
    OTM->>SYS: Bayar Tagihan Formulir (via QRIS/VA)
    OTM->>SYS: Lengkapi Identitas Asal Sekolah & Profil

    %% Ujian
    Note over OTM,BO: Tahap A.3 Ujian Masuk
    BO->>SYS: Verifikasi Data & Generate Kartu Ujian
    SYS-->>OTM: Kirim Kartu Ujian ke Aplikasi (PDF)
    OTM->>BO: Anak Ikut Ujian (Hadir Membawa Kartu)

    %% Penilaian & Kelulusan
    Note over OTM,BO: Tahap A.4 Penilaian & Kelulusan
    BO->>SYS: Upload Nilai (Excel Template) & Submit Kelulusan
    SYS-->>OTM: Push Notification: "LULUS" & Kirim S&K Uang Pangkal
    OTM->>SYS: Menyetujui S&K (Klik Setuju di Aplikasi)

    %% Percabangan Pembayaran
    alt A.5.a Jalur Reguler (Lunas)
        SYS-->>OTM: Muncul Tagihan Uang Pangkal (Penuh)
        OTM->>SYS: Bayar Lunas UP
        SYS->>SYS: Ubah Record: MURID = AKTIF
    else A.5.b Jalur Cicilan
        OTM->>BO: Datang ke Sekolah (Mengajukan Skema Cicilan)
        BO->>SYS: Admin Memproses Permohonan Angsuran
        opt Jika Cicilan > 3 Kali
            SYS->>BO: Request Approval Direktorat Keuangan
        end
        SYS-->>OTM: Tagihan UP Termin 1 (Min 50%)
        OTM->>SYS: Bayar UP Termin 1
        SYS->>SYS: Ubah Record: MURID = AKTIF
    end
</code></pre>

<h3>A. Alur PMB (Penerimaan Murid Baru) Secara Detail</h3>
<p>Bayangkan ini seperti funnel/corong — dari banyak pendaftar, hanya yang lolos & bayar yang akhirnya jadi murid resmi. Terdapat dua kemungkinan jalur pembayaran: <strong>Tanpa Cicilan (Reguler)</strong> dan <strong>Dengan Cicilan</strong>. Kedua jalur ini sama persis di awal, dan baru bercabang setelah calon murid dinyatakan lulus ujian.</p>

<h4>A.1 Tahap Persiapan (dilakukan Backoffice/Sekolah)</h4>
<ol>
    <li><strong>Setting Komponen Biaya & Gelombang Pendaftaran:</strong> Sebelum pendaftaran dibuka, tim Backoffice sekolah menyiapkan dua hal di sistem:
        <ul>
            <li>Komponen Uang Pangkal dan Uang Sekolah (SPP) beserta rinciannya.</li>
            <li><strong>GELOMBANG_PMB</strong> — periode pendaftaran (tanggal buka/tutup) per jenjang dan TAHUN_AJARAN.</li>
        </ul>
    </li>
</ol>

<h4>A.2 Tahap Pendaftaran Awal (dilakukan Orang Tua/Murid — OTM)</h4>
<ol start="2">
    <li><strong>Calon murid daftar (Status: Animo):</strong> Orang tua melakukan pendaftaran awal melalui aplikasi &rarr; data masuk ke tabel CALON_MURID dengan status awal <em>Animo</em>.</li>
    <li><strong>Bayar Uang Formulir (Gerbang Pertama):</strong> Sebelum lanjut ke tahap berikutnya, calon murid wajib membayar Uang Formulir melalui menu Tagihan di aplikasi (metode QRIS atau lainnya). Kalau belum bayar, status akan "macet" di sini dan tidak bisa lanjut.</li>
    <li><strong>Lengkapi Identitas:</strong> Setelah formulir lunas, OTM melengkapi data Asal Sekolah dan Profil Murid secara menyeluruh, lalu mengajukan data tersebut untuk diverifikasi sekolah.</li>
</ol>

<h4>A.3 Tahap Ujian Masuk</h4>
<ol start="5">
    <li><strong>Sekolah mengirimkan Kartu Ujian:</strong> Setelah data disetujui, Backoffice memicu sistem untuk mengirimkan Kartu Ujian ke akun OTM.</li>
    <li><strong>OTM mendapatkan kartu & anak mengikuti ujian:</strong> OTM mengunduh Kartu Peserta Ujian dari aplikasi (wajib ditunjukkan saat ujian berlangsung), lalu anak mengikuti tes sesuai jadwal.</li>
</ol>

<h4>A.4 Tahap Penilaian & Pengumuman Kelulusan (dilakukan Backoffice)</h4>
<ol start="7">
    <li><strong>Input & Upload Nilai:</strong> Tim Backoffice men-download template nilai dari sistem, mengisi hasil ujian sesuai format, lalu mengunggah (upload) kembali nilai tersebut.</li>
    <li><strong>Meluluskan & Mengirim Notifikasi:</strong> Calon murid yang memenuhi syarat diluluskan (submit kelulusan) di sistem, lalu notifikasi kelulusan otomatis dikirim ke OTM melalui Push Notification/WhatsApp.</li>
</ol>
<p><em>Di titik inilah alur mulai bercabang menjadi dua jalur, tergantung skema pembayaran Uang Pangkal yang dipilih OTM: Tanpa Cicilan atau Dengan Cicilan.</em></p>

<h4>A.5.a Jalur Tanpa Cicilan — Pembayaran Uang Pangkal (Gerbang Kedua)</h4>
<ol start="9">
    <li><strong>Terima notifikasi & Syarat Ketentuan UP:</strong> OTM menerima notifikasi lulus ujian sekaligus notifikasi syarat & ketentuan Uang Pangkal (UP). OTM membuka menu tersebut untuk melihat komponen biaya UP, lalu menekan Setuju dan menerima file PDF rincian biaya.</li>
    <li><strong>Bayar Uang Pangkal secara penuh:</strong> Tagihan UP muncul di menu Tagihan aplikasi. OTM membayar komponen UP secara lunas sekaligus.</li>
    <li><strong>Status berubah menjadi Aktif:</strong> Setelah pembayaran terkonfirmasi oleh <em>Payment Gateway</em>, sistem membuat record baru di tabel MURID dengan status <strong>Aktif</strong>, dan siswa resmi terdaftar.</li>
</ol>

<h4>A.5.b Jalur Dengan Cicilan — Pengajuan Angsuran Uang Pangkal</h4>
<ol start="9">
    <li><strong>Ajukan cicilan langsung ke sekolah:</strong> Sama seperti jalur reguler, OTM menerima notifikasi syarat & ketentuan UP dan menekan Setuju. Namun jika OTM ingin mencicil, OTM harus datang langsung ke sekolah (Tata Usaha) untuk mengajukan permohonan skema angsuran — proses ini dilakukan secara luring/tatap muka, bukan melalui aplikasi.</li>
    <li><strong>Persetujuan angsuran:</strong> Tim Backoffice sekolah memproses permohonan sesuai ketentuan jumlah angsuran yang ditetapkan Yayasan. <strong>Aturan Khusus:</strong> Jika permohonan lebih dari 3 kali angsuran, permohonan diteruskan secara sistem ke Direktorat Keuangan untuk mendapat persetujuan (approval) khusus sebelum skema cicilan berlaku.</li>
    <li><strong>Pembayaran bertahap (minimal 50% di termin pertama):</strong> Setelah disetujui, tagihan UP muncul di menu Tagihan yang sudah disesuaikan dengan jadwal cicilan. Setelah OTM membayar termin pertama, status anak akan berubah menjadi <strong>Aktif</strong>.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Penerimaan Murid Baru (PPDB End-to-End)')],
            [
                'title' => 'Skenario Penerimaan Murid Baru (PPDB End-to-End)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

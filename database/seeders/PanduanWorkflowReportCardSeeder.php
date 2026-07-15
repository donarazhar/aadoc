<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowReportCardSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan Skenario Akademik Puncak, yaitu proses pengolahan nilai, rekapitulasi <em>Leger</em> (Buku Induk Nilai), hingga penerbitan Rapor Digital dan Ijazah. Proses berat ini dikerjakan secara komprehensif oleh <code>report-service</code> yang meringankan tugas Wali Kelas dan Admin Sekolah.</p>

<h3>Diagram Urutan: Skenario Rapor Digital & Kelulusan</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant GBS as Guru Bidang Studi
    participant WK as Wali Kelas
    participant RPT as Report Service (Backend)
    participant KEP as Kepala Sekolah
    participant OTM as Orang Tua (Mobile)

    %% Fase Pengumpulan Nilai
    Note over GBS,RPT: Tahap 1: Penginputan Nilai Mentah
    GBS->>RPT: Input Nilai Harian & Ujian (Per Mata Pelajaran)
    GBS->>RPT: Input Nilai Non-Akademik (Kokurikuler/Ekskul)
    RPT->>RPT: Validasi KKM (Kriteria Ketuntasan Minimal)

    %% Fase Rekapitulasi (Leger)
    Note over WK,RPT: Tahap 2: Pembentukan Leger & Draft Rapor
    WK->>RPT: Klik "Generate Leger Kelas"
    RPT->>RPT: Agregasi Nilai + Tarik Data Absensi (Student Service)
    RPT-->>WK: Tampilkan Draft Rapor (Preview)
    WK->>RPT: Input Catatan Wali Kelas (Behavior/Attitude)

    %% Fase Validasi & Penguncian
    Note over WK,KEP: Tahap 3: Validasi & Penguncian (Lock)
    WK->>RPT: Submit Rapor Final
    RPT-->>KEP: Rapor Siap Divalidasi
    KEP->>RPT: Approve & Lock (Kunci Rapor)
    
    %% Fase Distribusi / Kelulusan
    Note over RPT,OTM: Tahap 4: Distribusi Digital
    alt Siswa Kelas Reguler (Mis: Kelas 1-5 / 7-8)
        RPT->>RPT: Generate PDF Rapor Digital (Watermarked)
        RPT-->>OTM: Push Notification: "Rapor Semester Telah Terbit"
        OTM->>RPT: Download PDF dari Aplikasi Mobile
    else Siswa Kelas Akhir (Kelulusan / Kelas 6, 9, 12)
        RPT->>RPT: Generate PDF Ijazah & SKHUN Internal
        RPT-->>OTM: Push Notification: "Dokumen Kelulusan Telah Terbit"
    end
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Proses pembagian rapor tradisional membutuhkan waktu berminggu-minggu untuk merekap nilai dari puluhan guru ke dalam satu buku besar (Leger) menggunakan Microsoft Excel. ALAZHARAPPS menghapus beban tersebut dengan rekayasa data (<em>data processing</em>) di dalam sistem.</p>

<h4>1. Desentralisasi Input Nilai</h4>
<ul>
    <li>Guru Matematika hanya melihat kolom nilai Matematika, Guru Agama hanya melihat kolom Agama. Tidak ada lagi proses mengirim-ngirim file Excel via <em>flashdisk</em>.</li>
    <li>Sistem <code>report-service</code> secara cerdas akan langsung memberikan peringatan (warna merah) jika nilai yang diinput guru berada di bawah KKM (Kriteria Ketuntasan Minimal).</li>
</ul>

<h4>2. Agregasi Otomatis (Pembentukan Leger)</h4>
<ul>
    <li>Wali kelas adalah konduktor dalam proses ini. Mereka tidak perlu mengetik nilai anak didiknya.</li>
    <li>Saat Wali Kelas menekan tombol <strong>Generate Leger</strong>, sistem akan menarik seluruh nilai dari semua guru mata pelajaran, menarik nilai Ekstrakurikuler, dan bahkan memanggil API ke <code>student-service</code> untuk menarik rekapitulasi <strong>Absensi (Kehadiran)</strong> siswa selama 6 bulan terakhir.</li>
    <li>Semua elemen tersebut disatukan menjadi Draft Rapor.</li>
</ul>

<h4>3. Validasi Kepala Sekolah (Penguncian Data)</h4>
<ul>
    <li>Rapor adalah dokumen legal. Oleh karena itu, sebelum rapor "diterbitkan" ke aplikasi orang tua, harus ada proses validasi.</li>
    <li>Kepala Sekolah akan memeriksa kelengkapan pengisian rapor seluruh kelas. Jika sudah sesuai, Kepala Sekolah akan mengunci (<em>Lock</em>) rapor tersebut. Setelah dikunci, guru mata pelajaran <strong>tidak bisa lagi</strong> mengubah nilai.</li>
</ul>

<h4>4. Distribusi Ramah Lingkungan (Paperless)</h4>
<ul>
    <li>Sistem akan menggunakan mesin <em>template generator</em> untuk mencetak nilai-nilai tersebut ke dalam format PDF standar Yayasan Al-Azhar (lengkap dengan <em>Watermark</em> / <em>Digital Signature</em>).</li>
    <li>Orang Tua mendapatkan notifikasi di aplikasi genggam mereka dan dapat langsung melihat atau mengunduh PDF Rapor tersebut. Hal ini sangat menghemat biaya cetak kertas (<em>printing</em>) bagi sekolah.</li>
    <li>Bagi siswa tingkat akhir, modul <code>diploma_usecase.go</code> akan mengambil alih untuk mencetak dokumen tambahan seperti Surat Keterangan Lulus (SKL) atau Ijazah Internal Yayasan.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Pengolahan Rapor Digital dan Kelulusan')],
            [
                'title' => 'Skenario Pengolahan Rapor Digital dan Kelulusan',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

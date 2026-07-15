<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowLMSSeeder extends Seeder
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
<p>Artikel ini menjelaskan skenario pembelajaran dan evaluasi akademik secara digital. Fokus utama pada skenario ini adalah eksekusi ujian mandiri (Computer Based Test / CBT) melalui sistem <strong>Learning Management System (LMS)</strong> di Backoffice dan Aplikasi Genggam Siswa dengan fitur keamanan tinggi (<em>Safe Exam Browser</em>).</p>

<h3>Diagram Urutan: Skenario Ujian Akademik (LMS & CBT)</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant GRU as Guru (Backoffice)
    participant LMS as LMS Service (Backend)
    participant SIS as Siswa (Mobile)
    participant SEB as Safe Exam Browser (Device)
    participant DB as Database (PostgreSQL)

    %% Fase Persiapan
    GRU->>LMS: Unggah Soal Ujian (Bank Soal)
    GRU->>LMS: Atur Jadwal, Durasi & Kelas Peserta
    LMS->>DB: Simpan Jadwal & Metadata Ujian
    LMS-->>SIS: Push Notification: "Ujian Matematika Dimulai Besok"

    %% Fase Pelaksanaan Ujian (CBT)
    SIS->>LMS: Buka Aplikasi, Masuk Menu Ujian CBT
    LMS->>DB: Validasi Jadwal Ujian (Sedang Berlangsung?)
    
    alt Waktu Belum Tiba
        LMS-->>SIS: Tampilkan Hitung Mundur (Countdown)
    else Waktu Ujian Aktif
        LMS-->>SIS: Izinkan Akses Soal & Token Ujian
        SIS->>SEB: Memicu Mode Lockdown (Kunci Layar Ponsel)
        SEB-->>SIS: "Anda tidak dapat keluar layar selama ujian berlangsung"
        SIS->>LMS: Mengirim Jawaban (Auto-Save per Soal)
        LMS->>DB: Simpan Jawaban Sementara
    end

    %% Fase Penyelesaian & Penilaian
    alt Siswa Menekan "Selesai" ATAU Waktu Habis
        SIS->>LMS: Submit Seluruh Lembar Jawaban
        SEB->>SIS: Matikan Mode Lockdown
        LMS->>LMS: Auto-Grader (Kalkulasi Nilai Pilihan Ganda)
        LMS->>DB: Simpan Nilai Akhir
    end
    
    %% Sinkronisasi Laporan
    GRU->>LMS: Buka Menu Rekap Nilai Ujian
    LMS->>DB: Tarik Nilai Hasil CBT
    LMS-->>GRU: Tampilkan Tabel Laporan Nilai Kelas
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Ekosistem <strong>LMS (Learning Management System)</strong> ALAZHARAPPS menggantikan siklus ujian konvensional berbasis kertas, dengan penekanan pada integritas ujian agar tidak mudah dicurangi oleh murid ketika dilakukan secara digital.</p>

<h4>1. Sinkronisasi Data Master Akademik</h4>
<p>Guru tidak perlu mengelola daftar siswa secara manual. <code>lms-course-service</code> secara otomatis menarik data rombongan belajar (rombel/kelas) dan penugasan guru dari <code>school-service</code>, sehingga pembuatan ujian otomatis langsung terdistribusi ke murid yang tepat.</p>

<h4>2. Persiapan Ujian Terpusat</h4>
<ul>
    <li>Guru membuat butir soal melalui form interaktif di portal Backoffice, mendukung format teks, gambar, hingga persamaan matematika kompleks (LaTeX).</li>
    <li>Guru menentukan <strong>Parameter Ketat:</strong> Tanggal mulai, tenggat waktu (<em>deadline</em>), durasi hitung mundur, dan syarat kelulusan (KKM).</li>
</ul>

<h4>3. Anti-Cheating dengan Safe Exam Browser (SEB)</h4>
<p>Keamanan ujian di lingkungan <em>Mobile</em> (Android/iOS) adalah isu krusial. ALAZHARAPPS menanganinya dengan mengaktifkan mode penguncian layar (<em>Lockdown/Kiosk Mode</em>) saat sesi ujian berjalan:</p>
<ul>
    <li>Saat tombol "Mulai Ujian" ditekan, aplikasi seluler akan masuk ke mode layar penuh <em>(Full Screen)</em>.</li>
    <li>Notifikasi dari aplikasi lain (seperti WhatsApp/Instagram) akan dibisukan atau diblokir.</li>
    <li>Fitur tangkapan layar (<em>Screenshot</em>) maupun rekam layar dinonaktifkan secara paksa oleh sistem operasi (<em>Prevent Screen Capture</em>).</li>
    <li>Siswa tidak dapat menekan tombol kembali (<em>Back button</em>) atau tombol beranda (<em>Home button</em>) untuk mencari jawaban di internet (<em>Googling</em>). Jika dipaksa, aplikasi dapat mendeteksi pelanggaran dan secara otomatis mendiskualifikasi ujian.</li>
</ul>

<h4>4. Auto-Save & Toleransi Jaringan (Resilience)</h4>
<p>Aplikasi dirancang untuk wilayah dengan koneksi internet tak stabil. Jawaban murid tidak ditumpuk hingga akhir. Sistem akan terus menyimpan jawaban per nomor (<em>Auto-Save</em>) secara otomatis. Jika di tengah ujian kuota internet murid habis atau ponsel mati, murid dapat masuk kembali dan meneruskan tepat di soal terakhir yang mereka kerjakan (tanpa mengulang dari awal) asalkan durasi waktu (<em>timer</em>) masih ada.</p>

<h4>5. Skoring Real-time (Auto-Grader)</h4>
<p>Begitu murid mengirim (<em>submit</em>) lembar jawaban mereka, untuk jenis soal objektif (Pilihan Ganda), mesin (<em>Auto-Grader</em>) akan langsung menghitung total skor murid dan menyimpannya di <em>database</em>. Guru tak perlu memeriksa secara manual; hasilnya seketika itu juga muncul di lembar rekap nilai (<em>gradebook</em>) Backoffice.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Akademik dan Ujian (LMS & CBT)')],
            [
                'title' => 'Skenario Akademik dan Ujian (LMS & CBT)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

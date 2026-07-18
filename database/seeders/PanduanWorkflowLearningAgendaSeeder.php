<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowLearningAgendaSeeder extends Seeder
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
<p>Artikel ini mendokumentasikan skenario pemantauan kualitas kegiatan belajar mengajar (KBM) di lingkungan sekolah. ALAZHARAPPS menggunakan modul khusus (<code>learning_agenda_usecase</code> dan <code>personnel_materials_usecase</code> di dalam <code>student-service</code>) untuk mendigitalisasi Jurnal Mengajar dan RPP (Rencana Pelaksanaan Pembelajaran) Guru.</p>

<h3>Diagram Urutan: Skenario Jurnal Harian Guru & Materi Ajar</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant GRU as Guru Mata Pelajaran
    participant LMS as Student Service (Modul KBM)
    participant SIS as Siswa (Aplikasi)
    participant KEP as Kepala Sekolah / Pengawas
    participant DB as Database (PostgreSQL)

    %% Fase Persiapan Mengajar
    Note over GRU,LMS: Tahap 1: Persiapan Materi (Pre-Class)
    GRU->>LMS: Unggah Materi Ajar (Bahan Tayang / PDF / Link Video)
    LMS->>DB: Simpan Master Materi
    
    %% Fase Pelaksanaan KBM
    Note over GRU,SIS: Tahap 2: Proses Belajar Mengajar
    GRU->>LMS: Buka Sesi Kelas & Tautkan Materi
    LMS-->>SIS: Materi Ajar Terbuka di Aplikasi Siswa
    
    %% Fase Pelaporan KBM (Jurnal Harian)
    Note over GRU,LMS: Tahap 3: Pengisian Jurnal (Post-Class)
    GRU->>LMS: Input "Jurnal Mengajar" (Apa yang diajarkan hari ini)
    GRU->>LMS: Input "Catatan Bimbingan" (Siswa bermasalah/prestasi)
    LMS->>DB: Simpan Agenda Pembelajaran
    
    %% Fase Supervisi
    Note over KEP,DB: Tahap 4: Supervisi Akademik
    KEP->>LMS: Buka Dashboard Kinerja Guru
    LMS->>DB: Tarik Data Jurnal Mengajar Seluruh Guru
    LMS-->>KEP: Tampilkan Laporan: Kesiapan Materi & Kedisiplinan Input Jurnal
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Kualitas pendidikan sangat bergantung pada kedisiplinan guru di dalam kelas. Modul ini bukan untuk membebani guru dengan administrasi, melainkan memberikan transparansi (visibilitas) yang adil atas kerja keras guru di lapangan agar dapat dipantau oleh Kepala Sekolah secara obyektif.</p>

<h4>1. Sentralisasi Materi Ajar (Pre-Class)</h4>
<ul>
    <li>Sebelum masuk ke kelas (atau pada awal semester), guru mengunggah silabus, modul PDF, atau tautan YouTube ke dalam <strong>Bank Materi</strong> (<code>personnel_materials_usecase</code>).</li>
    <li>Hal ini memastikan bahwa materi pembelajaran terdokumentasi dengan baik sebagai aset (kekayaan intelektual) sekolah, tidak hilang atau tercecer di <em>Google Drive</em> pribadi guru.</li>
</ul>

<h4>2. Pengisian Jurnal Mengajar (Post-Class)</h4>
<ul>
    <li>Di era konvensional, guru mengisi buku tebal bernama "Buku Batas Pelajaran" atau Jurnal Kelas yang sering dibawa berkeliling oleh ketua kelas. Di ALAZHARAPPS, fitur ini sepenuhnya digital (<code>learning_agenda_usecase</code>).</li>
    <li>Setelah jam pelajaran berakhir (atau di penghujung hari), guru cukup membuka aplikasi dan mengetik ringkasan: <em>"Hari ini mengajarkan Bab 3 tentang Tata Surya, target capaian selesai."</em></li>
    <li><strong>Sinergi Bimbingan Konseling (Catatan Pertemuan):</strong> Jika pada jam pelajaran tersebut ada murid yang sangat aktif, atau sebaliknya ada yang tidur di kelas, guru dapat menyelipkan catatan khusus (<code>meeting_note_usecase</code>). Catatan ini akan menjadi rekam jejak untuk Guru Bimbingan Konseling (BK) atau menjadi evaluasi saat pembagian rapor.</li>
</ul>

<h4>3. Supervisi Akademik Tanpa Kertas</h4>
<ul>
    <li>Bagi <strong>Kepala Sekolah</strong> (Role Level 11) dan <strong>Pengawas Yayasan</strong> (Role Level 15), modul ini adalah jendela emas (<em>Golden Window</em>).</li>
    <li>Tanpa harus masuk (sidak) ke kelas satu per satu, Kepala Sekolah dapat melihat <em>Dashboard</em> untuk mengetahui:<br>
      - <em>"Berapa persen guru yang sudah mengunggah materi bulan ini?"</em><br>
      - <em>"Apakah ada guru yang sering alpa mengisi Jurnal Mengajar?"</em><br>
      - <em>"Apakah kurikulum bulan ini sudah tersampaikan semua?"</em></li>
    <li>Hal ini memungkinkan pimpinan sekolah untuk mengambil keputusan strategis dan memberikan pelatihan jika ada guru yang masih kesulitan dengan sistem.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Jurnal Harian Guru dan Materi Ajar')],
            [
                'title' => 'Skenario Jurnal Harian Guru dan Materi Ajar',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanProsesBisnisLMSSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Proses Bisnis')],
            ['name' => 'Buku Panduan Proses Bisnis']
        );

        $content = <<<HTML
<p>Dokumen ini memetakan alur kerja (<em>Business Process</em>) dari ujung ke ujung (*end-to-end*) khusus untuk ekosistem <strong>LMSALAZHARAPPS</strong>. Ekosistem ini berfokus pada denyut nadi harian sekolah: <strong>Kegiatan Belajar Mengajar (KBM)</strong>, <strong>Ujian (CBT)</strong>, dan <strong>Penilaian Akademik (E-Rapot)</strong>.</p>

<h3>Diagram Alur Proses Bisnis LMSALAZHARAPPS</h3>
<pre><code class="language-mermaid">
flowchart TD
    A[Awal Tahun Ajaran] --> B(Penyusunan RPP & Jadwal Pelajaran)
    B --> C(KBM Harian & Jurnal Guru)
    C --> D{Presensi Siswa}
    D -->|Hadir/Izin| E[Notifikasi Mobile Orang Tua]
    D -->|Alpa| F[Teguran Wali Kelas]
    
    C --> G(Tugas & Ujian CBT)
    G --> H{Aplikasi SEB Mobile}
    H -->|Ujian Selesai| I(Penilaian Otomatis)
    
    I --> J[Rekapitulasi Nilai]
    D --> J
    J --> K(E-Rapot & Penguncian)
    K --> L[Cetak PDF / Ijazah]
</code></pre>

<h3>1. Proses Hulu: Perencanaan Akademik (Awal Tahun)</h3>
<p>Proses ini terjadi sebelum siswa masuk ke dalam kelas pada hari pertama sekolah.</p>
<ul>
    <li><strong>Tahap 1 (Pemetaan Kelas & Wali):</strong> Kepala Sekolah atau Kurikulum membagi siswa ke dalam Rombongan Belajar (Rombel) dan menunjuk Wali Kelas.</li>
    <li><strong>Tahap 2 (Pembuatan Jadwal Pelajaran):</strong> Admin Kurikulum menyusun matriks jadwal. Kapan Guru Matematika mengajar di Kelas 7A, dan kapan Guru Agama mengajar di 7B. Jadwal ini yang nantinya akan di-<em>consume</em> (dibaca) oleh Aplikasi Mobile Siswa dan Orang Tua.</li>
    <li><strong>Tahap 3 (Rencana Pelajaran/RPP):</strong> Guru menyiapkan materi pembelajaran (Modul/PDF/Video) yang diunggah ke *course-service* agar bisa diakses siswa dari rumah.</li>
</ul>

<h3>2. Proses Inti: KBM Harian (Kegiatan Belajar Mengajar)</h3>
<p>Ini adalah rutinitas yang terjadi setiap hari (Senin - Jumat).</p>
<ul>
    <li><strong>Tahap 1 (Jurnal Mengajar Guru):</strong> Saat bel masuk berbunyi, Guru membuka aplikasi/web, memilih jadwal kelasnya hari itu, dan mengisi "Jurnal Mengajar" (Materi apa yang diajarkan hari ini).</li>
    <li><strong>Tahap 2 (Presensi Harian):</strong> Guru memanggil nama siswa satu per satu. Di dalam sistem (<em>jurnal-service</em>), Guru mencentang status kehadiran (Hadir, Sakit, Izin, Alpa).</li>
    <li><strong>Tahap 3 (Notifikasi Real-time):</strong> Saat Guru menekan tombol "Simpan Presensi", sistem langsung menembakkan *Push Notification* ke HP Orang Tua yang memberitahukan bahwa anak mereka sudah berada di dalam kelas dengan selamat (atau sebaliknya, membolos).</li>
</ul>

<h3>3. Proses Evaluasi: E-Learning & CBT (Ujian)</h3>
<p>Proses penilaian harian, UTS, hingga UAS.</p>
<ul>
    <li><strong>Tahap 1 (Pembuatan Bank Soal):</strong> Guru menyusun soal (Pilihan Ganda / Esai) di dalam Bank Soal sistem LMS.</li>
    <li><strong>Tahap 2 (Penjadwalan CBT - Computer Based Test):</strong> Guru menerbitkan ujian dengan batas waktu (<em>Timer</em>) yang ketat (Misalnya: Mulai jam 08:00, selesai 09:30).</li>
    <li><strong>Tahap 3 (Pelaksanaan Ujian Anti-Nyontek):</strong> Siswa membuka ujian tersebut menggunakan Aplikasi Mobile Android. Sistem memaksa mereka masuk ke <em>Safe Exam Browser (SEB) Mode</em> (Layar terkunci, tidak bisa buka Google, tidak bisa <em>Screenshot</em>, dan navigasi HP dimatikan). Jika ketahuan mencoba keluar aplikasi, ujian akan tertutup otomatis.</li>
    <li><strong>Tahap 4 (Kalkulasi Nilai Otomatis):</strong> Segera setelah waktu habis, sistem otomatis memeriksa jawaban pilihan ganda dan memunculkan skor. Menghemat waktu koreksi guru hingga 90%.</li>
</ul>

<h3>4. Proses Hilir: E-Rapot & Pencetakan Kelulusan</h3>
<p>Siklus administratif yang terjadi di akhir Semester atau akhir Tahun Ajaran.</p>
<ul>
    <li><strong>Tahap 1 (Input Nilai Akhir):</strong> Guru mata pelajaran menggabungkan nilai tugas harian, nilai UTS, dan UAS (dari CBT di atas) ke dalam tabel (<em>Grid</em>) E-Rapot di Backoffice. Jika nilai di bawah KKM, sistem memberikan indikator peringatan visual.</li>
    <li><strong>Tahap 2 (Validasi Wali Kelas):</strong> Wali kelas memeriksa kembali seluruh nilai dari semua guru mata pelajaran untuk anak walinya, lalu menambahkan catatan/deskripsi sikap (Karakter).</li>
    <li><strong>Tahap 3 (Penguncian / Locking):</strong> Kepala Sekolah mengecek rekapitulasi. Jika sudah benar, Kepala Sekolah menekan tombol "Gembok" (<em>Lock</em>). Artinya, guru tidak bisa lagi diam-diam mengubah nilai siswanya.</li>
    <li><strong>Tahap 4 (Pencetakan Massal):</strong> Sistem me-<em>generate</em> (membuat) ratusan file PDF (Buku Rapor atau Ijazah kelulusan) sekaligus. File PDF ini bisa langsung diakses oleh Orang Tua dari Aplikasi Mobile tanpa harus menunggu pembagian rapor fisik di sekolah.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Proses Bisnis Inti LMSALAZHARAPPS')],
            [
                'title' => 'Panduan Proses Bisnis: Siklus Akademik & CBT LMSALAZHARAPPS',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

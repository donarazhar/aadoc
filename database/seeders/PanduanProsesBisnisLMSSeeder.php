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
<p>Dokumen ini memetakan alur kerja (<em>Business Process</em>) dari ujung ke ujung ekosistem <strong>LMSALAZHARAPPS</strong>, yang kini disempurnakan dengan <strong>Peta Navigasi UI/UX</strong> (Panduan *Klik*). Dokumen ini berfungsi sebagai SOP Utama bagi Kepala Sekolah, Wali Kelas, dan Guru Mata Pelajaran.</p>

<h3>1. Proses Hulu: Persiapan Kelas (Awal Tahun/Semester)</h3>
<p>Siklus administratif sebelum kegiatan belajar fisik dimulai.</p>
<ul>
    <li><strong>Tahap 1: Pembuatan Rombel & Pemetaan Guru</strong>
        <ul>
            <li><strong>Jejak UI (Kepala Sekolah):</strong> Masuk Web Backoffice &rarr; Sidebar Kiri &rarr; <code>Sekolah</code> &rarr; <code>Rombel</code>.</li>
            <li><strong>Aksi UX:</strong> Gunakan form <strong>Dual Listbox</strong> (Dua kolom daftar nama). Klik dan pindahkan nama-nama siswa dari kolom "Belum Punya Kelas" (kiri) ke kolom "Anggota Kelas 7A" (kanan). Cari nama Guru di <em>Dropdown</em> untuk ditunjuk sebagai "Wali Kelas".</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Jadwal Pelajaran (Schedule Matrix)</strong>
        <ul>
            <li><strong>Aksi UX:</strong> Admin Kurikulum menggunakan tabel matriks hari dan jam untuk menempatkan Guru Mata Pelajaran ke kelas-kelas yang telah dibuat. Jadwal ini akan memicu kemunculan menu di HP Guru.</li>
        </ul>
    </li>
</ul>

<h3>2. Proses Inti: Rutinitas KBM & Presensi Harian</h3>
<p>Denyut nadi operasional sekolah sehari-hari yang menghubungkan Guru di kelas dengan Orang Tua di rumah.</p>
<ul>
    <li><strong>Tahap 1: Pengisian Jurnal & Presensi (Guru)</strong>
        <ul>
            <li><strong>Jejak UI (Guru):</strong> Buka Aplikasi Mobile Guru (Atau akses Web) &rarr; Beranda &rarr; Klik kotak jadwal <code>Mengajar Kelas 7A Jam 08:00</code>.</li>
            <li><strong>Aksi UX:</strong> Layar memunculkan daftar nama siswa. Guru mencentang (*Checkbox*) atau menekan tombol (*Radio Button*) pada status: <code>Hadir / Sakit / Izin / Alpa</code>. Pada kotak teks di bawahnya, Guru mengetik <code>Jurnal Mengajar</code> (Topik: Bab 1 Matematika). Tekan <strong>Submit</strong>.</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Keajaiban Notifikasi (Orang Tua)</strong>
        <ul>
            <li><strong>Jejak UX (Orang Tua):</strong> Di saat yang bersamaan, HP Android/iOS milik orang tua bergetar. Menampilkan pesan *Push Notification* <strong>"Ananda Budi telah hadir di pelajaran Matematika"</strong>.</li>
            <li><strong>Aksi UI:</strong> Orang tua bisa membuka menu <code>Akademik</code> &rarr; <code>Jadwal & Absensi</code> di HP mereka untuk melihat grafik pie (<em>Doughnut Chart</em>) statistik kehadiran anak selama satu semester.</li>
        </ul>
    </li>
</ul>

<h3>3. Proses Evaluasi: CBT (Computer Based Test)</h3>
<p>Proses penyelenggaraan Ulangan Harian, UTS, dan UAS bebas kecurangan.</p>
<ul>
    <li><strong>Tahap 1: Pembuatan Soal (Guru)</strong>
        <ul>
            <li><strong>Jejak UI (Guru):</strong> Web Backoffice &rarr; Sidebar <code>LMS</code> &rarr; <code>Bank Soal</code> &rarr; <code>Ujian</code>.</li>
            <li><strong>Aksi UX:</strong> Guru membuat soal menggunakan <em>Rich Text Editor</em>, mengatur batas waktu mundur (<em>Countdown Timer</em>), dan menekan <strong>Terbitkan Ujian</strong>.</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Mengerjakan Ujian Anti-Nyontek (Siswa)</strong>
        <ul>
            <li><strong>Jejak UI (Siswa):</strong> Buka Aplikasi Mobile Siswa &rarr; Menu <code>Jadwal Ujian</code> &rarr; Klik tombol <strong>Mulai Kerjakan</strong>.</li>
            <li><strong>Reaksi UX Sistem:</strong> Aplikasi mendeteksi ini adalah ujian penting. UI aplikasi seketika berubah masuk ke dalam mode <strong>Safe Exam Browser (SEB)</strong>. Layar HP siswa akan dibekukan (<em>Locked Screen</em>), tombol kembali/Home dinonaktifkan, dan fungsi *Screenshot* dicekal oleh OS Android. Siswa baru bisa keluar aplikasi jika menekan tombol <strong>Selesai Ujian</strong>.</li>
            <li><strong>Kalkulasi:</strong> Sistem LMS otomatis memunculkan angka skor pilihan ganda ke layar HP siswa saat itu juga.</li>
        </ul>
    </li>
</ul>

<h3>4. Proses Hilir: E-Rapot (Penilaian Akhir)</h3>
<p>Siklus puncak di mana nilai KBM dan Ujian CBT dilebur menjadi satu dokumen sah.</p>
<ul>
    <li><strong>Tahap 1: Input Nilai Guru Mata Pelajaran</strong>
        <ul>
            <li><strong>Jejak UI (Guru):</strong> Web Backoffice &rarr; Sidebar <code>Jurnal & E-Rapot</code> &rarr; <code>E-Rapot</code>.</li>
            <li><strong>Aksi UX:</strong> Guru berhadapan dengan UI <em>Grid</em> panjang (seperti <em>Spreadsheet Excel</em>). Berkat fitur <em>Inline Editing</em>, Guru tinggal klik kotak kosong dan mengetikkan angka. Jika Guru mengetik angka 55 (di bawah KKM), kotak tersebut seketika berubah menjadi <strong>MERAH</strong> sebagai peringatan otomatis (*Auto-Formatting*).</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Validasi & Penguncian (Locking)</strong>
        <ul>
            <li><strong>Jejak UI (Kepala Sekolah):</strong> Masuk ke menu E-Rapot yang sama.</li>
            <li><strong>Aksi UX:</strong> Kepala Sekolah mengecek rekapitulasi. Jika sudah *Final*, ia menekan ikon tombol <strong>Gembok (Lock)</strong>. UX merespon dengan men-<em>disable</em> (membuat warna abu-abu) seluruh kotak inputan tadi agar nilai tidak bisa lagi dimodifikasi secara diam-diam.</li>
        </ul>
    </li>
    <li><strong>Tahap 3: Panen Ijazah PDF</strong>
        <ul>
            <li><strong>Aksi UX:</strong> Admin menekan <strong>"Generate Ijazah"</strong>. Di latar belakang sistem (<em>Background Worker</em>), puluhan file PDF dibuat massal dan indikator *Progress Bar* (0% - 100%) berjalan di layar Admin. Setelah 100%, file-file PDF Ijazah ini langsung muncul dan bisa diunduh dari Aplikasi Mobile Orang Tua.</li>
        </ul>
    </li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan SOP Proses Bisnis LMSALAZHARAPPS')],
            [
                'title' => 'Panduan SOP Proses Bisnis (UI/UX Lengkap) - LMSALAZHARAPPS',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

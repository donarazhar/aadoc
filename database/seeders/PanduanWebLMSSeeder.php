<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWebLMSSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Pengguna (User Manual)')],
            [
                'name' => 'Panduan Pengguna (User Manual)'
            ]
        );

        $content = <<<HTML
<p>Panduan ini ditujukan bagi <strong>Tenaga Pendidik (Guru)</strong> untuk mengoperasikan fungsi *Learning Management System* (LMS), mengelola materi mengajar, dan membuat soal ujian melalui Backoffice Web.</p>

<h3>1. Mengakses Ruang Kelas Online (LMS)</h3>
<p>Setelah Admin Sekolah menugaskan Anda sebagai Guru Mata Pelajaran di kelas tertentu, kelas tersebut akan muncul di dasbor Anda.</p>
<ol>
    <li><em>Login</em> ke Portal <code>apps.alazhar.or.id</code> menggunakan akun Guru.</li>
    <li>Buka menu <strong>Akademik &gt; Ruang Mengajar (LMS)</strong>.</li>
    <li>Anda akan melihat kotak (Kartu) kelas yang Anda ajar (Contoh: "Matematika - 10 IPA 1"). Klik kotak tersebut untuk masuk ke detail kelas.</li>
</ol>

<h3>2. Unggah Materi dan Tugas (Assignments)</h3>
<p>Guru dapat menyisipkan bahan ajar agar siswa bisa membacanya dari HP sebelum masuk kelas tatap muka.</p>
<ul>
    <li><strong>Unggah Materi (PDF/Video):</strong> Di dalam detail kelas, buka tab <strong>Bahan Ajar</strong>. Klik "Tambah Materi". Anda bisa mengunggah dokumen (maks. 10 MB) atau cukup merekatkan (<em>paste</em>) URL *link* YouTube pembelajaran. Materi akan langsung tersinkronisasi ke aplikasi *mobile* siswa detik itu juga.</li>
    <li><strong>Memberikan Tugas:</strong> Buka tab <strong>Tugas & Kuis</strong>. Klik "Buat Tugas". Anda wajib mengisi Judul, Deskripsi Instruksi, dan <strong>Tenggat Waktu (Deadline)</strong>. Setelah tombol "Simpan & Publish" ditekan, tugas tidak bisa dikerjakan jika siswa terlambat mengumpulkannya.</li>
</ul>

<h3>3. Membuat Soal Ujian (CBT / Computer Based Test)</h3>
<p>LMSALAZHARAPPS memiliki bank soal (*Question Bank*) canggih untuk mempermudah ujian.</p>
<ol>
    <li>Buka menu <strong>LMS &gt; Bank Soal</strong>. Buat kumpulan soal baru. Anda bisa mengetik manual Pilihan Ganda / Esai, atau mengimpor cepat menggunakan *Template* Excel (Format yang sudah disediakan sistem).</li>
    <li>Jika soal mengandung rumus atau gambar, Anda bisa menyisipkan gambar (Image Upload) di dalam opsi jawaban.</li>
    <li>Setelah paket soal siap, kembali ke Ruang Kelas. Buka tab <strong>Tugas & Kuis</strong>, lalu klik "Buat Ujian Baru".</li>
    <li><strong>[PENTING] Pengaturan Keamanan:</strong> Pada pengaturan ujian, centang opsi <strong>"Gunakan Safe Exam Browser (SEB)"</strong> agar aplikasi Android siswa mengunci layarnya saat tes dimulai. Atur juga <em>Passcode</em> darurat (untuk berjaga-jaga jika ada siswa tidak sengaja keluar aplikasi).</li>
</ol>

<h3>4. Jurnal Mengajar dan Presensi Siswa</h3>
<p>Setiap selesai mengajar, Guru wajib mengisi Jurnal (Buku Harian Mengajar).</p>
<ul>
    <li>Pilih menu <strong>Kehadiran & Jurnal &gt; Jurnal Mengajar</strong>.</li>
    <li>Pilih Hari dan Kelas yang baru saja diajar. Tulis ringkasan topik ("Membahas Rumus Phytagoras").</li>
    <li>Di bawahnya, akan tampil daftar absensi (Hadir, Sakit, Izin, Alpha). Secara *default* semua siswa diset ke "Hadir". Cukup klik dan ubah status siswa yang tidak datang saja, lalu klik "Simpan Absensi".</li>
    <li>Data ini akan langsung terekap ke Laporan Bulanan Kepala Sekolah dan orang tua yang bersangkutan akan menerima notifikasi jika anaknya tertandai Alpha.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('6. [Web] Manajemen LMS & Input Nilai Jurnal (Guru)')],
            [
                'title' => '6. [Web] Manajemen LMS & Input Nilai Jurnal (Guru)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

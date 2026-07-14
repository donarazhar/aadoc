<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanMobileAkademikSeeder extends Seeder
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
<p>Panduan ini ditujukan khusus bagi <strong>Siswa</strong> untuk menggunakan fitur <em>Learning Management System</em> (LMS) ALAZHARAPPS, mengunduh materi belajar, serta melaksanakan Ujian *Online*.</p>

<h3>1. Mengakses Kelas dan Materi (e-Learning)</h3>
<p>Semua modul pembelajaran dan tugas yang diberikan guru dapat diakses langsung dari ponsel.</p>
<ol>
    <li>Buka aplikasi ALAZHARAPPS dan <em>login</em> menggunakan akun Siswa (NISN &amp; Kata Sandi yang diberikan Wali Kelas).</li>
    <li>Di beranda, ketuk menu <strong>Akademik</strong> atau <strong>Ruang Kelas (LMS)</strong>.</li>
    <li>Anda akan melihat daftar mata pelajaran (contoh: Matematika, Bahasa Inggris). Ketuk pelajaran yang sedang berlangsung.</li>
    <li>Pada halaman Mata Pelajaran, ketuk *tab* <strong>Materi</strong> untuk mengunduh modul PDF atau menonton tautan video YouTube yang disisipkan guru.</li>
    <li>Jika ada tugas, buka *tab* <strong>Tugas (Assignment)</strong>, baca instruksinya, lalu unggah file tugas Anda (foto buku catatan atau *file* dokumen) sebelum tenggat waktu (*Deadline*) habis.</li>
</ol>

<h3>2. Persiapan Ujian (CBT / Computer Based Test)</h3>
<p>Berbeda dengan tugas harian, Ujian Tengah Semester (UTS) atau Ujian Akhir (UAS) membutuhkan keamanan ekstra agar siswa fokus mengerjakan tes.</p>
<ol>
    <li>Untuk Ujian yang diwajibkan menggunakan sistem keamanan, Anda <strong>wajib</strong> mengunduh aplikasi terpisah bernama <strong>Safe Exam Browser (SEB) ALAZHARAPPS</strong> dari Play Store (khusus perangkat Android).</li>
    <li>Pastikan baterai ponsel terisi di atas 50% dan terhubung ke *Wi-Fi* sekolah atau kuota internet pribadi yang stabil.</li>
</ol>

<h3>3. Tata Cara Pelaksanaan Ujian (Saat Hari H)</h3>
<p>Ikuti langkah ini hanya saat pengawas/guru ujian sudah memberikan instruksi di kelas:</p>
<ol>
    <li>Buka aplikasi utama ALAZHARAPPS, masuk ke menu <strong>Ujian</strong>.</li>
    <li>Ketuk ujian yang berstatus <em>"Sedang Berlangsung"</em>.</li>
    <li>Sistem akan mendeteksi apakah Anda sudah memasang Safe Exam Browser. Jika sudah, Anda akan otomatis diarahkan masuk ke layar ujian. Layar ini akan **terkunci penuh** (*Kiosk Mode*).</li>
    <li><strong>PERHATIAN PENTING:</strong> Selama berada di layar ujian, dilarang menekan tombol *Home* di ponsel, dilarang membuka WhatsApp (meskipun ada notifikasi masuk), dan dilarang membagi layar (*Split Screen*).</li>
    <li>Jika sistem mendeteksi percobaan kecurangan di atas, layar ujian Anda akan <strong>Terblokir Otomatis</strong> dan Anda harus meminta *Passcode* buka kunci (Unblock Code) dari guru pengawas untuk bisa melanjutkan ujian.</li>
    <li>Setelah menjawab semua soal, ketuk tombol <strong>Selesaikan Ujian &amp; Kirim Jawaban</strong>.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('3. [Mobile] Cara Mengakses Kelas & Ujian LMS')],
            [
                'title' => '3. [Mobile] Cara Mengakses Kelas & Ujian LMS (Siswa)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

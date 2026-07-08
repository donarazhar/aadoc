<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class LmsMoodleTutorialCohortCourseArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori LMS ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('LMS')],
            [
                'name' => 'LMS',
                'description' => 'Dokumentasi terkait Learning Management System (LMS).',
                'order' => 10,
                'is_hidden' => false,
            ]
        );

        // Buat artikel Tutorial Cohort dan Course
        $title = 'Tutorial Cepat: Membuat Cohort dan Course';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Dalam ekosistem Moodle, <strong>Cohort</strong> dan <strong>Course</strong> adalah dua pilar penting untuk mengelola pengguna dan mata pelajaran secara terstruktur dan efisien. Berikut adalah panduan cepat untuk membuat dan menghubungkan keduanya.</p>
<hr>

<h3>1. Mengenal Beda Cohort dan Course</h3>
<ul>
    <li><strong>Cohort (Rombongan Belajar / Rombel):</strong> Kumpulan pengguna (biasanya siswa) yang dikelompokkan secara <em>system-wide</em> atau per kategori. Misalnya: Cohort "Kelas 1A - Angkatan 2026". Memasukkan siswa ke dalam Cohort memudahkan kita mendaftarkan (<em>enroll</em>) mereka ke banyak <em>Course</em> sekaligus secara otomatis.</li>
    <li><strong>Course (Mata Pelajaran):</strong> Ruang kelas digital tempat interaksi belajar mengajar terjadi (materi, tugas, kuis). Misalnya: Course "Matematika - Kelas 1", "Bahasa Indonesia - Kelas 1".</li>
</ul>
<hr>

<h3>2. Cara Membuat Cohort (Rombel)</h3>
<p><em>Langkah ini harus dilakukan oleh akun dengan hak akses <strong>Manager</strong> atau <strong>Administrator</strong>.</em></p>
<ol>
    <li>Masuk ke menu <strong>Site administration</strong> &rarr; <strong>Users</strong> &rarr; <strong>Accounts</strong> &rarr; <strong>Cohorts</strong>.</li>
    <li>Klik tombol <strong>Add new cohort</strong>.</li>
    <li>Isi detail Cohort:
        <ul>
            <li><strong>Name:</strong> Nama rombongan belajar (misal: <code>Kelas 1A 2026/2027</code>).</li>
            <li><strong>Context:</strong> Pilih di level mana cohort ini tersedia (Pilih <em>System</em> jika ingin tersedia di semua kategori, atau pilih kategori spesifik misal <code>SD Al Azhar</code>).</li>
            <li><strong>Cohort ID:</strong> (Opsional) Kode unik untuk sinkronisasi internal, misal: <code>1A-2627</code>.</li>
        </ul>
    </li>
    <li>Klik <strong>Save changes</strong>.</li>
    <li>Setelah Cohort dibuat, kembali ke daftar Cohort dan klik ikon <strong>Assign / People</strong> (gambar orang) pada baris Cohort tersebut untuk mulai memasukkan siswa. (<em>Cari nama siswa di kotak sebelah kanan, lalu klik tombol "Add" untuk memindahkannya ke kotak kiri</em>).</li>
</ol>
<hr>

<h3>3. Cara Membuat Course (Mata Pelajaran)</h3>
<p><em>Langkah ini juga umumnya dilakukan oleh <strong>Manager</strong>.</em></p>
<ol>
    <li>Masuk ke <strong>Site administration</strong> &rarr; <strong>Courses</strong> &rarr; <strong>Manage courses and categories</strong>.</li>
    <li>Pilih Kategori yang sesuai di panel kiri (misal: <code>Kelas 1</code>).</li>
    <li>Di panel kanan, klik tombol <strong>Create new course</strong>.</li>
    <li>Isi pengaturan dasar kelas:
        <ul>
            <li><strong>Course full name:</strong> Nama lengkap mata pelajaran (Misal: <code>Matematika - Kelas 1</code>).</li>
            <li><strong>Course short name:</strong> Nama pendek untuk navigasi dan <em>breadcrumb</em> (Misal: <code>MTK-1</code>).</li>
            <li><strong>Course format:</strong> Pilih <strong>Topics format</strong> (Format ini paling umum dan mudah diatur).</li>
        </ul>
    </li>
    <li>Gulir ke bawah dan klik <strong>Save and display</strong>.</li>
</ol>
<hr>

<h3>4. Menghubungkan Cohort ke dalam Course (Cohort Sync)</h3>
<p>Daripada mendaftarkan siswa satu per satu ke dalam sebuah kelas, sangat disarankan menggunakan metode Sinkronisasi Cohort (<em>Cohort Sync</em>).</p>
<ol>
    <li>Buka <em>Course</em> yang baru saja Anda buat.</li>
    <li>Di menu navigasi Course (biasanya di atas atau kiri), pilih tab <strong>Participants</strong>.</li>
    <li>Klik menu <em>dropdown</em> (atau ikon gir) lalu pilih <strong>Enrollment methods</strong>.</li>
    <li>Pada kolom <em>Add method</em>, pilih <strong>Cohort sync</strong>.</li>
    <li>Di bagian formulir yang muncul:
        <ul>
            <li><strong>Cohort:</strong> Cari dan pilih nama Cohort yang sudah kita buat sebelumnya (misal: <code>Kelas 1A 2026/2027</code>).</li>
            <li><strong>Assign role:</strong> Pastikan diatur sebagai <strong>Student</strong>.</li>
        </ul>
    </li>
    <li>Klik <strong>Add method</strong>.</li>
</ol>

<blockquote>
    <p><strong>Selesai!</strong> Sekarang semua siswa yang berada di dalam Cohort "Kelas 1A" secara otomatis sudah masuk dan terdaftar ke dalam Course "Matematika Kelas 1".</p>
    <p>Hebatnya lagi, jika besok ada siswa baru (mutasi) yang ditambahkan ke Cohort "Kelas 1A" dari menu <em>Site Administration</em>, siswa tersebut akan langsung otomatis terdaftar di semua Course yang terhubung dengan Cohort ini tanpa perlu kita masukkan manual ke tiap mata pelajaran!</p>
</blockquote>
',
                'is_published' => true,
                'order' => 3,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class LmsMoodleDasarArticleSeeder extends Seeder
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

        // Buat artikel Dasar-Dasar Moodle
        $title = 'Dasar-Dasar Moodle';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Membangun sebuah <em>Learning Management System</em> (LMS) memang terlihat kompleks pada awalnya, tetapi jika kita sudah memahami alur kerjanya, semuanya akan jauh lebih terstruktur.</p>
<p>Berikut adalah panduan singkat, praktis, dan terarah untuk mengelola Moodle, khususnya untuk studi kasus <strong>Sekolah Al Azhar Kelas 1</strong>.</p>
<hr>

<h3>1. Tugas dan Hak Akses (Role) di Moodle</h3>
<p>Moodle bekerja dengan sistem hierarki. Setiap orang memiliki porsi kerjanya masing-masing agar sistem tetap rapi dan aman.</p>
<ul>
    <li><strong>Manager (Pengelola/Admin Tingkat Atas):</strong> Ini adalah arsitek sistem. Tugas utamanya bukan mengajar, melainkan mengatur struktur sekolah secara digital. Manager bertugas membuat kategori (misal: "Kelas 1", "Kelas 2"), membuat <em>Course</em> (Mata Pelajaran), membuat akun pengguna, dan memasukkan Guru serta Siswa ke dalam kelas yang tepat.</li>
    <li><strong>Teacher (Guru):</strong> Ini adalah pemilik kelas. Setelah kelas disiapkan oleh Manager, Teacher bertugas mendesain isi kelas tersebut. Mereka mengunggah materi, membuat kuis, memberikan tugas, dan menilai hasil kerja siswa. Teacher tidak bisa mengubah pengaturan sistem di luar kelasnya.</li>
    <li><strong>Student (Siswa):</strong> Ini adalah peserta didik. Mereka hanya bisa melihat materi, mengunduh file, mengerjakan tugas, dan mengikuti ujian yang telah disiapkan oleh Teacher. Mereka tidak bisa mengubah struktur kelas.</li>
</ul>
<hr>

<h3>2. Langkah Pertama Memulai Moodle (Alur Kerja)</h3>
<p>Untuk memulai Moodle dari nol, pekerjaan harus selalu <strong>dimulai dari role Manager/Admin</strong> terlebih dahulu, baru kemudian diserahkan ke Teacher. Berikut adalah alur standarnya:</p>

<p><strong>Fase 1: Persiapan oleh Manager</strong></p>
<ol>
    <li><strong>Buat Kategori (Category):</strong> Buat kategori untuk merapikan struktur. Misalnya, buat kategori utama <code>SD Al Azhar</code>, lalu sub-kategori <code>Kelas 1</code>.</li>
    <li><strong>Buat Mata Pelajaran (Course):</strong> Di dalam sub-kategori <code>Kelas 1</code>, buat <em>course</em> untuk setiap pelajaran.
        <ul>
            <li><em>Course 1:</em> IPAS - Kelas 1</li>
            <li><em>Course 2:</em> Bahasa Indonesia - Kelas 1</li>
            <li><em>Course 3:</em> Matematika - Kelas 1</li>
        </ul>
    </li>
    <li><strong>Buat Akun (User Management):</strong> Buat akun untuk semua guru yang akan mengajar dan semua siswa kelas 1. (Biasanya dilakukan secara massal menggunakan file CSV).</li>
    <li><strong>Daftarkan Pengguna (Enrollment):</strong> Masukkan guru dan siswa ke dalam kelas masing-masing. Tetapkan siapa yang menjadi <em>Teacher</em> dan siapa yang menjadi <em>Student</em> di kelas Matematika, IPAS, dsb.</li>
</ol>

<p><strong>Fase 2: Eksekusi oleh Teacher</strong></p>
<ol>
    <li><strong>Login sebagai Teacher:</strong> Guru masuk ke mata pelajaran yang sudah ditugaskan kepada mereka.</li>
    <li><strong>Membangun Kelas:</strong> Guru menyalakan mode <em>Turn Editing On</em> dan mulai menyusun materi dari Bab 1 hingga selesai.</li>
</ol>
<hr>

<h3>3. Fitur Dasar untuk Minimal Standar LMS</h3>
<p>Untuk siswa Kelas 1, tampilan dan interaksi harus dibuat sesederhana mungkin. Berikut adalah fitur-fitur dasar (Resources &amp; Activities) yang wajib dikuasai oleh <em>Teacher</em> agar LMS bisa berjalan:</p>
<ul>
    <li><strong>Course Format (Format Kelas):</strong> Gunakan <strong>Topics format</strong>. Ubah nama setiap topik menjadi nama bab atau minggu pelajaran (Misal: <em>Topik 1 &rarr; Bab 1: Mengenal Angka</em>, <em>Topik 2 &rarr; Bab 2: Penjumlahan</em>).</li>
    <li><strong>Label:</strong> Fitur ini bertindak seperti judul atau papan pengumuman di dalam kelas. Gunakan Label untuk memberikan instruksi singkat yang bisa langsung dibaca siswa (atau orang tua yang mendampingi) tanpa harus di-klik.</li>
    <li><strong>File:</strong> Gunakan ini untuk mengunggah bahan ajar mandiri, seperti dokumen PDF ringkasan materi atau slide presentasi.</li>
    <li><strong>URL:</strong> Sangat berguna jika Anda memiliki materi berupa video pembelajaran di YouTube atau artikel dari website luar. Fitur ini akan mengarahkan siswa langsung ke materi tersebut.</li>
    <li><strong>Assignment (Tugas):</strong> Tempat bagi siswa untuk mengumpulkan PR. Untuk anak Kelas 1, biasanya guru akan meminta orang tua untuk memfoto lembar kerja anak, lalu foto tersebut diunggah <em>(upload)</em> melalui fitur Assignment ini.</li>
    <li><strong>Quiz (Kuis):</strong> Digunakan untuk ulangan atau latihan soal. Anda bisa mengatur soal pilihan ganda atau mencocokkan gambar, yang sistemnya bisa langsung menilai otomatis secara seketika (<em>auto-grading</em>).</li>
</ul>

<p>Dengan menguasai langkah-langkah dan fitur di atas, Anda sudah memiliki fondasi yang sangat kuat untuk menjalankan LMS Sekolah Al Azhar.</p>
',
                'is_published' => true,
                'order' => 2,
            ]
        );
    }
}

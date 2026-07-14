<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisArsitekturLMSSeeder extends Seeder
{
    public function run(): void
    {
        // Get Admin User dynamically
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        // Kategori Baru: LMS Deep-Dive
        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('LMS Deep-Dive')],
            [
                'name' => 'LMS Deep-Dive',
                'description' => 'Dokumentasi komprehensif mengenai ekosistem Learning Management System',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini membedah arsitektur dan pola integrasi dari sistem manajemen pembelajaran (LMSALAZHARAPPS), yang merupakan subsistem vital pendamping aplikasi utama ALAZHARAPPS.</p>

<h3>1. Pemetaan Microservices LMS</h3>
<p>Berbeda dengan sistem finansial atau pendaftaran, LMS dipecah menjadi beberapa layanan khusus untuk menangani interaksi belajar-mengajar dengan *traffic* sangat tinggi:</p>
<ul>
    <li><strong><code>course-service</code>:</strong> Otak utama LMS. Layanan ini mengelola pembuatan Kelas Online (Course), Modul Pembelajaran, Tugas (Assignment), Ujian (Quiz/Exam), serta penilaian otomatis.</li>
    <li><strong><code>jurnal-service</code>:</strong> Menangani absensi harian dan pencatatan Jurnal Mengajar Guru. Sangat penting untuk audit kinerja tenaga pendidik.</li>
    <li><strong><code>lms-mobile</code> &amp; <code>mobile</code>:</strong> Klien antarmuka berbasis *mobile* (Android/iOS) yang dirancang agar siswa dapat mengakses materi belajar dan mengikuti kuis langsung dari ponsel cerdas mereka.</li>
    <li><strong><code>safeexam-browser-android</code>:</strong> Integrasi keamanan tingkat tinggi. Aplikasi atau modul ini memastikan bahwa ketika siswa sedang melaksanakan ujian (*Computer Based Test* / CBT), mereka tidak bisa membuka aplikasi lain (seperti *browser* Google, ChatGPT, atau WhatsApp) untuk mencegah kecurangan.</li>
</ul>

<h3>2. Integrasi Data dengan ALAZHARAPPS Utama</h3>
<p>Bagaimana LMS tahu bahwa Siswa A berada di Kelas 10A dan berhak mengakses materi Matematika? LMS tidak menyimpan data master siswa.</p>
<ul>
    <li><strong>Synchronous Fetching (gRPC):</strong> Saat LMS butuh memvalidasi identitas, <code>course-service</code> melakukan panggilan gRPC ke <code>student-service</code> (yang berada di ekosistem ALAZHARAPPS).</li>
    <li><strong>Data Caching (Redis):</strong> Karena memanggil gRPC jutaan kali per jam (saat ribuan siswa ujian) akan membuat <code>student-service</code> pingsan, LMS menggunakan Redis. Profil siswa, nama kelas, dan jadwal mata pelajaran akan di-*cache* (disimpan sementara) di Redis milik LMS selama beberapa jam.</li>
    <li><strong>Keamanan Lintas Ekosistem:</strong> LMS bergantung pada <code>jwtaccess</code> dan token otorisasi yang diterbitkan oleh <code>account-service</code>. Tidak ada pendaftaran akun terpisah untuk LMS (Single Sign-On).</li>
</ul>

<h3>3. Skalabilitas &amp; Tantangan Performa</h3>
<p>Sistem pendidikan memiliki lonjakan pengunjung ekstrem di jam tertentu (misal: pukul 07.00 - 09.00 saat ujian serentak atau presensi masuk). </p>
<p><strong>[TIP] Skenario Optimasi:</strong> Karena LMSALAZHARAPPS menghadapi pola beban (*workload*) *spiky* ini, sangat krusial bagi tim DevOps untuk mengonfigurasi *Horizontal Pod Autoscaler* (HPA) jika menggunakan Kubernetes. Saat ujian massal dimulai, <code>course-service</code> harus bisa otomatis menggandakan diri dari 2 kontainer menjadi 10 kontainer dalam hitungan detik untuk mencegah server *down*.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('1. Bedah Arsitektur Ekosistem LMS')],
            [
                'title' => '1. Bedah Arsitektur Ekosistem LMS',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

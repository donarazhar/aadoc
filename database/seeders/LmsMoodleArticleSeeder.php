<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class LmsMoodleArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat kategori LMS
        $category = Category::updateOrCreate(
            ['slug' => Str::slug('LMS')],
            [
                'name' => 'LMS',
                'description' => 'Dokumentasi terkait Learning Management System (LMS).',
                'order' => 10,
                'is_hidden' => false,
            ]
        );

        // Buat artikel LMS berbasis Moodle
        $title = 'LMS berbasis Moodle';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p><strong>Apa itu Moodle?</strong></p>
<p>Moodle (<em>Modular Object-Oriented Dynamic Learning Environment</em>) adalah sebuah platform <em>Learning Management System</em> (LMS) berbasis <em>open-source</em> yang dirancang untuk menyediakan lingkungan belajar yang disesuaikan, aman, dan terintegrasi bagi pengajar, administrator, dan pembelajar.</p>

<p><strong>Fitur Utama LMS Moodle:</strong></p>
<ul>
    <li><strong>Manajemen Kursus:</strong> Pengajar dapat dengan mudah membuat kursus, mengatur pendaftaran siswa, dan memonitor perkembangan belajar.</li>
    <li><strong>Aktivitas Interaktif:</strong> Moodle mendukung berbagai modul aktivitas seperti kuis, tugas, forum diskusi, glossary, dan wiki untuk mendukung pembelajaran yang dinamis.</li>
    <li><strong>Sistem Penilaian (Grading):</strong> Terdapat fitur buku nilai yang komprehensif, memungkinkan penilaian otomatis untuk kuis dan rubrik penilaian untuk tugas esai atau proyek.</li>
    <li><strong>Kolaborasi:</strong> Siswa dan guru dapat berkolaborasi melalui pesan, forum, dan kelompok belajar.</li>
    <li><strong>Kustomisasi &amp; Fleksibilitas:</strong> Karena sifatnya yang <em>open-source</em>, Moodle dapat disesuaikan menggunakan plugin untuk menambahkan fitur seperti video conference, analitik, dan integrasi dengan sistem pihak ketiga.</li>
</ul>

<p><strong>Keunggulan Penggunaan Moodle:</strong></p>
<p>Moodle banyak digunakan oleh institusi pendidikan dari sekolah dasar hingga perguruan tinggi karena skalabilitasnya. Platform ini memungkinkan pembelajaran campuran (<em>blended learning</em>) serta pembelajaran jarak jauh 100% (<em>e-learning</em>).</p>

<p>Dalam ekosistem aplikasi sekolah, Moodle sering kali diintegrasikan dengan Sistem Informasi Sekolah (SIS) sehingga data pengguna (guru dan siswa), kelas, dan jadwal dapat disinkronisasi secara otomatis.</p>
',
                'is_published' => true,
                'order' => 1,
            ]
        );
    }
}

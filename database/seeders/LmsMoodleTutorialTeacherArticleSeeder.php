<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class LmsMoodleTutorialTeacherArticleSeeder extends Seeder
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

        // Buat artikel Tutorial Memasukkan Materi Pelajaran (Role Teacher)
        $title = 'Tutorial Cepat: Memasukkan Materi Pelajaran (Role Teacher)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Setelah administrator atau <em>Manager</em> selesai mendaftarkan Anda ke dalam sebuah <em>Course</em> (Mata Pelajaran), kini saatnya Anda sebagai <strong>Teacher</strong> (Guru) mengambil alih kendali kelas tersebut. Moodle memberikan kebebasan penuh kepada Teacher untuk mendesain kelasnya sendiri.</p>
<hr>

<h3>1. Menghidupkan Mode Edit (Turn Editing On)</h3>
<p>Langkah paling krusial sebelum Anda bisa menambahkan teks, tugas, atau materi apa pun di dalam kelas Moodle adalah menghidupkan fitur edit.</p>
<ol>
    <li>Login menggunakan akun Guru (<em>Teacher</em>).</li>
    <li>Dari halaman <strong>Dashboard</strong>, cari dan klik mata pelajaran yang Anda ampu (Misal: <code>Matematika - Kelas 1</code>).</li>
    <li>Perhatikan di pojok kanan atas halaman, klik tombol <strong>Turn editing on</strong> (biasanya berwarna biru atau hijau).</li>
    <li>Setelah mode ini aktif, Anda akan menyadari perubahan di layar: muncul banyak ikon pensil, ikon panah (untuk menggeser), dan tulisan <em><strong>+ Add an activity or resource</strong></em> di setiap blok topik.</li>
</ol>
<hr>

<h3>2. Mengubah Nama Topik (Bab Pembelajaran)</h3>
<p>Jika <em>Course</em> Anda menggunakan <em>Topics format</em> (standar), sangat disarankan untuk mengubah tulisan "Topic 1", "Topic 2", menjadi nama bab atau minggu pertemuan agar siswa lebih mudah memahaminya.</p>
<ol>
    <li>Klik ikon pensil kecil tepat di sebelah tulisan "Topic 1".</li>
    <li>Ketik nama bab yang baru (Misalnya: <code>Bab 1 - Penjumlahan Angka 1 sampai 10</code>).</li>
    <li>Tekan tombol <strong>Enter</strong> di keyboard Anda untuk menyimpan.</li>
</ol>
<hr>

<h3>3. Menambahkan Materi Berupa Dokumen / File (PDF, PPT, Word)</h3>
<p>Sangat mudah untuk membagikan bahan bacaan mandiri atau <i>slide</i> presentasi kepada siswa Anda.</p>
<ol>
    <li>Pilih di bawah topik/bab mana Anda ingin meletakkan materinya, lalu klik <strong>+ Add an activity or resource</strong>.</li>
    <li>Akan muncul jendela <em>pop-up</em>. Pilih tab <strong>Resources</strong>, lalu cari dan klik <strong>File</strong>.</li>
    <li>Di formulir yang terbuka, isi kolom nama (Misal: <code>Materi PPT: Penjumlahan Dasar</code>).</li>
    <li>Pada kotak <em>Select files</em>, Anda bisa memindahkan dokumen dari komputer Anda secara langsung dengan cara menyeret (<em>drag-and-drop</em>) file tersebut ke area yang ditandai panah biru menghadap ke bawah.</li>
    <li>Gulir layar ke bawah, dan klik <strong>Save and return to course</strong>.</li>
</ol>
<hr>

<h3>4. Menambahkan Label (Instruksi Langsung Tampil)</h3>
<p>Label berfungsi untuk menampilkan teks, gambar, atau panduan yang <strong>langsung terlihat</strong> di halaman depan kelas tanpa harus di-klik oleh siswa. Fitur ini sangat cocok diterapkan untuk mengarahkan anak kelas 1 (dan orang tuanya).</p>
<ol>
    <li>Klik <strong>+ Add an activity or resource</strong> di topik yang diinginkan.</li>
    <li>Pilih <strong>Label</strong>.</li>
    <li>Di kolom teks (teks editor yang besar), tuliskan instruksi Anda. Contoh:
        <blockquote><em>"Anak-anak hebat, silakan unduh dan pelajari materi presentasi di bawah ini bersama Ayah dan Bunda ya!"</em></blockquote>
    </li>
    <li>(Opsional) Anda juga bisa menebalkan huruf atau menyisipkan gambar kecil melalui ikon-ikon di atas kotak teks tersebut.</li>
    <li>Klik <strong>Save and return to course</strong>.</li>
</ol>
<hr>

<h3>5. Menambahkan Tautan Eksternal (URL YouTube / Website)</h3>
<p>Jika Anda memiliki referensi video pembelajaran interaktif dari YouTube atau materi bacaan dari portal edukasi lain:</p>
<ol>
    <li>Klik <strong>+ Add an activity or resource</strong>.</li>
    <li>Pilih <strong>URL</strong>.</li>
    <li>Isi nama tautan (Misal: <code>Video Animasi Penjumlahan</code>).</li>
    <li>Tempel (<em>paste</em>) alamat URL YouTube tersebut di kolom <strong>External URL</strong>.</li>
    <li>(Sangat Disarankan) Pada bagian pengaturan <strong>Appearance</strong>, ubah kolom <em>Display</em> menjadi <strong>Embed</strong>. Dengan fitur ini, video akan langsung bisa diputar di dalam Moodle tanpa "membuang" siswa keluar menuju situs YouTube.</li>
    <li>Klik <strong>Save and return to course</strong>.</li>
</ol>

<p>Dengan menguasai tiga fitur dasar di atas (<em>File</em>, <em>Label</em>, dan <em>URL</em>), kelas digital Anda di Moodle kini sudah sangat siap digunakan untuk mendukung proses belajar mengajar harian!</p>
',
                'is_published' => true,
                'order' => 4,
            ]
        );
    }
}

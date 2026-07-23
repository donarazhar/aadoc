<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class SetupManajemenUnitSekolahSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat kategori baru khusus untuk Setup Manajemen Unit Sekolah
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Manajemen Unit Sekolah Role Administrator')],
            [
                'name' => 'Setup Manajemen Unit Sekolah Role Administrator',
                'description' => 'Panduan tahap kedua terkait pengelolaan unit sekolah dan rombongan belajar oleh Administrator.'
            ]
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        // 2. Konten Artikel Panduan
        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Manajemen Unit Sekolah (Tahap 2)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Setelah konfigurasi Master Data selesai (Tahap 1), alur kerja (<em>workflow</em>) administrator berlanjut ke <strong>Tahap 2: Manajemen Unit Sekolah</strong>. Pada tahap ini, Anda bertugas untuk mendefinisikan seluruh unit-unit sekolah (cabang) yang berada di bawah naungan Yayasan Pesantren Islam (YPI) Al-Azhar, beserta pembagian ruang kelas riil (rombongan belajar) di dalamnya.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Tujuan Utama:</strong> Membangun struktur hierarki cabang sekolah di dalam sistem agar seluruh transaksi, pendaftaran, dan kegiatan akademik dapat terpetakan dengan akurat ke masing-masing unit/gedung sekolah yang dituju.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah 1: Setup Profil Sekolah</h3>
        <p style="margin-bottom: 1rem;">Menu pertama yang harus Anda kelola adalah pendaftaran setiap unit sekolah secara fisik.</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Akses Menu:</strong> Buka menu <strong>Sekolah &gt; Profil Sekolah</strong> dari layar admin utama.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tambah Unit Sekolah:</strong> Masukkan data profil lengkap untuk masing-masing cabang. Contoh: <em>SDIA 1</em>, <em>SMPIA 2</em>, atau <em>SMAIA 3</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tautkan Jenjang Pendidikan:</strong> Pastikan Anda memilih Jenjang Pendidikan yang tepat untuk unit tersebut (Misal: TK, SD, SMP, atau SMA). Sistem akan menggunakan jenjang ini untuk menampilkan pilihan otomatis pada menu-menu yang lain.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Identitas Resmi:</strong> Lengkapi juga nomor pokok statistik sekolah (NPSN), nama kepala sekolah, alamat, serta detail kontak agar profil sekolah valid secara administrasi.
            </li>
        </ol>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah 2: Pembuatan Rombel (Rombongan Belajar)</h3>
        <p style="margin-bottom: 1rem;">Setelah unit sekolah berdiri di dalam sistem, sekolah tersebut tentu membutuhkan ruang-ruang kelas fisik (Rombel) untuk menampung murid.</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Akses Menu:</strong> Buka menu <strong>Sekolah &gt; Rombel</strong>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Definisikan Ruang Kelas Riil:</strong> Jika di Master Data Anda hanya membuat nama kelas umum (seperti "Kelas 1"), di menu Rombel ini Anda memecahnya menjadi ruang kelas nyata (Misalnya: <em>Kelas 1A</em>, <em>Kelas 1B</em>, <em>Kelas 1 Makkah</em>, atau <em>Kelas 1 Madinah</em>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tautkan ke Tahun Ajaran:</strong> Rombongan belajar sangat bergantung pada masa berlaku. Pastikan Anda menautkan Rombel yang dibuat dengan <strong>Tahun Ajaran</strong> yang sedang berjalan. Dengan begitu, sistem tahu bahwa "Kelas 1A" ini adalah rombongan untuk angkatan tahun ajaran tersebut.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kapasitas Kelas (Wali Kelas):</strong> Tentukan juga batas maksimal siswa (kapasitas ruangan) dan tunjuk guru atau staf yang bertanggung jawab sebagai Wali Kelas untuk rombongan belajar tersebut.
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem; margin-top: 2rem;">
            <strong>Penting:</strong> Tanpa adanya unit sekolah yang didaftarkan, Anda tidak akan bisa melanjutkan ke modul Penerimaan Murid Baru (PMB). Dan tanpa adanya Rombel, murid yang sudah lulus pendaftaran nantinya tidak akan bisa ditempatkan ke dalam kelas manapun. Lakukan kedua hal ini secara berurutan!
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Manajemen Unit Sekolah')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Workflow Manajemen Unit Sekolah',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 17,
            ]
        );
    }
}

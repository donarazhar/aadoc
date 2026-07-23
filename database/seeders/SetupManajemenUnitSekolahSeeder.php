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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Workflow Manajemen Unit Sekolah Role Administrator</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selamat datang di <strong>Tahap 2: Manajemen Unit Sekolah</strong>. Setelah Anda menyelesaikan konfigurasi Master Data, tahap krusial selanjutnya bagi seorang Administrator adalah mendefinisikan infrastruktur dan hierarki cabang sekolah di dalam sistem.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama Workflow Ini:</strong> Membangun struktur hierarki cabang sekolah agar seluruh transaksi pendaftaran (PMB) dan kegiatan akademik (seperti pembagian kelas) dapat terpetakan dengan akurat ke masing-masing unit atau gedung sekolah yang dituju.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Apa Saja yang Perlu Dilakukan?</h3>
        <p style="margin-bottom: 1rem;">Dalam workflow ini, ada 2 (dua) entitas utama yang wajib Anda kelola secara berurutan:</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Mendaftarkan Profil Unit Sekolah</strong><br>
                Anda harus mendaftarkan setiap unit sekolah fisik (cabang) yang ada di bawah naungan yayasan (Misalnya: TKIA 1, SDIA 1, SMPIA 2). Data ini sangat penting karena mencakup identitas resmi (NPSN, dsb), penanggung jawab (Kepala Sekolah), dan lokasi fisik.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Membentuk Rombongan Belajar (Rombel)</strong><br>
                Setelah unit sekolah dibuat, Anda harus memecah kelas umum menjadi ruangan-ruangan kelas yang nyata (Misalnya: Kelas 1A, Kelas 1B) untuk menampung murid, dan menautkannya dengan Tahun Ajaran yang berlaku.<br><br>
                
                <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem; margin-top: 0.5rem; border-radius: 0.25rem;">
                    <strong>Penting: Perbedaan Hierarki Rombel (Pusat vs Sekolah)</strong><br>
                    Secara arsitektur sistem, Rombel wajib terikat pada satu Unit Sekolah spesifik. Oleh karena itu, terdapat perbedaan tampilan dan fungsi menu Rombel berdasarkan hak akses Anda:
                    <ul style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                        <li><strong>Menu Rombel Sekolah (Admin Sekolah)</strong>: Menampilkan langsung daftar Rombel (contoh: 1A, 1B). Tombol "Tambah" di sini otomatis menautkan Rombel baru ke unit sekolah milik admin yang login.</li>
                        <li><strong>Menu Rombel Pusat (Admin Pusat)</strong>: Menampilkan daftar Unit Sekolah (bukan Rombel). Untuk melihat Rombel, Anda harus mengklik salah satu Sekolah terlebih dahulu.</li>
                    </ul>
                    <em>Catatan Keamanan:</em> Jika Anda login sebagai <strong>Pusat</strong> dan mencoba mengklik tombol Tambah di halaman Rombel Sekolah, sistem akan secara otomatis mengarahkan Anda (<em>redirect</em>) ke form penambahan Pusat. Proteksi rute (berdasarkan <code>role_id</code>) ini mencegah Admin Pusat membuat Rombel "menggantung" tanpa unit sekolah, menjaga integritas struktur data.
                </div>
            </li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 2rem; border-radius: 0.25rem;">
            <strong>Panduan Teknis Pengisian Form:</strong><br>
            Artikel ini hanya memberikan gambaran umum (<em>overview</em>) dari alur kerja Anda. Untuk mengetahui tata cara atau <em>step-by-step</em> pengisian (<em>input</em>) datanya di dalam sistem, <strong>silakan baca artikel panduan terpisah</strong> untuk masing-masing formulir (misalnya: artikel <em>"Panduan Menambahkan Profil Sekolah"</em>).
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

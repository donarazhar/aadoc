<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahProgramSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada
        $category = Category::firstOrCreate(
            ['slug' => 'setup-panduan'],
            ['name' => 'Setup & Panduan', 'description' => 'Panduan instalasi dan setup lokal aplikasi']
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Program</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini akan memandu Anda untuk menambahkan Program Pembelajaran (contoh: <em>Reguler, Bilingual, Tahfidz, Akselerasi</em>). Di sistem Al Azhar Apps, proses penambahan program dibagi menjadi dua tahap yang dilakukan oleh dua peran berbeda: <strong>Admin Pusat</strong> dan <strong>Admin Sekolah</strong>.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Konsep Dasar:</strong> Admin Pusat bertugas membuat daftar "Master Program" secara global. Setelah itu, Admin Sekolah bertugas memilih dan mendaftarkan program tersebut agar aktif di unit sekolahnya masing-masing.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian 1: Untuk Administrator Pusat</h4>
        <p>Jika Anda login sebagai Administrator Pusat, tugas Anda adalah membuat "Master Data Program".</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Pada menu sidebar, navigasi ke <strong>Master Data &gt; Program</strong> (Rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/program</code>).</li>
            <li>Klik tombol <strong>Tambah Data</strong>.</li>
            <li>Anda akan diarahkan ke halaman <em>Tambah Program</em>. Di sini, Anda hanya akan melihat satu kolom input:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                    <li><strong>Nama Program:</strong> Ketikkan nama program yang berlaku di Yayasan (Contoh: "Bilingual" atau "Tahfidz").</li>
                </ul>
            </li>
            <li>Klik tombol <strong>Simpan</strong>. Sekarang program tersebut sudah tersedia di database pusat dan siap dipilih oleh sekolah-sekolah.</li>
        </ol>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian 2: Untuk Admin Sekolah</h4>
        <p>Jika Anda login sebagai Admin Sekolah (misal: Admin SDIA 1), tugas Anda adalah mengaktifkan program yang sudah dibuat pusat agar tersedia di sekolah Anda.</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Pada menu sidebar, navigasi ke <strong>Sekolah &gt; Program</strong>.</li>
            <li>Klik tombol <strong>Tambah Data</strong>.</li>
            <li>Pada halaman formulir penambahan program, Anda akan melihat tiga kolom:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                    <li><strong>Sekolah (Terisi Otomatis/Disabled):</strong> Akan langsung menampilkan nama unit sekolah Anda (misal: SDIA 1).</li>
                    <li><strong>Jenjang (Terisi Otomatis/Disabled):</strong> Akan langsung mengikuti jenjang sekolah Anda (misal: SD).</li>
                    <li><strong>Nama Program (Dropdown):</strong> Klik dan pilih program dari daftar <em>Master Program</em> yang telah dibuat oleh Admin Pusat sebelumnya.</li>
                </ul>
            </li>
            <li>Klik tombol <strong>Simpan</strong>. Program tersebut kini telah aktif di sekolah Anda, dan siap digunakan pada saat pembuatan Rombel ataupun penentuan Biaya SPP.</li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan:</strong> Jika Admin Sekolah tidak menemukan nama program di pilihan dropdown, harap hubungi Administrator Pusat agar dibuatkan terlebih dahulu Master Datanya.
        </div>
        </div>
        ';

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Menambahkan Program',
            'slug' => Str::slug('Panduan Menambahkan Program'),
            'content' => trim($htmlContent),
            'is_published' => true,
            'created_by' => $userId,
            'order' => 5,
        ]);
    }
}

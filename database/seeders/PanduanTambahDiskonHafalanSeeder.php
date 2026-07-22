<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonHafalanSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Hafalan Al-Quran</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini berisi panduan langkah demi langkah untuk mendaftarkan skema <strong>Diskon Hafalan Al-Quran</strong> pada aplikasi Al Azhar Apps. Modul ini digunakan untuk memberikan potongan biaya pendidikan sebagai bentuk apresiasi kepada calon murid berdasarkan jumlah juz hafalan Al-Quran yang mereka kuasai.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Skema Diskon:</strong> Skema ini memungkinkan sekolah untuk menyimpan persentase potongan tagihan khusus bagi murid berprestasi dalam bidang tahfidz Al-Quran. Sistem akan secara otomatis menghitung ulang tagihan berdasarkan diskon yang aktif.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Diskon Hafalan</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Pada menu sidebar sebelah kiri, masuk ke <strong>Master Data &gt; Diskon &gt; Hafalan Al-Quran</strong> (Rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/hafalan-alquran/add</code>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                Klik tombol <strong>Tambah Data</strong> yang terletak di sudut kanan atas halaman untuk membuka formulir pendataan diskon.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Pengisian Formulir:</strong> Isi seluruh kolom formulir sesuai dengan kebijakan keringanan biaya di sekolah Anda:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li style="margin-bottom: 0.4rem;"><strong>Jumlah Hafalan (Wajib):</strong> Masukkan nama atau kategori target jumlah juz. <em>(Contoh: "Hafal 5 Juz", "Hafal 10 Juz", atau "Hafal 30 Juz (Hafidz)")</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Besaran Potongan (%) (Wajib):</strong> Masukkan angka (persentase) diskon yang akan diberikan jika murid mencapai target hafalan ini. <em>(Contoh: Cukup ketik "50" untuk potongan 50%, atau "100" untuk potongan 100%. Jangan tambahkan simbol persen secara manual)</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Status (Dropdown):</strong> Pilih status aktifitas skema diskon ini <em>(Aktif / Tidak Aktif)</em>. Jika statusnya Tidak Aktif, diskon tidak akan dapat digunakan oleh panitia PPDB.</li>
                </ul>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Konfirmasi dan Simpan:</strong> Setelah semua data dipastikan kebenarannya, klik tombol <strong>Simpan</strong>. Pada modal konfirmasi pop-up yang muncul, klik tombol setuju.
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Jika sekolah Anda tidak memiliki atau belum menerapkan kebijakan potongan untuk program hafalan Al-Quran/Tahfidz, Anda dapat mengabaikan langkah-langkah di atas karena pengisian master diskon ini bersifat opsional.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Hafalan Al-Quran')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Hafalan Al-Quran',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 9,
            ]
        );
    }
}

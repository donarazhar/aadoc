<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonRaportSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Nilai Raport</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini berisi panduan langkah demi langkah untuk mendaftarkan skema <strong>Diskon Nilai Raport</strong> pada aplikasi Al Azhar Apps. Fitur ini digunakan untuk memberikan apresiasi berupa potongan biaya bagi calon murid atau murid yang memiliki pencapaian nilai raport akademik yang sangat baik (sesuai standar passing grade).</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Skema Diskon:</strong> Skema ini memungkinkan sekolah untuk memberikan potongan biaya (dalam persentase) bagi pendaftar yang memenuhi kriteria nilai raport tertentu secara spesifik per jenjang sekolah.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Diskon Raport</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Pada menu sidebar sebelah kiri, masuk ke <strong>Master Data &gt; Diskon &gt; Diskon Prestasi Raport</strong> (Rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/diskon-raport/add</code>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                Klik tombol <strong>Tambah Data</strong> untuk membuka formulir pembuatan diskon raport baru.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Pengisian Formulir:</strong> Isi seluruh bidang formulir sesuai dengan ketentuan diskon yang berlaku:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li style="margin-bottom: 0.4rem;"><strong>Nama Kategori Diskon (Wajib):</strong> Masukkan nama kategori potongan nilai raport. <em>(Contoh: "Diskon Nilai Rata-Rata &gt; 90", "Beasiswa Prestasi Akademik")</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Jenjang (Dropdown):</strong> Pilih jenjang pendidikan (TK, SD, SMP, atau SMA) yang berhak menerima skema diskon ini.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Besaran Potongan (%):</strong> Masukkan persentase potongan yang akan diberikan. <em>(Contoh: Masukkan angka "15" untuk potongan 15% dari total biaya yang disyaratkan)</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Status (Dropdown):</strong> Pilih status aktifitas skema diskon ini <em>(Aktif / Non-Aktif)</em>.</li>
                </ul>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Konfirmasi dan Simpan:</strong> Setelah semua data dipastikan benar, klik tombol <strong>Simpan</strong>. Pada modal konfirmasi yang muncul, klik <strong>Ya, Simpan</strong>.
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Diskon yang sudah ditambahkan akan langsung bisa diterapkan saat admin memverifikasi nilai raport pendaftar, atau saat melakukan validasi pembayaran PMB bagi calon murid yang memenuhi syarat passing grade.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Nilai Raport')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Nilai Raport',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 8,
            ]
        );
    }
}

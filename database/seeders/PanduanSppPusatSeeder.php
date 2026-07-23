<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSppPusatSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Keuangan dan Tagihan Inti Administrator')],
            [
                'name' => 'Setup Keuangan & Tagihan Inti Administrator',
                'description' => 'Panduan tahap keempat terkait konfigurasi keuangan dan tagihan pokok oleh Administrator.'
            ]
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Uang Sekolah Pusat (Master SPP)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Administrator Pusat dalam mengatur nominal dasar (master) untuk Uang Sekolah (SPP) secara global berdasarkan jenjang pendidikan. Pengaturan ini dilakukan melalui menu <strong>Administrasi &gt; Biaya &gt; Uang Sekolah</strong> pada tab Pusat.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah Konfigurasi Uang Sekolah Pusat:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Navigasi ke menu <strong>Administrasi &gt; Biaya &gt; Uang Sekolah</strong> lalu pilih tab <strong>admin/spp/pusat</strong>.</li>
            <li>Klik tombol <strong>Tambah Uang Sekolah</strong>.</li>
            <li><strong>Jenjang:</strong> Pilih jenjang pendidikan (TK, SD, SMP, atau SMA). Nominal yang Anda masukkan di sini akan menjadi standar untuk seluruh cabang di jenjang tersebut.</li>
            <li><strong>Program:</strong> Tentukan program (Reguler, Bilingual, dsb.) karena program yang berbeda mungkin memiliki nominal SPP yang berbeda pula.</li>
            <li><strong>Tahun Ajaran:</strong> Pilih Tahun Ajaran yang berlaku untuk master SPP ini.</li>
            <li><strong>Nominal SPP:</strong> Masukkan besaran uang SPP bulanan (misal: 1000000).</li>
            <li>Klik tombol <strong>Simpan</strong>.</li>
        </ol>

        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Langkah Penting Berikutnya:</strong> Setelah nominal master tersimpan, Anda dapat menggunakan tombol <strong>Generate SPP</strong> pada baris data tersebut untuk secara otomatis menurunkan/menerapkan tagihan ini ke unit sekolah-sekolah di bawahnya.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Uang Sekolah Pusat')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Uang Sekolah (Pusat)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 26,
            ]
        );
    }
}

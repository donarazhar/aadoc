<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class DashboardArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari atau buat kategori "Dashboard"
        $category = Category::firstOrCreate(
            ['slug' => 'dashboard'],
            [
                'name' => 'Dashboard',
                'description' => 'Kategori khusus untuk tampilan halaman depan atau dashboard publik.',
                'order' => 1,
            ]
        );

        // Konten artikel berbasis layout inline styles agar tahan terhadap Tailwind purge
        // dan tampil sempurna baik di public portal maupun TinyMCE.
        $htmlContent = <<<HTML
<div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; padding: 1rem 0; margin-bottom: 2rem; font-family: sans-serif;">
    
    <!-- Kiri: Teks & Info -->
    <div style="flex: 1 1 50%; min-width: 300px; padding-right: 2rem;">
        <span style="color: #1885C4; font-weight: bold; font-size: 1.25rem; display: block; margin-bottom: 0.5rem;">#OnePlatformAllSolutions</span>
        <h2 style="font-size: 2.75rem; font-weight: 800; margin-top: 0; margin-bottom: 1.5rem; line-height: 1.2; color: #0f172a;">
            Semua Kebutuhan Sekolah<br>
            <span style="color: #1885C4;">dalam Satu Aplikasi</span>
        </h2>
        <p style="font-size: 1.125rem; color: #475569; margin-bottom: 1.5rem; line-height: 1.6;">
            Pantau perkembangan anak, cek tagihan sekolah, menerima pengumuman, melihat jadwal pelajaran, hingga berkomunikasi dengan sekolah langsung dari smartphone Anda.
        </p>
        <p style="font-size: 1.125rem; color: #475569; margin-bottom: 2.5rem; line-height: 1.6; font-weight: 500;">
            Download sekarang dan nikmati kemudahan layanan sekolah dalam genggaman.
        </p>
        
        <div style="display: flex; gap: 1.5rem; align-items: center;">
            <!-- Tempat QR Code -->
            <div style="width: 120px; height: 120px; background: white; border: 2px solid #e2e8f0; display: flex; align-items: center; justify-content: center; border-radius: 1rem; color: #94a3b8; font-size: 0.875rem; text-align: center; box-shadow: inset 0 2px 4px 0 rgba(0,0,0,0.06);">
                [Ganti dg<br>Gambar QR]
            </div>
            
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="background: black; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-align: center; font-weight: bold; font-size: 0.875rem;">
                    Google Play
                </div>
                <div style="background: black; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-align: center; font-weight: bold; font-size: 0.875rem;">
                    App Store
                </div>
            </div>
        </div>
    </div>
    
    <!-- Kanan: Hero Image Placeholder -->
    <div style="flex: 1 1 40%; min-width: 300px; display: flex; justify-content: flex-end; margin-top: 2rem;">
        <div style="width: 100%; max-width: 350px; background: #e0f2fe; border-radius: 1.5rem; overflow: hidden; border: 8px solid white; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); display: flex; align-items: center; justify-content: center;">
            <p style="padding: 2rem; text-align: center; color: #64748b; font-size: 0.875rem; margin: 0;">Ganti teks ini dengan <b>Gambar Kedua</b> via TinyMCE. (Gambar akan otomatis pas dengan bingkai)</p>
        </div>
    </div>
</div>
HTML;

        Document::updateOrCreate(
            ['slug' => 'promo-all-in-one'],
            [
                'title' => 'One Platform, All Solutions',
                'category_id' => $category->id,
                'content' => $htmlContent,
                'is_published' => true,
                'created_by' => 1,
                'order' => 1,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class GettingStartedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Category
        $category = Category::firstOrCreate(
            ['slug' => 'getting-started'],
            [
                'name' => 'Getting Started',
                'description' => 'Panduan awal penggunaan Al Azhar Apps',
                'order' => 1,
                'is_hidden' => false,
            ]
        );

        // 2. Create Article Content (HTML/Prose format)
        $content = <<<HTML
<p>Aplikasi Al Azhar Apps dirancang untuk memudahkan seluruh civitas akademika dalam mengakses informasi dan layanan sekolah secara praktis dari genggaman Anda.</p>

<h3>Cara Mengunduh Aplikasi</h3>
<p>Anda dapat mengunduh aplikasi Al Azhar Apps secara gratis melalui toko aplikasi resmi sesuai dengan perangkat yang Anda gunakan:</p>

<ul>
    <li><strong>Untuk Pengguna Android:</strong><br>
    Silakan kunjungi Google Play Store atau klik tautan berikut:<br>
    <a href="https://play.google.com/store/apps/details?id=com.alazhar.alazharapps" target="_blank">Unduh Al Azhar Apps di Google Play Store</a>
    </li>
    <li><strong>Untuk Pengguna iOS (iPhone/iPad):</strong><br>
    Silakan kunjungi Apple App Store dan cari "Al Azhar Apps" (atau klik tautan yang tersedia di portal resmi kami).
    </li>
</ul>

<h3>Spesifikasi Minimal Perangkat (HP)</h3>
<p>Agar aplikasi Al Azhar Apps dapat berjalan dengan lancar dan optimal, pastikan perangkat Anda memenuhi spesifikasi minimal berikut:</p>

<ul>
    <li><strong>Sistem Operasi Android:</strong> Minimal Android 8.0 (Oreo) atau yang lebih baru.</li>
    <li><strong>Sistem Operasi iOS:</strong> Minimal iOS 12.0 atau yang lebih baru.</li>
    <li><strong>RAM:</strong> Minimal 2 GB (Disarankan 3 GB atau lebih untuk performa terbaik).</li>
    <li><strong>Penyimpanan Internal:</strong> Ruang kosong minimal 100 MB.</li>
    <li><strong>Koneksi Internet:</strong> Stabil (3G/4G/5G atau Wi-Fi) untuk sinkronisasi data yang realtime.</li>
</ul>

<p>Jika perangkat Anda memenuhi persyaratan di atas, Anda siap untuk menginstal dan menggunakan aplikasi Al Azhar Apps tanpa hambatan.</p>
HTML;

        // 3. Create Document
        Document::updateOrCreate(
            ['slug' => 'instalasi-mobile-app'],
            [
                'category_id' => $category->id,
                'title' => 'Instalasi Mobile App',
                'content' => $content,
                'is_published' => true,
                'created_by' => 1, // Assuming user 1 is the admin
                'order' => 1,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class GettingStartedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Admin User
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id ?? 1;

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

        // 3. Create Document: Instalasi Mobile App
        Document::updateOrCreate(
            ['slug' => 'instalasi-mobile-app'],
            [
                'category_id' => $category->id,
                'title' => 'Instalasi Mobile App',
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 1,
            ]
        );

        // 4. Create Article Content: Akses Halaman Backoffice
        $backofficeContent = <<<HTML
<p>Sistem Back Office Al Azhar Apps (One Platform, All Solutions) digunakan oleh pengelola, guru, dan staf administrasi untuk mengelola data sekolah secara terpusat.</p>

<h3>Cara Mengakses dan Login ke Backoffice</h3>
<ol>
    <li>
        <strong>Buka Tautan:</strong><br>
        Silakan buka peramban (browser) Anda seperti Google Chrome, Safari, atau Firefox, kemudian akses tautan berikut:<br>
        <a href="https://apps.alazhar.or.id/" target="_blank"><strong>https://apps.alazhar.or.id/</strong></a>
    </li>
    <li>
        <strong>Masukkan Kredensial:</strong><br>
        Pada halaman login utama, silakan masukkan <strong>Username</strong> atau <strong>Email</strong> yang telah didaftarkan pada kolom pertama.
    </li>
    <li>
        <strong>Masukkan Kata Sandi:</strong><br>
        Masukkan <strong>Password</strong> Anda pada kolom kedua. Pastikan kombinasi huruf besar, kecil, dan angka sudah benar.
    </li>
    <li>
        <strong>Verifikasi Keamanan (reCAPTCHA):</strong><br>
        Centang kotak yang bertuliskan <em>"I'm not a robot"</em> untuk verifikasi keamanan.
    </li>
    <li>
        <strong>Masuk ke Sistem:</strong><br>
        Klik tombol biru <strong>Login</strong> untuk masuk ke dalam dasbor sistem Back Office.
    </li>
</ol>

<p><em>Catatan: Jika Anda melupakan kata sandi Anda, klik tautan "Lupa password?" di bawah tombol Login untuk melakukan pengaturan ulang kata sandi.</em></p>
HTML;

        // 5. Create Document: Akses Halaman Backoffice
        Document::updateOrCreate(
            ['slug' => 'akses-halaman-backoffice'],
            [
                'category_id' => $category->id,
                'title' => 'Akses Halaman Backoffice',
                'content' => $backofficeContent,
                'is_published' => true,
                'created_by' => $adminId, // Assuming user 1 is the admin
                'order' => 2,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get or Create Category
        $category = Category::firstOrCreate(
            ['slug' => 'ui-ux'],
            [
                'name' => 'UI/UX',
                'description' => 'Dokumentasi antarmuka dan pengalaman pengguna Al-Azhar Apps.',
            ]
        );

        // 2. Get the first user or default to 1
        $user = \App\Models\User::first();
        $userId = $user ? $user->id : 1;

        // 3. Create Document
        Document::updateOrCreate(
            ['slug' => 'menu-akun-dan-pengaturan'],
            [
                'category_id' => $category->id,
                'title' => 'Menu Akun & Pengaturan Aplikasi',
                'content' => '
<p>Menu <strong>Akun</strong> merupakan pusat kontrol profil dan pengaturan preferensi pengguna pada aplikasi Al-Azhar Apps. Halaman ini didesain secara bersih dan terstruktur menjadi beberapa blok kartu (card) untuk memudahkan navigasi.</p>

<hr>

<h3>1. Kartu Profil Pengguna (Profile Card)</h3>
<p>Bagian teratas halaman menampilkan kartu profil berwarna biru khas Al-Azhar. Di dalam kartu ini, terdapat informasi utama pengguna:</p>
<ul>
    <li><strong>Nama Pengguna:</strong> Menampilkan nama lengkap pemilik akun (contoh: Donar Azhar).</li>
    <li><strong>Nomor Telepon:</strong> Menampilkan nomor HP yang terdaftar beserta kode negara (+62).</li>
    <li><strong>Alamat Email:</strong> Menampilkan email yang digunakan untuk mendaftar.</li>
</ul>

<h3>2. Bagian Pengaturan (Settings)</h3>
<p>Blok ini berisi berbagai menu untuk memodifikasi pengaturan keamanan dan data akun:</p>
<ul>
    <li><strong>Akun:</strong> Menu untuk memperbarui nomor telepon dan alamat email pengguna.</li>
    <li><strong>Ganti PIN:</strong> Menu untuk mengubah PIN (Personal Identification Number) guna menjaga keamanan transaksi dan akses aplikasi.</li>
    <li><strong>Login Biometrik:</strong> Sebuah tombol geser (<em>toggle</em>) yang memungkinkan pengguna untuk masuk (login) menggunakan sidik jari (<em>fingerprint</em>) atau pemindaian wajah (<em>Face ID</em>).</li>
    <li><strong>Auto Update:</strong> Tombol geser (<em>toggle</em>) untuk mengaktifkan pembaruan otomatis saat membuka aplikasi.</li>
    <li><strong>Notifikasi:</strong> Pengaturan untuk mengaktifkan atau menonaktifkan notifikasi (pemberitahuan) dari aplikasi.</li>
    <li><strong>Akses Lokasi:</strong> Pengaturan untuk memberikan izin akses pelacakan lokasi.</li>
</ul>

<h3>3. Bantuan &amp; Dukungan</h3>
<p>Blok ini menyediakan akses ke informasi layanan pelanggan dan kebijakan legal:</p>
<ul>
    <li><strong>Bantuan:</strong> Mengarahkan pengguna ke halaman FAQ (Tanya Jawab) atau layanan dukungan teknis jika mengalami kendala.</li>
    <li><strong>Kebijakan Privasi:</strong> Menampilkan halaman ketentuan penggunaan aplikasi dan kebijakan privasi data pengguna.</li>
</ul>

<h3>4. Informasi Aplikasi &amp; Tombol Keluar</h3>
<p>Bagian paling bawah halaman memberikan informasi teknis serta opsi untuk mengakhiri sesi:</p>
<ul>
    <li><strong>Informasi Aplikasi:</strong> Menampilkan versi aplikasi saat ini (contoh: Versi 3.15.40) dan nama Developer (YPI Al Azhar).</li>
    <li><strong>Tombol Keluar (Logout):</strong> Tombol berukuran besar berwarna merah pekat yang diletakkan di bawah (<em>sticky/bottom</em>). Warna merah digunakan sebagai peringatan visual bahwa ini adalah aksi destruktif (mengakhiri sesi dan keluar dari aplikasi).</li>
</ul>
                ',
                'is_published' => true,
                'created_by' => $userId,
            ]
        );
    }
}

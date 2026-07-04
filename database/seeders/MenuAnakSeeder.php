<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;

class MenuAnakSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'ui-ux-mobile-app'],
            [
                'name' => 'UI/UX Mobile App',
                'description' => 'Penjelasan antarmuka, fitur, dan panduan penggunaan halaman pada mobile app Al Azhar Apps untuk orang tua murid.',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        $user = User::first();
        $userId = $user ? $user->id : 1;

        $content = <<<HTML
<p>Menu <strong>Anak</strong> (dapat diakses dari panel navigasi bawah) merupakan ruang dasbor utama tempat orang tua dapat memantau seluruh aktivitas, perkembangan akademik, dan administrasi putra-putrinya secara terpusat.</p>

<h3>1. Skenario Pengguna Baru (Belum Memiliki Anak Terdaftar)</h3>
<p>Bagi orang tua yang baru pertama kali menggunakan aplikasi dan belum pernah mendaftarkan anaknya ke sekolah Al Azhar, halaman Menu Anak ini akan terlihat kosong. Layar akan menampilkan ilustrasi keluarga dengan pesan <em>"Belum Ada Anak yang Terdaftar"</em>.</p>
<p>Pada kondisi ini, Menu Anak bertindak sebagai jalan pintas. Anda cukup menekan tombol biru <strong>Daftar Sekarang</strong>, dan sistem akan langsung mengarahkan Anda ke halaman formulir <strong>Pendaftaran Murid Baru (PMB)</strong>.</p>

<h3>2. Skenario Pengguna Lama (Anak Sudah Terdaftar)</h3>
<p>Setelah proses pendaftaran (PMB) berhasil diselesaikan dan status anak sudah resmi diterima, halaman Menu Anak ini akan berubah fungsinya menjadi "Ruang Pantau Utama". Di halaman ini nantinya Anda akan dapat melihat:</p>
<ul>
    <li>Profil Siswa dan detail akademik anak.</li>
    <li>Pemantauan nilai, kehadiran, dan aktivitas harian di sekolah.</li>
    <li>Riwayat tagihan dan jadwal yang spesifik untuk anak tersebut.</li>
</ul>
<p><em>(Catatan: Apabila Anda ingin mendaftarkan anak kedua/adiknya, Anda bisa langsung menggunakan menu ikon <strong>PMB</strong> yang ada di halaman Beranda Utama).</em></p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'menu-anak-dan-pmb'], // Retain the same slug to cleanly overwrite the previous article
            [
                'category_id' => $category->id,
                'title' => 'Mengenal Menu Anak (Pemantauan Profil Siswa)',
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 4,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PerbedaanKelasDanRombelSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada untuk menghindari error foreign key
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Perbedaan Master Kelas dan Master Rombel</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Salah satu pertanyaan yang sering diajukan oleh Administrator adalah: <em>"Mengapa pada menu Master Data Kelas (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/kelas</code>) tidak terdapat tombol Tambah Data?"</em> Artikel ini akan menjelaskan logika arsitektur di balik hal tersebut dan bagaimana cara yang benar untuk membuat kelas di aplikasi Al Azhar Apps.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">1. Master Data Kelas (Referensi Baku)</h4>
        <p>Alasan utama mengapa tombol <strong>Tambah Data</strong> tidak tersedia di menu Master Data Kelas adalah karena data yang berada di halaman tersebut berfungsi sebagai <strong>Tingkat/Jenjang Pendidikan Baku Nasional</strong> (contoh: <em>TK A, TK B, Kelas 1, Kelas 2, ... hingga Kelas 12</em>).</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Data ini merupakan <strong>Master Referensi Statis</strong> yang telah dimasukkan (di-<em>seed</em>) secara bawaan oleh pengembang ke dalam database.</li>
            <li>Sistem sengaja mengunci fitur Tambah atau Hapus di halaman ini guna <strong>mencegah <em>human error</em></strong>. </li>
            <li>Sebagai ilustrasi: Jika administrator tidak sengaja menghapus referensi "Kelas 1", hal ini berpotensi menyebabkan kerusakan masif (error) pada seluruh data murid, pencatatan rapor, dan siklus tagihan SPP yang terhubung dengan jenjang Kelas 1.</li>
        </ul>

        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Singkatnya:</strong> Master Kelas bertindak sebatas <em>Label Jenjang/Tingkat</em> yang menjadi patokan untuk sistem.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">2. Cara Menambahkan Kelas Fisik (Rombongan Belajar)</h4>
        <p>Lalu, di mana Anda membuat pembagian kelas yang sebenarnya untuk menempatkan murid-murid (contoh: <em>Kelas 1A, 7 Ibnu Sina, 10 MIPA 1</em>)? Pembuatan kelas tersebut dilakukan di menu <strong>Master Rombel (Rombongan Belajar)</strong>.</p>
        
        <p>Ikuti panduan berikut untuk membuat rombongan belajar yang baru:</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Pada sidebar navigasi, buka menu <strong>Sekolah &gt; Rombel</strong>.</li>
            <li>Anda akan diarahkan ke halaman Rombel (rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/rombel/pusat</code> atau <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">/sekolah</code>).</li>
            <li>Di halaman ini, Anda akan melihat dan dapat mengklik tombol <strong>Tambah Data</strong>.</li>
            <li>Saat formulir penambahan Rombel terbuka, Anda harus melengkapi beberapa komponen data berikut:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                    <li><strong>Nama Rombel:</strong> Tuliskan nama ruangan/kelas spesifik tersebut (Contoh: "1A" atau "10 MIPA 1").</li>
                    <li><strong>Unit Sekolah:</strong> Pilih ke unit sekolah mana rombel ini bernaung (Contoh: "SDIA 1").</li>
                    <li><strong>Tingkat Kelas:</strong> Di sinilah relasinya terbentuk! Pilih referensi jenjang dari <em>Master Data Kelas</em> yang statis tadi (Misalnya: Pilih "Kelas 10").</li>
                    <li><strong>Wali Kelas:</strong> Tetapkan nama guru yang akan bertugas membina rombel tersebut.</li>
                </ul>
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Kesimpulan:</strong> Untuk penamaan fisik ruang kelas yang spesifik, gunakan menu <strong>Rombel</strong>. Sedangkan menu <strong>Master Kelas</strong> tidak perlu dimodifikasi karena hanya berisi standarisasi tingkatan pendidikan (Grade).
        </div>
        </div>
        ';

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Perbedaan Master Kelas dan Rombel',
            'slug' => Str::slug('Perbedaan Master Kelas dan Rombel'),
            'content' => trim($htmlContent),
            'is_published' => true,
            'created_by' => $userId,
            'order' => 4,
        ]);
    }
}

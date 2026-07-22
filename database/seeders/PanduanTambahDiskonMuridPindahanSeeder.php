<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonMuridPindahanSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Murid Pindahan</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam membuat konfigurasi <strong>Diskon Murid Pindahan</strong>. Diskon ini diberikan secara khusus kepada calon murid baru yang mendaftar sebagai murid pindahan (pindahan dari sekolah lain) ke lingkungan perguruan Al-Azhar, guna memberikan keringanan pada biaya pendaftaran atau uang pangkal awal.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Memberikan potongan biaya pendaftaran / uang pangkal khusus untuk kategori Murid Pindahan dengan nominal Rupiah (Rp) yang dapat disesuaikan berdasarkan program pendidikan yang tersedia.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Diskon Murid Pindahan</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Dari layar admin Anda, silakan akses <strong>Master Data &gt; Diskon &gt; Murid Pindahan</strong>. Kemudian klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau Anda dapat langsung mengakses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/murid-pindahan/add</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Nama Sekolah (Pencarian Otomatis - Wajib):</strong> 
                Ketik nama sekolah tujuan tempat murid tersebut mendaftar pindah. Sistem akan secara dinamis mencari nama sekolah dari <em>database</em>. Klik nama sekolah yang tepat dari <em>dropdown</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Kelas (Otomatis/Manual):</strong> 
                <ul>
                    <li>Jika sekolah yang Anda pilih adalah jenjang <strong>Toddler / TK</strong>, maka kolom ini akan aktif berupa <em>Dropdown</em> sehingga Anda bisa memilih kelas secara spesifik.</li>
                    <li>Jika sekolah yang Anda pilih berada pada jenjang <strong>SD, SMP, atau SMA</strong>, maka kolom ini akan otomatis terkunci (<em>disabled</em>) dan akan diisi secara otomatis oleh sistem (misalnya: Kelas 1, Kelas 7, Kelas 10).</li>
                </ul>
                <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Mengapa Form Terlihat Kosong?</strong><br>
                    Jika Anda melihat dropdown <strong>Nama Sekolah</strong> kosong, Anda <strong>wajib mengetik huruf/nama sekolahnya terlebih dahulu</strong> untuk memicu pencarian. Sedangkan untuk form <strong>Kelas</strong>, form ini baru akan terbuka/terisi otomatis <strong>setelah</strong> Anda memilih Nama Sekolah.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Status (Dropdown):</strong> 
                Atur status diskon ini menjadi <strong>Aktif</strong> agar dapat segera digunakan saat transaksi pendaftaran, atau <strong>Tidak Aktif</strong> jika belum diberlakukan.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tabel Besaran Potongan Per Program (Dinamis):</strong><br>
                Setelah data Sekolah dan Kelas terlengkapi, sebuah tabel akan otomatis muncul di bagian bawah form yang memuat daftar Program Pendidikan (seperti Reguler, Bilingual, dsb) untuk sekolah tersebut.
                <ul>
                    <li>Isikan nominal potongan dalam bentuk Rupiah (Rp) pada masing-masing program di kolom <strong>Besaran Potongan</strong>.</li>
                    <li><em>Contoh: Ketik "1500000" untuk potongan Rp 1.500.000 pada program Reguler.</em></li>
                </ul>
                <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Kenapa Tabel Program Tidak Muncul?</strong><br>
                    Jika setelah Anda memilih Nama Sekolah dan Kelas tabel program di bawahnya <strong>tidak muncul sama sekali</strong>, itu berarti Administrator belum memetakan program pendidikan ke sekolah tersebut. Sistem mewajibkan sekolah memiliki setidaknya satu program agar form diskon ini bisa diakses dan disimpan.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan Data:</strong> 
                Setelah memastikan semua nominal potongan telah sesuai, klik tombol <strong>Simpan</strong> di bagian terbawah layar, lalu konfirmasi dengan menekan "Ya, Simpan".
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Tips Integrasi:</strong> Pastikan Anda telah mengisi besaran nominal potongan pada setiap baris program yang muncul di tabel. Jika ada program yang tidak mendapat diskon murid pindahan, Anda bisa mengisi angka "0" agar data tetap bisa tersimpan tanpa <em>error</em>.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Murid Pindahan')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Murid Pindahan',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 14,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonLulusanYPISeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Lulusan YPI Al-Azhar</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam membuat konfigurasi <strong>Diskon Lulusan Yayasan Pesantren Islam (YPI) Al-Azhar</strong>. Diskon ini diberikan kepada calon murid baru yang sebelumnya telah bersekolah (lulusan) dari lembaga pendidikan di bawah naungan YPI Al-Azhar, guna memberikan *benefit* loyalitas dalam meneruskan pendidikannya ke jenjang yang lebih tinggi.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Memberikan potongan biaya pendaftaran / uang pangkal dengan nominal Rupiah (Rp) yang dapat disesuaikan per program (Bilingual, Akselerasi, Reguler, dll).
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Diskon Lulusan YPI</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Dari layar admin Anda, silakan akses <strong>Master Data &gt; Diskon &gt; Lulusan YPI</strong>. Kemudian klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau Anda dapat langsung mengakses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/lulusan-ypi/add</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Nama Sekolah (Pencarian Otomatis - Wajib):</strong> 
                Ketik nama sekolah tujuan (sekolah yang saat ini akan didaftar oleh murid tersebut). Sistem akan secara dinamis (async) mencari nama sekolah tersebut dari *database*. Klik nama sekolah yang tepat dari *dropdown*.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Kelas (Otomatis/Manual):</strong> 
                <ul>
                    <li>Jika sekolah yang Anda pilih adalah jenjang <strong>Toddler / TK (Jenjang 1)</strong>, maka kolom ini akan aktif berupa <em>Dropdown</em> sehingga Anda bisa memilih kelas secara spesifik.</li>
                    <li>Jika sekolah yang Anda pilih berada pada jenjang selain Toddler (SD, SMP, SMA), maka kolom ini akan otomatis terkunci (*disabled*) dan akan diisi secara otomatis oleh sistem menyesuaikan sekolahnya.</li>
                </ul>
                <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Mengapa Form Terlihat Kosong?</strong><br>
                    Jika Anda melihat dropdown <strong>Nama Sekolah</strong> kosong, itu adalah hal yang wajar. Anda <strong>wajib mengetik huruf/nama sekolahnya terlebih dahulu</strong> untuk memicu pencarian ke server. Sedangkan untuk form <strong>Kelas</strong>, form ini baru akan terbuka/terisi otomatis <strong>setelah</strong> Anda memilih Nama Sekolah.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Status (Dropdown):</strong> 
                Atur status diskon ini menjadi <strong>Aktif</strong> agar dapat segera digunakan, atau <strong>Tidak Aktif</strong> jika sekadar menyusun draf kebijakan baru.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tabel Besaran Potongan Per Program (Dinamis):</strong><br>
                Setelah Anda melengkapi data Sekolah dan Kelas di atas, sebuah tabel akan otomatis muncul di bagian bawah form. Tabel ini memuat daftar Program Pendidikan yang tersedia (Reguler, Bilingual, Akselerasi, dsb).
                <ul>
                    <li>Isikan nominal potongan dalam bentuk Rupiah (Rp) pada masing-masing program tersebut di kolom <strong>Besaran Potongan</strong>.</li>
                    <li><em>Contoh: Ketik "2000000" untuk potongan Rp 2.000.000 pada program Reguler.</em></li>
                </ul>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan Data:</strong> 
                Setelah memastikan semua isian tabel potongan telah sesuai, klik tombol <strong>Simpan</strong> di bagian terbawah layar, kemudian konfirmasi dengan menekan "Ya, Simpan".
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Tips Integrasi:</strong> Pastikan Anda telah mengisi besaran nominal potongan pada setiap baris program yang muncul di tabel secara lengkap. Jika ada program yang tidak mendapat diskon, Anda bisa mengisi angka "0".
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Lulusan YPI')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Lulusan YPI',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 13,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahSumberInformasiSeeder extends Seeder
{
    public function run()
    {
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Master Sumber Informasi</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam menambahkan data <strong>Sumber Informasi</strong> ke dalam sistem. Data ini digunakan saat calon murid baru melakukan pendaftaran, di mana mereka akan ditanya dari mana mereka mengetahui informasi tentang sekolah Al-Azhar (contoh: Brosur, Instagram, Referensi Teman, dsb).</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Memberikan opsi pilihan "Sumber Informasi" pada form pendaftaran murid (PMB), yang nantinya berguna bagi sekolah untuk keperluan analisis efektivitas marketing dan promosi.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Dari layar admin Anda, silakan akses menu <strong>Master Data &gt; Sumber Informasi</strong>. Kemudian klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau Anda dapat langsung mengakses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/sumber-informasi/add-sumber-informasi</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Nama Sumber Informasi:</strong> 
                Ketik nama platform, media, atau sumber promosinya (Misalnya: <em>"Brosur"</em>, <em>"Instagram"</em>, <em>"Website Al-Azhar"</em>, atau <em>"Alumni"</em>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Nama Sekolah (Pencarian Otomatis):</strong> 
                Cari dan pilih nama sekolah tempat sumber informasi ini berlaku. Sistem akan menyesuaikan agar pilihan sumber informasi tersebut hanya muncul saat murid mendaftar ke sekolah yang Anda tuju.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Status (Dropdown):</strong> 
                Atur statusnya menjadi <strong>Aktif</strong> agar segera bisa digunakan pada form pendaftaran, atau <strong>Tidak Aktif</strong> jika media promosi tersebut sudah tidak relevan/digunakan lagi.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan Data:</strong> 
                Setelah memastikan isian sudah benar, klik tombol <strong>Simpan</strong> di bagian bawah layar. Data akan langsung tersimpan dan tersedia untuk digunakan di seluruh modul terkait!
            </li>
        </ol>

        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Master Sumber Informasi')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Master Sumber Informasi',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 16,
            ]
        );
    }
}

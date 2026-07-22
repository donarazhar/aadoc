<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonAnakPegawaiSPPSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon SPP Anak Pegawai</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam menambahkan skema <strong>Diskon SPP bulanan khusus untuk Anak Pegawai</strong> pada aplikasi Al Azhar Apps. Fitur ini dirancang untuk mengakomodasi pemotongan biaya pendidikan rutin (SPP bulanan) bagi putra-putri pegawai internal berdasarkan level jabatan orang tuanya di sekolah.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Memberikan potongan Sumbangan Pembinaan Pendidikan (SPP) dalam bentuk persentase (%). Khusus untuk SPP, modul ini juga mengizinkan penambahan biaya lain secara tunai (Rupiah) jika diperlukan.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Diskon SPP Anak Pegawai</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Buka menu <strong>Master Data &gt; Diskon &gt; Anak Pegawai & Pengurus</strong>. Arahkan tab navigasi ke <strong>SPP (Bulanan)</strong>, lalu klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Rute akses: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/anak-pegawai/add?type=spp</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Jabatan Pegawai (Dropdown - Wajib):</strong> 
                Pilih salah satu jabatan struktural dari daftar (misal: "Guru", "Staf", dsb.) yang akan menerima fasilitas potongan SPP ini.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Besaran Potongan (%) (Wajib):</strong> 
                Tentukan persentase potongan SPP yang akan diberikan setiap bulannya. <em>(Contoh: Ketik "100" jika SPP digratiskan sepenuhnya untuk jabatan ini).</em> Jangan menambahkan simbol "%".
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tambahan Biaya Lainnya (Rp) (Wajib):</strong> 
                Jika pada tagihan SPP bulanan ini terdapat biaya tambahan di luar komponen SPP yang harus tetap dibayar (seperti kas/infak khusus), masukkan nominal Rupiah pada kolom ini. Ketik "0" (Nol) jika tidak ada biaya tambahan apapun.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Status (Dropdown):</strong> 
                Tentukan apakah diskon ini <strong>Aktif</strong> atau <strong>Tidak Aktif</strong>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan:</strong> 
                Setelah mengisi form dengan benar, klik tombol <strong>Simpan</strong>, lalu klik konfirmasi pada layar peringatan pop-up yang muncul.
            </li>
        </ol>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Anak Pegawai (SPP)')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Anak Pegawai (SPP)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 12,
            ]
        );
    }
}

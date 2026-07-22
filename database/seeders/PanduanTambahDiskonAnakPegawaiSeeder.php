<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonAnakPegawaiSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon DSP Anak Pegawai</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam menambahkan skema <strong>Diskon DSP (Dana Sumbangan Pendidikan / Uang Pangkal) khusus untuk Anak Pegawai</strong> pada aplikasi Al Azhar Apps. Fitur ini dirancang khusus untuk mengakomodasi kebijakan kesejahteraan pegawai berupa potongan biaya pendaftaran bagi putra-putri mereka.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Memberikan potongan DSP/Uang Pangkal yang dikalkulasikan dalam bentuk persentase (%). Diskon ini membedakan besaran potongannya secara dinamis berdasarkan <em>jabatan (level)</em> dari pegawai tersebut.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Diskon Anak Pegawai</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi:</strong> Silakan buka menu <strong>Master Data &gt; Diskon &gt; Anak Pegawai & Pengurus</strong>. Pastikan Anda berada pada tab <strong>DSP (Uang Pangkal)</strong>, lalu klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau akses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/anak-pegawai/add?type=dsp</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Jabatan Pegawai (Dropdown):</strong> 
                Pilih jabatan struktural dari pegawai yang akan menerima diskon. Misalnya: "Guru", "Kepala Sekolah", atau "Staf Administrasi". <em>(Daftar jabatan ini diambil dari data Master Jabatan).</em>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Besaran Potongan (%) (Wajib):</strong> 
                Masukkan angka persentase diskon Uang Pangkal yang diberikan untuk jabatan tersebut. <br>
                <em>(Contoh: Ketik "50" jika jabatan tersebut mendapatkan potongan 50% dari Uang Pangkal). Jangan menambahkan simbol "%" secara manual.</em>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Status (Dropdown):</strong> 
                Pilih <strong>Aktif</strong> jika kebijakan diskon untuk jabatan ini sudah mulai berlaku. Pilih <strong>Tidak Aktif</strong> jika belum diberlakukan.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan Data:</strong> 
                Setelah memastikan data sesuai, klik tombol <strong>Simpan</strong> di pojok bawah. Anda akan melihat jendela <em>pop-up</em> peringatan konfirmasi, klik "Ya, Simpan" untuk menyimpan ke dalam *database*.
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan SPP vs DSP:</strong> Panduan ini khusus untuk penambahan diskon bertipe DSP (Dana Sumbangan Pendidikan). Apabila Anda berada di layar pengisian SPP (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">type=spp</code>), akan muncul tambahan kolom <strong>Tambahan Biaya Lainnya (Rp)</strong> untuk konfigurasi biaya ekstra di luar pemotongan utama.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Anak Pegawai (DSP)')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Anak Pegawai (DSP)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 11,
            ]
        );
    }
}

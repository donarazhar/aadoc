<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class RegistrasiAkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat atau pastikan kategori baru ada
        $categoryName = 'Panduan Penggunaan Aplikasi bagi OTM';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName, 
                'description' => 'Kumpulan panduan dan tutorial penggunaan Al Azhar Apps khusus untuk Orang Tua Murid.', 
                'order' => 6 
            ]
        );

        // 2. Buat artikel Registrasi Akun dengan gambar
        $title = 'Registrasi Akun Al Azhar Apps';
        
        $content = '
<h2>Panduan Cara Proses Registrasi Nomor Handphone</h2>
<p>Tutorial ini ditujukan untuk Orang Tua Calon/Murid yang ingin mendaftarkan akun baru pada Al Azhar Apps. Berikut adalah langkah-langkah pendaftarannya:</p>

<ol>
    <li>
        <strong>Masukkan Nomor Handphone:</strong> Setelah membuka aplikasi Al Azhar Apps, masukkan nomor handphone orang tua pada kolom yang tersedia. Pastikan nomor yang digunakan adalah nomor <strong>WhatsApp aktif</strong>.
        <br>
        <!-- Ganti src dengan path gambar Anda -->
        <img src="/assets/images/panduan/step1-input-nomor.jpg" alt="Langkah 1: Input Nomor HP" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
    <li>
        <strong>Lanjutkan Pendaftaran:</strong> Apabila nomor handphone Anda belum terdaftar, maka akan muncul <em>Pop Up</em> pemberitahuan "Nomor Belum Terdaftar". Tekan tombol <strong>Lanjutkan</strong> untuk melanjutkan proses pendaftaran.
        <br>
        <img src="/assets/images/panduan/step3-popup-belum-terdaftar.jpg" alt="Langkah 3: Pop up belum terdaftar" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
    <li>
        <strong>Lengkapi Data Diri:</strong> Masukkan <strong>Nama Lengkap</strong> orang tua murid dan alamat <strong>Email</strong> pada form pendaftaran yang disediakan.
        <br>
        <img src="/assets/images/panduan/step4-form-biodata.jpg" alt="Langkah 4: Form Biodata" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
    <li>
        <strong>Minta dan Masukkan Kode OTP:</strong> Tekan tombol <strong>Selanjutnya</strong>. Sistem akan mengirimkan kode OTP via WhatsApp. Cek pesan WhatsApp Anda, lalu masukkan kode OTP tersebut pada kotak <em>field</em> yang disediakan, lalu tekan <strong>Selanjutnya</strong>.
        <br>
        <img src="/assets/images/panduan/step6-input-otp.jpg" alt="Langkah 6: Input OTP" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
    <li>
        <strong>Buat dan Konfirmasi PIN:</strong> Buat 6 digit PIN untuk keamanan akun Anda, lalu tekan tombol <strong>Selanjutnya</strong>. Masukkan kembali PIN tersebut di halaman berikutnya untuk proses konfirmasi.
        <br>
        <img src="/assets/images/panduan/step7-buat-pin.jpg" alt="Langkah 7: Buat PIN" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
    <li>
        <strong>Registrasi Berhasil:</strong> Akun Anda telah berhasil dibuat! Silakan kembali ke halaman <em>Login</em> untuk masuk ke aplikasi.
        <br>
        <img src="/assets/images/panduan/step9-sukses-login.jpg" alt="Langkah 9: Berhasil" style="max-width: 300px; height: auto; margin: 15px 0; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    </li>
</ol>
';

        // 3. Simpan dokumen ke database
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanMobileRegistrasiSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Pengguna (User Manual)')],
            [
                'name' => 'Panduan Pengguna (User Manual)',
                'description' => 'Buku petunjuk langkah demi langkah penggunaan aplikasi',
                'order' => 7,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Panduan ini ditujukan bagi Orang Tua Calon Murid untuk melakukan pendaftaran awal (PPDB) hingga berhasil masuk ke aplikasi *Mobile* ALAZHARAPPS.</p>

<h3>1. Membuat Akun Pendaftaran (Web/Landing Page)</h3>
<p>Sebelum menggunakan aplikasi *Mobile*, Anda harus memiliki akun pendaftaran. Ikuti langkah berikut:</p>
<ol>
    <li>Buka *browser* di HP atau Laptop Anda, lalu kunjungi situs resmi pendaftaran sekolah: <code>pmb.alazhar.or.id</code>.</li>
    <li>Klik tombol <strong>Daftar Sekarang</strong>.</li>
    <li>Isi formulir pembuatan akun awal: Masukkan Nama Lengkap Orang Tua, Alamat Email Aktif, dan Nomor WhatsApp yang dapat dihubungi.</li>
    <li>Klik <strong>Buat Akun</strong>. Cek email Anda untuk mendapatkan *Password* sementara atau tautan aktivasi.</li>
</ol>

<h3>2. Melengkapi Formulir PPDB</h3>
<p>Setelah akun terbuat, segera <em>login</em> kembali ke portal <em>website</em> pendaftaran.</p>
<ol>
    <li>Pilih jenjang sekolah yang dituju (TK/SD/SMP/SMA).</li>
    <li>Isi dengan lengkap seluruh formulir Biodata Calon Siswa, Data Orang Tua/Wali, dan Riwayat Kesehatan.</li>
    <li>Unggah dokumen yang diminta (seperti Akta Kelahiran, Kartu Keluarga). Format gambar (JPG/PNG) atau PDF, pastikan ukurannya di bawah 2 MB.</li>
    <li>Klik tombol <strong>Kirim Formulir Final</strong>. Setelah ini, Anda akan mendapatkan tagihan Uang Pangkal / Pendaftaran.</li>
</ol>

<h3>3. Login ke Aplikasi Mobile</h3>
<p>Setelah anak Anda dinyatakan lulus tes dan berstatus <strong>Siswa Aktif</strong>, Anda baru bisa menggunakan aplikasi ALAZHARAPPS di HP.</p>
<ol>
    <li>Unduh aplikasi <strong>ALAZHARAPPS</strong> dari Google Play Store (Android) atau App Store (iOS).</li>
    <li>Buka aplikasi, masukkan <strong>Email</strong> (yang Anda gunakan saat mendaftar) dan <strong>Password</strong> (yang diberikan oleh sekolah / kata sandi web).</li>
    <li>Klik <strong>Masuk</strong>. Anda akan diarahkan ke *Dashboard* Orang Tua, di mana Anda bisa memantau lebih dari satu anak (jika Anda memiliki dua anak yang bersekolah di Al-Azhar).</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('1. [Mobile] Alur Registrasi PPDB & Akun')],
            [
                'title' => '1. [Mobile] Alur Registrasi PPDB & Akun',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

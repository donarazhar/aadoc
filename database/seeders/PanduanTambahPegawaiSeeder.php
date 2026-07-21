<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahPegawaiSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Pembuatan Akun Pegawai (User)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Dokumen ini berisi panduan langkah demi langkah untuk menambahkan pengguna baru dengan peran <strong>Pegawai</strong> di sistem Al Azhar Apps. Halaman untuk menambahkan pegawai berada pada rute <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/sekolah/user/add?tab=pegawai</code>.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah-langkah Pengisian Formulir:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Anda dapat menavigasi ke halaman ini melalui menu Manajemen Pengguna dan memilih tab <strong>Pegawai</strong>, lalu klik tombol <strong>Tambah</strong>.</li>
            <li>Setelah Anda berada di halaman Tambah User (Pegawai), isi bidang-bidang berikut secara berurutan.</li>
        </ol>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">1. Informasi Peran (Role)</h4>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Peran/Role:</strong> Bagian ini biasanya terkunci dan otomatis terpilih pada opsi Pegawai berdasarkan tab yang Anda buka.</li>
            <li><strong>Level:</strong> Dropdown ini akan muncul khusus untuk Pegawai. Pilih level pegawai yang sesuai, contohnya: Guru, Kepala Sekolah, Admin Sekolah, Admin Direktorat, dll.
                <br><br>
                <div style="background-color: #f0f9ff; border-left: 4px solid #0ea5e9; padding: 1rem; margin-top: 0.5rem; border-radius: 0.25rem;">
                    <strong>Note:</strong> Jika Anda memilih level <strong>Admin Sekolah</strong>, maka opsi checkbox tambahan bernama <strong>"Akses Menu LMS"</strong> akan muncul di bagian bawah formulir untuk menentukan apakah Admin Sekolah tersebut bisa mengakses layanan LMS.
                </div>
            </li>
            <li><strong>Status:</strong> Pilih <strong>Aktif</strong> untuk membuat akun pegawai ini dapat langsung digunakan untuk login. Pilih <strong>Non Aktif</strong> jika akun sedang dibekukan sementara.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">2. Data Utama Pegawai</h4>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Nama User:</strong> Ini adalah kolom pencarian otomatis. <strong>Ketik NIP atau Nama Pegawai/GTK</strong>. Sistem akan menampilkan saran nama pegawai dari database kepegawaian. Klik nama yang sesuai.</li>
            <li><strong>Username:</strong> Masukkan username untuk login (atau akan terisi otomatis berdasarkan profil yang dipilih di Nama User).
                <br><br>
                <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem; margin-top: 0.5rem; border-radius: 0.25rem;">
                    <strong>Warning:</strong> Pastikan bagian bawah input Username menampilkan status indikator berwarna <strong>hijau</strong> yang menandakan username <em>tersedia</em>. Jika indikator berwarna merah, silakan ganti dengan username lain.
                </div>
            </li>
            <li><strong>Email:</strong> Masukkan email aktif pegawai. Email ini akan digunakan jika pegawai perlu me-reset password.</li>
            <li><strong>Nomor Handphone:</strong> Masukkan nomor handphone valid (hanya angka, maksimal 12 digit).</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">3. Keamanan & Menyimpan Data</h4>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Password:</strong> Ketik kata sandi (password) yang akan digunakan pegawai saat login pertama kali.</li>
            <li><strong>Konfirmasi Password:</strong> Ketik ulang password yang sama untuk memverifikasi.</li>
        </ul>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Proses Akhir:</strong> Jika semua isian telah diisi dan valid, pastikan tidak ada pesan error berwarna merah di bawah kotak isian. Klik tombol <strong>Simpan</strong> di bagian bawah halaman. Anda akan dialihkan kembali ke daftar Pegawai dan notifikasi "Berhasil" akan muncul.
        </div>
        </div>
        ';

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Pembuatan Akun Pegawai',
            'slug' => Str::slug('Panduan Pembuatan Akun Pegawai'),
            'content' => trim($htmlContent),
            'is_published' => true,
            'created_by' => $userId,
            'order' => 2,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahUserSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Akses Pengguna Role Administrator')],
            [
                'name' => 'Setup Akses Pengguna Role Administrator',
                'description' => 'Panduan tahap ketiga terkait pembuatan akses pengguna (Manajemen User) oleh Administrator.'
            ]
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Tambah User Baru</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Halaman ini digunakan untuk menambahkan pengguna baru ke dalam sistem aplikasi Fintech Al-Azhar melalui menu <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/user/add</code>.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah-langkah Penambahan User:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Buka halaman Dashboard dan arahkan ke menu <strong>Manajemen User > User Back Office Pusat</strong> atau <strong>Manajemen User > User Sekolah</strong>.</li>
            <li>Klik tombol <strong>Tambah User</strong> untuk diarahkan ke form penambahan.</li>
            <li>Isi formulir dengan lengkap dan benar sesuai rincian data di bawah ini. Pastikan Anda memperhatikan relasi antar <em>dropdown</em> (misalnya Peran/Role dengan Level).</li>
        </ol>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Daftar Detail Field Form:</h4>
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%; text-align: left; margin-bottom: 1.5rem;">
            <thead style="background-color: #f8fafc;">
                <tr>
                    <th style="width: 25%;">Nama Field</th>
                    <th style="width: 20%;">Tipe Input</th>
                    <th style="width: 55%;">Deskripsi & Panduan Pengisian</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Nama Pegawai</strong></td>
                    <td>Teks (Wajib)</td>
                    <td>Masukkan nama lengkap pengguna (Minimal 3 karakter).</td>
                </tr>
                <tr>
                    <td><strong>Username</strong></td>
                    <td>Teks (Wajib)</td>
                    <td>Masukkan username unik untuk keperluan login ke aplikasi (Minimal 5 karakter).</td>
                </tr>
                <tr>
                    <td><strong>Email</strong></td>
                    <td>Email (Wajib)</td>
                    <td>Masukkan alamat email yang valid dan aktif.</td>
                </tr>
                <tr>
                    <td><strong>Nomor Handphone</strong></td>
                    <td>Angka (Wajib)</td>
                    <td>Masukkan nomor kontak aktif pengguna. Hanya menerima format angka dengan panjang maksimal 14 digit.</td>
                </tr>
                <tr>
                    <td><strong>Peran/Role</strong></td>
                    <td>Dropdown (Wajib)</td>
                    <td>Pilih hak akses makro (role utama) pengguna di dalam aplikasi. Sistem menyediakan role seperti <strong>Superadmin</strong>, <strong>Administrator</strong>, <strong>Kepala Sekolah</strong>, <strong>Admin Sekolah</strong>, <strong>Guru</strong>, dll. Pilihan ini akan menentukan Opsi Level yang muncul selanjutnya.</td>
                </tr>
                <tr>
                    <td><strong>Level</strong></td>
                    <td>Dropdown (Wajib)</td>
                    <td>
                        Pilih hierarki jabatan pengguna. <strong>Perhatian: Pilihan level bersifat dinamis dan bergantung pada pilihan Peran/Role sebelumnya!</strong>
                        <ul style="margin-top: 0.5rem; margin-bottom: 0;">
                            <li>Jika Anda memilih Role <em>Administrator</em>, maka opsi level hanya akan menampilkan "Administrator".</li>
                            <li>Jika Anda memilih Role <em>Admin Sekolah</em>, maka opsi level menampilkan "Admin Sekolah".</li>
                            <li>Jika Anda memilih Role <em>Admin Direktorat Dikdasmen</em>, opsi level akan bervariasi dari Kasi, Pengawas, Dir Dikdasmen, dll.</li>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <td><strong>Jenjang</strong></td>
                    <td>Dropdown (Kondisional)</td>
                    <td><em>Hanya muncul untuk role/level tertentu</em> (misalnya level Kasi (14) atau jabatan terkait Manajemen Sekolah). Memilih tingkatan pendidikan sekolah, contoh: TK, SD, SMP, SMA.</td>
                </tr>
                <tr>
                    <td><strong>Sekolah</strong></td>
                    <td>Pencarian (Kondisional)</td>
                    <td><em>Hanya muncul untuk role/level terkait pengawas (15) atau sekolah</em>. Pilih unit sekolah di mana pengguna ditempatkan. Data sekolah diambil langsung secara dinamis dari database sekolah.</td>
                </tr>
                <tr>
                    <td><strong>Password</strong></td>
                    <td>Password (Wajib)</td>
                    <td>Masukkan kata sandi awal untuk pengguna. Harus memenuhi kriteria keamanan: Minimal 8 karakter, mengandung huruf besar, huruf kecil, dan simbol (kecuali untuk role Superadmin).</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td>Dropdown (Wajib)</td>
                    <td>Pilih <strong>Aktif</strong> agar akun langsung dapat digunakan atau <strong>Non Aktif</strong> untuk menahan akses login pengguna bersangkutan.</td>
                </tr>
            </tbody>
        </table>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Setelah seluruh data diisi dengan benar dan pesan error validasi berwarna merah hilang, klik tombol <strong>Simpan</strong> yang terletak di bagian bawah formulir untuk menyelesaikan pendaftaran pengguna.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Pembuatan Tambah User')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Pembuatan/Tambah User',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 20,
            ]
        );
    }
}

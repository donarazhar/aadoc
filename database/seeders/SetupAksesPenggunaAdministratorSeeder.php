<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class SetupAksesPenggunaAdministratorSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Workflow Manajemen User (Tahap 3)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selamat datang di <strong>Tahap 3: Pembuatan Akses Pengguna (Manajemen User)</strong>. Setelah profil Unit Sekolah dan infrastrukturnya terbentuk di tahap sebelumnya, kini saatnya Anda membagikan "kunci rumah" (hak akses) kepada para penanggung jawab di masing-masing unit.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Tujuan Utama:</strong> Mendelegasikan wewenang operasional akademik dan keuangan ke level sekolah. Tanpa akun akses, unit sekolah tidak akan bisa melakukan pendaftaran murid maupun pembagian kelas.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Apa yang Perlu Dilakukan Administrator?</h3>
        <p style="margin-bottom: 1rem;">Pada tahap ini, Anda wajib mendistribusikan akun menggunakan dua menu utama di Manajemen User:</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 1rem;">
                <strong>User Back Office Pusat</strong><br>
                Digunakan untuk mendaftarkan staf-staf pusat (Yayasan/Direktorat) yang membutuhkan akses pantauan level makro. Jika belum ada kebutuhan tambahan staf pusat, Anda bisa melewati langkah ini.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>User Sekolah (Krusial)</strong><br>
                Di sinilah Anda harus membuatkan akun <strong>Admin Sekolah</strong> dan/atau <strong>Kepala Sekolah</strong> untuk setiap unit yang sudah Anda daftarkan di Tahap 2. 
                <div style="background-color: #fefce8; padding: 0.75rem; border-left: 4px solid #eab308; margin-top: 0.5rem; border-radius: 0.25rem; font-size: 0.95rem;">
                    <em>Delegasi Tugas:</em> Setelah Admin Sekolah mendapatkan akunnya, mereka dapat langsung login. Selanjutnya, merekalah yang bertugas membuat akun untuk guru-guru di sekolah mereka sendiri, serta memecah Rombongan Belajar (Rombel). Administrator Pusat tidak perlu repot mendata satu per satu guru di sistem.
                </div>
            </li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 2rem; border-radius: 0.25rem;">
            <strong>Panduan Teknis Tersedia:</strong><br>
            Untuk mengetahui cara teknis mengisi form penambahan akun, silakan baca artikel <em>Panduan Tambah User Baru</em> dan <em>Panduan Pembuatan Akun Pegawai (User)</em> yang ada di kategori ini.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Akses Pengguna')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Workflow Akses Pengguna',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 19,
            ]
        );
    }
}

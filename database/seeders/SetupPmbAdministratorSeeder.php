<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class SetupPmbAdministratorSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Persiapan PMB Administrator')],
            [
                'name' => 'Setup Persiapan PMB Administrator',
                'description' => 'Panduan tahap kelima (terakhir) terkait persiapan Penerimaan Murid Baru oleh Administrator.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Workflow Persiapan PMB (Tahap 5)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selamat datang di <strong>Tahap 5: Persiapan Penerimaan Murid Baru (PMB)</strong>. Ini adalah tahap terakhir dari tugas fondasional Administrator Pusat. Setelah seluruh referensi, unit sekolah, akun admin, dan nominal biaya terbentuk, kini saatnya Anda membuka "keran" pendaftaran bagi calon murid baru.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Tahap Ini:</strong> Tanpa adanya konfigurasi PMB yang aktif, sistem portal pendaftaran (Frontend PMB) tidak akan bisa diakses oleh calon pendaftar, karena sistem tidak tahu kapan pendaftaran dimulai dan ditutup.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Apa Saja yang Harus Disiapkan?</h3>
        <p style="margin-bottom: 1rem;">Pada tahap ini, Anda akan bekerja di menu <strong>Administrasi &gt; PMB</strong> atau <strong>Master Data &gt; Gelombang/Jadwal Ujian</strong> (tergantung penempatan menu) untuk mengatur dua hal utama:</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 1rem;">
                <strong>Gelombang Pendaftaran</strong><br>
                Anda harus mendefinisikan gelombang-gelombang pendaftaran (misal: Gelombang 1, Gelombang 2, Jalur Prestasi) lengkap dengan tanggal buka dan tanggal tutupnya untuk masing-masing jenjang atau program.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Jadwal Ujian Masuk (Observasi/Seleksi)</strong><br>
                Setiap pendaftar umumnya harus melewati tahap observasi atau ujian saringan masuk. Anda bertugas membuat opsi-opsi jadwal (tanggal, jam, dan lokasi) yang nantinya akan dipilih oleh calon murid saat melengkapi formulir pendaftaran mereka.
            </li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 2rem; border-radius: 0.25rem;">
            <strong>Selamat!</strong> Setelah tahap ini selesai dilakukan, maka siklus tugas setup awal Administrator Pusat telah beres. Calon murid sudah bisa mendaftar, dan operasional harian siap diteruskan oleh bagian Administrasi Sekolah dan Keuangan. Silakan baca detail inputnya di artikel terkait dalam kategori ini.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Persiapan PMB')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Workflow Persiapan PMB',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 30,
            ]
        );
    }
}

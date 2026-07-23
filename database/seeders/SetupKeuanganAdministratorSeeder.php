<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class SetupKeuanganAdministratorSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Keuangan dan Tagihan Inti Administrator')],
            [
                'name' => 'Setup Keuangan & Tagihan Inti Administrator',
                'description' => 'Panduan tahap keempat terkait konfigurasi keuangan dan tagihan pokok oleh Administrator.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Workflow Konfigurasi Keuangan (Tahap 4)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selamat datang di <strong>Tahap 4: Konfigurasi Keuangan & Tagihan Inti</strong>. Sebelum aplikasi siap digunakan untuk proses transaksi Penerimaan Murid Baru (PMB) maupun pembayaran SPP bulanan, Administrator Pusat wajib mengatur besaran (nominal) biaya yang berlaku di lingkungan yayasan/sekolah.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Mengapa Ini Penting?</strong> Sistem tidak dapat menerbitkan tagihan (invoice) otomatis kepada murid/orang tua jika master nominal biaya ini belum didefinisikan.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Apa Saja yang Diatur?</h3>
        <p style="margin-bottom: 1rem;">Pada tahap ini, Anda akan memfokuskan pengaturan pada menu <strong>Administrasi &gt; Biaya</strong>. Konfigurasi dibagi menjadi dua bagian utama:</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 1rem;">
                <strong>Uang Pangkal & Uang Sekolah (SPP)</strong><br>
                Ini adalah komponen biaya pokok pendidikan. Anda perlu menentukan besaran/nominal tagihan bulanan (SPP) dan tagihan satu kali di awal masuk (Uang Pangkal). Konfigurasi ini biasanya dibedakan untuk masing-masing jenjang atau unit sekolah.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Uang Daftar Ulang & Ekstrakurikuler</strong><br>
                Merupakan komponen biaya tambahan (di luar biaya pokok). Uang daftar ulang dikonfigurasikan bagi siswa yang naik jenjang/kelas tertentu, sedangkan ekstrakurikuler diperuntukkan bagi aktivitas tambahan yang berbayar.
            </li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 2rem; border-radius: 0.25rem;">
            <strong>Langkah Selanjutnya:</strong><br>
            Untuk mengetahui tata cara input nominal biaya tersebut, silakan baca artikel-artikel panduan teknis yang ada di dalam kategori ini (Panduan Uang Pangkal & SPP, serta Panduan Daftar Ulang & Ekskul).
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Konfigurasi Keuangan')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Workflow Konfigurasi Keuangan',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 25,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDaftarUlangSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Setup Biaya Daftar Ulang</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selain Uang Pangkal dan SPP, komponen pembiayaan penting lainnya adalah <strong>Biaya Daftar Ulang</strong>. Biaya ini biasanya dikenakan kepada murid yang melanjutkan ke tahun ajaran baru atau kenaikan kelas tertentu.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Akses URL:</strong> Halaman ini dapat diakses melalui menu <a href="/admin/biaya/daftar-ulang/add" style="color: #2563eb; font-family: monospace; font-weight: bold; text-decoration: underline;">admin/biaya/daftar-ulang/add</a>.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Biaya Daftar Ulang</h3>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem; list-style-type: decimal;">
            <li style="margin-bottom: 1rem;">
                <strong>Akses Menu Daftar Ulang</strong><br>
                Masuk ke menu <strong>Administrasi &gt; Biaya &gt; Daftar Ulang</strong>, lalu klik tombol <strong>Tambah Daftar Ulang</strong>.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Pilih Target Sekolah & Tahun Ajaran</strong><br>
                Tentukan <strong>Nama Sekolah</strong> dan pilih <strong>Tahun Ajaran</strong> kapan biaya daftar ulang ini mulai diberlakukan.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Tentukan Kelas & Program</strong><br>
                Pilih <strong>Tingkat Kelas</strong> yang diwajibkan membayar daftar ulang, serta pilih <strong>Program</strong> (misal: Reguler, Bilingual, Tahfidz).
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Atur Tanggal Jatuh Tempo</strong><br>
                Masukkan <strong>Tanggal Jatuh Tempo</strong> (Due Date) untuk pembayaran daftar ulang ini.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Masukkan Komponen Biaya Daftar Ulang</strong><br>
                Sistem memungkinkan Anda untuk memecah daftar ulang ke dalam beberapa komponen (misal: Seragam, Buku, SPP Bulan Juli, dsb). 
                <ul style="margin-top: 0.5rem; margin-bottom: 0.5rem; list-style-type: disc; margin-left: 1.5rem;">
                    <li>Pilih <strong>Komponen Biaya</strong> dari dropdown.</li>
                    <li>Masukkan <strong>Nominal</strong> untuk komponen tersebut.</li>
                    <li>Klik <strong>Tambah Komponen Biaya</strong> jika Anda ingin menambahkan lebih dari satu rincian biaya.</li>
                </ul>
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Review Total dan Simpan</strong><br>
                Sistem akan secara otomatis menjumlahkan nominal-nominal tersebut dan menampilkan <strong>Total Biaya Daftar Ulang</strong>. Jika sudah sesuai, klik tombol <strong>Simpan</strong>.
            </li>
        </ol>

        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Sama seperti tagihan lainnya, pastikan komponen biaya sudah dikonfigurasikan di master data sebelum membuat tagihan daftar ulang.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Setup Biaya Daftar Ulang')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Biaya Daftar Ulang',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 26,
            ]
        );
    }
}

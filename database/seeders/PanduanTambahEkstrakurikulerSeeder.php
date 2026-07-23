<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahEkstrakurikulerSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Setup Biaya Ekstrakurikuler</h1>
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">Selain kegiatan intrakurikuler, sekolah seringkali menyediakan berbagai macam kegiatan <strong>Ekstrakurikuler</strong> yang memiliki pembiayaan tersendiri. Panduan ini menjelaskan cara menambahkan tagihan untuk kegiatan ekstrakurikuler tertentu.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Akses URL:</strong> Halaman ini dapat diakses melalui menu <a href="/admin/biaya/ekstrakulikuler/add" style="color: #2563eb; font-family: monospace; font-weight: bold; text-decoration: underline;">admin/biaya/ekstrakulikuler/add</a>.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Biaya Ekstrakurikuler</h3>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem; list-style-type: decimal;">
            <li style="margin-bottom: 1rem;">
                <strong>Akses Menu Ekstrakurikuler</strong><br>
                Buka menu <strong>Administrasi &gt; Biaya &gt; Ekstrakurikuler</strong>, lalu klik tombol <strong>Tambah Biaya Ekstrakurikuler</strong>.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Pilih Sekolah dan Tahun Ajaran</strong><br>
                Tentukan <strong>Nama Sekolah</strong> penyelenggara dan pilih <strong>Tahun Ajaran</strong> kapan ekstrakurikuler ini diadakan.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Tentukan Kelas dan Program</strong><br>
                Masukkan <strong>Tingkat Kelas</strong> dan <strong>Program</strong> yang menjadi sasaran ekstrakurikuler tersebut.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Pilih Ekstrakurikuler</strong><br>
                Akan muncul dropdown untuk memilih <strong>Nama Ekstrakurikuler</strong> (misal: Futsal, Pramuka, Coding, dsb). Pastikan kegiatan ini sudah didaftarkan pada Master Data Ekstrakurikuler.
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Atur Jatuh Tempo dan Rincian Biaya</strong><br>
                Tentukan <strong>Tanggal Jatuh Tempo</strong> pembayarannya. Kemudian pada bagian komponen biaya:
                <ul style="margin-top: 0.5rem; margin-bottom: 0.5rem; list-style-type: disc; margin-left: 1.5rem;">
                    <li>Pilih <strong>Komponen Biaya</strong> (contoh: Iuran Bulanan Ekskul, Biaya Seragam Ekskul).</li>
                    <li>Masukkan <strong>Nominal</strong> untuk setiap komponen.</li>
                    <li>Klik <strong>Tambah Komponen Biaya</strong> jika ada lebih dari satu jenis iuran dalam satu tagihan ekskul.</li>
                </ul>
            </li>
            <li style="margin-bottom: 1rem;">
                <strong>Simpan Data</strong><br>
                Periksa kembali <strong>Total Biaya Ekstrakurikuler</strong> yang terkalkulasi otomatis. Jika sudah benar, klik <strong>Simpan</strong>.
            </li>
        </ol>

        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Tagihan Ekstrakurikuler biasanya bersifat opsional dan hanya akan ditagihkan kepada murid yang memang mendaftar atau memilih ekstrakurikuler tersebut pada menu penugasan/pendaftaran siswa.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Setup Biaya Ekstrakurikuler')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Biaya Ekstrakurikuler',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 27,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSppSekolahSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Uang Sekolah Unit (Admin Sekolah)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu <strong>Admin Sekolah</strong> dalam mengatur besaran SPP spesifik untuk kelas atau program tertentu di sekolahnya. Meskipun master SPP diturunkan dari Pusat, Admin Sekolah diberikan fitur untuk menyesuaikan atau menambah biaya spesifik melalui halaman <code>admin/spp/sekolah/add</code>.</p>
        
        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem; margin-bottom: 1.5rem;">
            <strong>Catatan:</strong> Menu ini secara eksklusif digunakan oleh Admin Sekolah untuk mengelola tagihan riil yang akan dibebankan kepada murid di unit tempat mereka bertugas.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah Penambahan Uang Sekolah Unit:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Masuk ke menu <strong>Administrasi &gt; Biaya &gt; Uang Sekolah</strong> dan pastikan Anda berada di halaman <strong>Sekolah</strong>.</li>
            <li>Klik tombol <strong>Tambah Uang Sekolah</strong>. Anda akan diarahkan ke halaman <code>/admin/spp/sekolah/add</code>.</li>
            <li><strong>Tahun Ajaran:</strong> Pilih Tahun Ajaran yang sedang aktif atau yang akan datang.</li>
            <li><strong>Tingkat Kelas:</strong> Pilih tingkat kelas spesifik yang biaya SPP-nya ingin Anda atur (misal: Kelas 1, Kelas 2, dst).</li>
            <li><strong>Program:</strong> Pilih jenis program kelas tersebut (contoh: Reguler atau Bilingual).</li>
            <li><strong>Uang Sekolah (SPP):</strong> Masukkan nominal tagihan SPP bulanan dalam Rupiah tanpa titik/koma (misalnya: <code>1500000</code>).</li>
            <li>Periksa kembali data yang dimasukkan, lalu klik tombol <strong>Simpan</strong> untuk menambahkan tagihan unit tersebut ke dalam sistem.</li>
        </ol>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Uang Sekolah Unit')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Uang Sekolah (Unit Sekolah)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 27,
            ]
        );
    }
}

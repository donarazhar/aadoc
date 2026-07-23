<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUangPangkalSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Uang Pangkal</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Selain SPP, komponen biaya pokok lainnya yang wajib diatur adalah <strong>Uang Pangkal</strong>. Uang Pangkal biasanya dibebankan satu kali saat siswa baru masuk (Penerimaan Murid Baru). Konfigurasi ini sangat krusial bagi modul PMB agar calon murid bisa mendapatkan invoice tagihan awal yang tepat.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah Konfigurasi Uang Pangkal:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Navigasi ke menu <strong>Administrasi &gt; Biaya &gt; Tagihan Uang Pangkal</strong>.</li>
            <li>Klik tombol <strong>Tambah Uang Pangkal</strong>.</li>
            <li><strong>Tahun Ajaran Masuk:</strong> Pastikan Anda memilih Tahun Ajaran yang sesuai untuk angkatan baru.</li>
            <li><strong>Jenjang & Program:</strong> Tentukan jenjang pendidikan dan program (Reguler/Bilingual) karena besaran uang pangkal umumnya berbeda per program.</li>
            <li><strong>Rincian Komponen:</strong> Pada form yang disediakan, masukkan rincian komponen penyusun uang pangkal (misalnya: Uang Gedung, Uang Seragam, Buku, atau komponen lainnya jika dipisah). Jika sistem hanya meminta satu total, masukkan besaran totalnya.</li>
            <li>Klik tombol <strong>Simpan</strong>.</li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 2rem; border-radius: 0.25rem;">
            <strong>Catatan Operasional:</strong> Setelah diatur, master biaya ini akan terhubung otomatis dengan sistem PMB. Ketika calon siswa dinyatakan lulus ujian masuk, sistem akan seketika men-<i>generate</i> tagihan Uang Pangkal berdasarkan pengaturan ini.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Uang Pangkal')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Uang Pangkal',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 28,
            ]
        );
    }
}

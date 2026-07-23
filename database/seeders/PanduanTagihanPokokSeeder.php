<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTagihanPokokSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Uang Pangkal & Uang Sekolah (SPP)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Administrator Pusat dalam mengatur nominal dasar (master) untuk Uang Pangkal dan Uang Sekolah (SPP). Pengaturan ini dilakukan melalui menu <strong>Administrasi &gt; Biaya</strong>.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian A: Konfigurasi Uang Sekolah (SPP)</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Navigasi ke menu <strong>Administrasi &gt; Biaya &gt; Uang Sekolah (SPP) Pusat</strong>.</li>
            <li>Klik tombol <strong>Tambah Uang Sekolah</strong>.</li>
            <li><strong>Jenjang:</strong> Pilih jenjang pendidikan (misalnya TK, SD, SMP, atau SMA). Sistem mungkin memungkinkan nominal yang sama untuk semua sekolah dalam jenjang yang sama, atau bisa dibedakan.</li>
            <li><strong>Program:</strong> Tentukan program (Reguler, Bilingual, dll) karena biasanya berbeda program memiliki SPP berbeda.</li>
            <li><strong>Tahun Ajaran:</strong> Pastikan Anda memilih Tahun Ajaran aktif saat ini.</li>
            <li><strong>Nominal SPP:</strong> Masukkan besaran uang SPP bulanan dalam Rupiah (tanpa titik/koma jika melalui sistem, ikuti petunjuk input di layar).</li>
            <li>Simpan data tersebut.</li>
        </ol>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian B: Konfigurasi Uang Pangkal</h4>
        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem; margin-bottom: 1.5rem;">
            <strong>Catatan:</strong> Uang Pangkal biasanya dibebankan satu kali saat siswa baru masuk (Penerimaan Murid Baru). Konfigurasi ini sangat krusial bagi modul PMB.
        </div>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Navigasi ke menu <strong>Administrasi &gt; Biaya &gt; Tagihan Uang Pangkal</strong> (atau yang relevan di menu Biaya).</li>
            <li>Klik tombol <strong>Tambah Uang Pangkal</strong>.</li>
            <li>Isi parameter yang diperlukan seperti <strong>Jenjang</strong>, <strong>Program</strong>, dan <strong>Tahun Ajaran Masuk</strong>.</li>
            <li><strong>Rincian Komponen:</strong> Pada beberapa instansi, Uang Pangkal terdiri dari beberapa sub-komponen (Uang Gedung, Uang Seragam, Buku, dll). Masukkan nominal total atau rinciannya sesuai dengan form yang tersedia.</li>
            <li>Simpan konfigurasi.</li>
        </ol>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Uang Pangkal SPP')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Uang Pangkal & SPP',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 26,
            ]
        );
    }
}

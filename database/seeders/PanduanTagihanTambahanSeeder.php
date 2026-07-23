<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTagihanTambahanSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Daftar Ulang & Ekstrakurikuler</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Selain biaya pokok, Administrator juga bertanggung jawab mengatur nominal untuk tagihan tambahan rutin tahunan seperti Daftar Ulang dan Ekstrakurikuler bulanan.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian A: Biaya Daftar Ulang (Tahunan)</h4>
        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.25rem;">
            Biaya Daftar Ulang (atau Her-registrasi) umumnya dikenakan pada saat kenaikan kelas di awal Tahun Ajaran baru.
        </div>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Masuk ke menu <strong>Administrasi &gt; Biaya &gt; Daftar Ulang</strong>.</li>
            <li>Klik tombol <strong>Tambah Biaya Daftar Ulang</strong>.</li>
            <li><strong>Jenjang & Kelas:</strong> Tentukan jenjang dan kelas spesifik (misal: SDIA kelas 2). Terkadang nominal daftar ulang bisa berbeda per angkatan kelas.</li>
            <li><strong>Tahun Ajaran:</strong> Pilih tahun ajaran yang akan datang.</li>
            <li><strong>Nominal:</strong> Masukkan jumlah total uang daftar ulang. Jika form meminta rincian komponen (Buku, Kegiatan, SPP bulan Juli, dll), isikan pada baris yang sesuai.</li>
            <li>Klik <strong>Simpan</strong>.</li>
        </ol>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Bagian B: Biaya Ekstrakurikuler</h4>
        <p style="margin-bottom: 1rem;">Langkah ini untuk mendata master biaya setiap jenis kegiatan ekstrakurikuler (Ekskul) yang ditawarkan sekolah kepada siswa.</p>
        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li>Buka menu <strong>Administrasi &gt; Biaya &gt; Ekstrakurikuler</strong>.</li>
            <li>Klik <strong>Tambah Ekskul</strong> (atau <em>Tambah Biaya Ekskul</em>).</li>
            <li>Isi nama Ekstrakurikuler (contoh: <em>Futsal</em>, <em>Robotik</em>, <em>Pramuka</em>).</li>
            <li>Tentukan <strong>Jenjang</strong> pendidikan yang menyelenggarakan ekskul ini.</li>
            <li>Masukkan <strong>Nominal Iuran Bulanan</strong> untuk mengikuti ekskul tersebut. (Isi 0 jika ekskul bersifat wajib/gratis).</li>
            <li>Klik <strong>Simpan</strong>. Pengaturan ini nantinya akan terintegrasi dengan modul pemilihan ekskul oleh siswa.</li>
        </ol>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Setup Daftar Ulang Ekskul')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Daftar Ulang & Ekstrakurikuler',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 27,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahKurikulumMapelSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada
        $category = Category::firstOrCreate(
            ['slug' => 'setup-panduan'],
            ['name' => 'Setup & Panduan', 'description' => 'Panduan instalasi dan setup lokal aplikasi']
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Kurikulum & Mata Pelajaran</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini akan memandu Anda (Administrator Pusat) untuk mengatur referensi dasar pendidikan, yaitu <strong>Kurikulum</strong> dan <strong>Mata Pelajaran</strong>. Data ini akan digunakan secara luas oleh para Guru saat mengelola kelas dan rapor (LMS).</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Pembuatan Master Kurikulum dan Mata Pelajaran dilakukan secara terpusat oleh Admin Pusat untuk menjaga keseragaman penamaan di seluruh unit sekolah Al Azhar.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">A. Cara Menambahkan Kurikulum</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Navigasi ke menu <strong>Master Data &gt; Kurikulum</strong> (rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/kurikulum</code>).</li>
            <li>Klik tombol <strong>Tambah Data</strong>.</li>
            <li>Lengkapi formulir berikut:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                    <li><strong>Nama Kurikulum:</strong> Masukkan nama kurikulum yang berlaku (Contoh: "Kurikulum Merdeka" atau "K13").</li>
                    <li><strong>Status:</strong> Pilih <em>Aktif</em> jika kurikulum ini sedang digunakan, atau <em>Tidak Aktif</em> jika sudah tidak digunakan namun datanya tidak ingin dihapus (untuk riwayat).</li>
                </ul>
            </li>
            <li>Klik <strong>Simpan</strong>.</li>
        </ol>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">B. Cara Menambahkan Mata Pelajaran</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Navigasi ke menu <strong>Master Data &gt; Mata Pelajaran</strong> (rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/mata-pelajaran</code>).</li>
            <li>Klik tombol <strong>Tambah Data</strong>.</li>
            <li>Lengkapi formulir master mata pelajaran:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                    <li><strong>Nama Mata Pelajaran:</strong> Tuliskan nama mapel secara baku (Contoh: "Matematika", "Pendidikan Agama Islam", atau "Bahasa Inggris").</li>
                    <li><strong>Status:</strong> Pilih <em>Aktif</em> agar mata pelajaran ini muncul di sistem dan bisa dipilih oleh Guru/Sekolah.</li>
                </ul>
            </li>
            <li>Klik <strong>Simpan</strong>.</li>
        </ol>

        <div style="background-color: #f8fafc; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; margin-top: 2rem;">
            <strong>💡 Tahukah Anda?</strong> Anda tidak perlu mengetikkan Kode Mapel, Jenjang, atau Jam Pelajaran (JP MP) saat membuat Master Mata Pelajaran karena hal tersebut sudah disederhanakan. Guru atau pihak Sekolah nantinya tinggal memilih nama mata pelajaran dari daftar Master yang telah Anda buat ini saat mem-plotting jadwal.
        </div>
        </div>
        ';

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Menambahkan Kurikulum dan Mata Pelajaran',
            'slug' => Str::slug('Panduan Menambahkan Kurikulum dan Mata Pelajaran'),
            'content' => trim($htmlContent),
            'is_published' => true,
            'created_by' => $userId,
            'order' => 6,
        ]);
    }
}

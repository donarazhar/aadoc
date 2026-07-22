<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonPrestasiSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Prestasi Kejuaraan</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini berisi panduan langkah demi langkah untuk mendaftarkan skema <strong>Diskon Prestasi Kejuaraan</strong> pada aplikasi Al Azhar Apps. Fitur ini digunakan untuk memberikan apresiasi berupa potongan Uang Pangkal bagi calon murid/murid yang berprestasi dalam bidang akademik, sains, seni, maupun olahraga.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Skema Diskon:</strong> Skema potongan ini secara otomatis akan memotong persentase Uang Pangkal yang wajib dibayarkan berdasarkan perolehan medali (Emas, Perak, Perunggu) pada tingkat kejuaraan yang diikuti.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Diskon Prestasi</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Pada menu sidebar sebelah kiri, masuk ke <strong>Master Data &gt; Diskon &gt; Diskon Prestasi Kejuaraan</strong> (Rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/diskon-prestasi/add</code>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                Klik tombol <strong>Tambah Data</strong> (atau <em>Tambah Murid Prestasi Kejuaraan</em>) untuk membuka formulir input.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Pengisian Formulir:</strong> Isi seluruh bidang formulir sesuai dengan ketentuan skema diskon yang berlaku:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li style="margin-bottom: 0.4rem;"><strong>Nama Kategori Diskon (Wajib):</strong> Masukkan nama kategori penghargaan/kejuaraan. <em>(Contoh: "Olimpiade Sains Nasional", "Kejuaraan Olahraga Tingkat Provinsi")</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Tingkat (Dropdown):</strong> Pilih skala tingkat kompetisi/kejuaraan. <em>(Pilihan: Internasional, Nasional, Provinsi, atau Kabupaten/Kota)</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Besaran Potongan Uang Pangkal (%):</strong> Masukkan persentase potongan yang diberikan berdasarkan jenis medali perolehan:
                        <ul style="margin-left: 1.5rem; margin-top: 0.25rem;">
                            <li><strong>Emas:</strong> Masukkan angka persentase potongan untuk Medali Emas <em>(Contoh: 50 untuk potongan 50%)</em>.</li>
                            <li><strong>Perak:</strong> Masukkan angka persentase potongan untuk Medali Perak <em>(Contoh: 30 untuk potongan 30%)</em>.</li>
                            <li><strong>Perunggu:</strong> Masukkan angka persentase potongan untuk Medali Perunggu <em>(Contoh: 20 untuk potongan 20%)</em>.</li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 0.4rem;"><strong>Status (Dropdown):</strong> Pilih status aktifitas skema diskon ini <em>(Aktif / Non-Aktif)</em>.</li>
                </ul>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Konfirmasi dan Simpan:</strong> Klik tombol <strong>Simpan</strong> di bagian bawah halaman. Modal konfirmasi akan muncul, klik <strong>Ya, Simpan</strong> untuk menyelesaikan proses.
            </li>
        </ol>

        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 1.5rem; border-radius: 0.25rem;">
            <strong>Tips Penggunaan:</strong> Pastikan persentase perolehan Emas &gt; Perak &gt; Perunggu agar skema potongan bertingkat berjalan secara rasional dan proporsional.
        </div>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Skema diskon prestasi yang sudah disimpan dan berstatus <em>Aktif</em> langsung dapat dipilih pada saat proses pendaftaran calon murid baru (PMB) atau entri data penerimaan murid berprestasi.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Prestasi Kejuaraan')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Prestasi Kejuaraan',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 7,
            ]
        );
    }
}

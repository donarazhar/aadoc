<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahDiskonSaudaraKandungSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Diskon Saudara Kandung</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini berisi panduan langkah demi langkah untuk mendaftarkan skema <strong>Diskon Saudara Kandung</strong> pada aplikasi Al Azhar Apps. Diskon ini ditujukan untuk memberikan keringanan biaya pendaftaran atau biaya pendidikan bagi murid yang memiliki saudara kandung yang juga bersekolah di lingkungan Al-Azhar.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Skema Diskon:</strong> Modul ini memungkinkan pihak sekolah untuk memberikan potongan biaya dalam bentuk Rupiah (nominal tunai) berdasarkan jumlah saudara kandung yang sudah bersekolah sebelumnya. 
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Menambahkan Diskon Saudara Kandung</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Pada sidebar sebelah kiri, masuk ke <strong>Master Data &gt; Diskon &gt; Saudara Kandung</strong> (Rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/diskon/saudara-kandung/add</code>).
            </li>
            <li style="margin-bottom: 0.75rem;">
                Klik tombol <strong>Tambah Data</strong> yang ada di bagian atas tabel untuk masuk ke halaman formulir.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Pengisian Formulir:</strong> Isi kolom-kolom berikut dengan teliti:
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li style="margin-bottom: 0.4rem;"><strong>Jumlah Saudara (Dropdown - Wajib):</strong> Pilih klasifikasi jumlah saudara kandung. <em>(Misalnya: "Saudara ke-2", "Saudara ke-3")</em>. Sistem akan secara otomatis mengisi kolom <strong>Kategori</strong> di sebelahnya sesuai dengan pilihan yang Anda buat.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Besaran Potongan (Rp) (Wajib):</strong> Masukkan nominal potongan biaya dalam bentuk Rupiah. Kolom ini akan otomatis memformat angka yang Anda ketik menjadi nominal mata uang. <em>(Contoh: Ketik 1000000 untuk potongan sebesar Rp 1.000.000)</em>.</li>
                    <li style="margin-bottom: 0.4rem;"><strong>Status (Dropdown):</strong> Pilih status aktifitas diskon ini. Pilih <strong>Aktif</strong> agar diskon dapat diterapkan oleh admin keuangan, atau <strong>Tidak Aktif</strong> jika kebijakan ini sedang ditangguhkan.</li>
                </ul>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Konfirmasi dan Simpan:</strong> Setelah semua isian telah dikonfirmasi kebenarannya, klik tombol <strong>Simpan</strong> di bagian bawah, lalu konfirmasi melalui jendela <em>pop-up</em> yang muncul.
            </li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Berbeda dengan diskon lainnya yang biasanya menggunakan <em>persentase (%)</em>, potongan Diskon Saudara Kandung ini secara baku menggunakan nominal tetap <strong>Rupiah (Rp)</strong>. Pastikan Anda memasukkan angka yang sesuai.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Diskon Saudara Kandung')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Diskon Saudara Kandung',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 10,
            ]
        );
    }
}

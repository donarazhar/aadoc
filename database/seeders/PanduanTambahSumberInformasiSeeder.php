<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahSumberInformasiSeeder extends Seeder
{
    public function run()
    {
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Master Sumber Informasi</h1>
        
        <p style="font-size: 1.125rem; margin-bottom: 1.5rem;">
            Artikel ini memandu Anda secara mendetail dalam menambahkan data <strong>Sumber Informasi</strong> ke dalam sistem Al-Azhar Apps. Data ini sangat penting pada saat calon murid baru melakukan pendaftaran (PMB), karena mereka akan diminta untuk memilih dari mana mereka mengetahui informasi pendaftaran sekolah.
        </p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Tujuan Utama:</strong> Memfasilitasi tim manajemen dan marketing sekolah untuk melacak dan menganalisis efektivitas promosi (misal: apakah pendaftar lebih banyak mengetahui informasi dari Instagram, Brosur, atau Referensi Teman).
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir</h3>
        
        <p style="margin-bottom: 1rem;">Untuk mulai menambahkan data sumber informasi baru, ikuti panduan berikut ini:</p>

        <ol style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 1rem;">
                <strong>Akses Halaman Form:</strong> 
                Pertama-tama, arahkan kursor Anda ke menu <strong>Master Data</strong> lalu pilih <strong>Sumber Informasi</strong>. Klik tombol <strong>Tambah Data</strong> yang berada di sudut kanan atas layar.<br>
                <em>(Cara cepat: Anda dapat langsung mengklik tautan berikut untuk menuju ke halaman form pengisian: <a href="/admin/master/sumber-informasi/add-sumber-informasi" style="color: #2563eb; font-weight: bold; text-decoration: underline;">admin/master/sumber-informasi/add-sumber-informasi</a>)</em>.
            </li>
            
            <li style="margin-bottom: 1rem;">
                <strong>Isi Nama Sumber Informasi:</strong> 
                Pada kolom <strong>Nama Sumber Informasi</strong>, ketikkan platform, media promosi, atau dari mana pendaftar mendapatkan info. Pastikan nama yang diketik jelas dan spesifik.
                <ul style="margin-top: 0.5rem; margin-bottom: 0.5rem; list-style-type: disc;">
                    <li><em>Contoh Media Cetak:</em> Brosur, Spanduk, Baliho, Majalah Sekolah.</li>
                    <li><em>Contoh Media Digital/Sosial:</em> Instagram Ads, Facebook Page, Website Al-Azhar, WhatsApp Blast.</li>
                    <li><em>Contoh Relasi/Referensi:</em> Alumni, Rekomendasi Teman, Guru/Pegawai, Orang Tua Murid.</li>
                </ul>
                <div style="font-size: 0.875rem; color: #ef4444; margin-top: 0.25rem;">* Perhatian: Kolom ini wajib diisi dan tidak boleh dibiarkan kosong.</div>
            </li>
            
            <li style="margin-bottom: 1rem;">
                <strong>Pilih Tingkat Sekolah (Otomatis):</strong> 
                Pada kolom pencarian <strong>Nama Sekolah</strong>, ketikkan dan pilih cabang/tingkat sekolah tempat sumber informasi ini dikelola. 
                Hal ini berguna agar data sumber informasi tersebut hanya muncul secara relevan saat orang tua mendaftar ke cabang sekolah yang bersangkutan (tidak tercampur dengan sekolah lain).
            </li>
            
            <li style="margin-bottom: 1rem;">
                <strong>Tentukan Status Penggunaan (Aktif / Tidak Aktif):</strong> 
                <ul style="margin-top: 0.5rem; margin-bottom: 0.5rem; list-style-type: circle;">
                    <li>Pilih <strong>Aktif</strong> jika kampanye pemasaran/promosi tersebut masih berjalan dan Anda ingin opsi tersebut muncul di formulir pendaftaran.</li>
                    <li>Pilih <strong>Tidak Aktif</strong> jika kampanye promosi sudah kadaluarsa atau dihentikan (contoh: "Promo Pameran Pendidikan 2024"). Status "Tidak Aktif" akan menyembunyikan opsi ini dari formulir pendaftaran murid tanpa menghapus riwayat data pendaftar sebelumnya.</li>
                </ul>
            </li>
            
            <li style="margin-bottom: 1rem;">
                <strong>Proses Validasi &amp; Simpan Data:</strong> 
                Setelah memastikan semua kolom (terutama Nama dan Status) sudah terisi dengan tepat, periksa kembali satu kali lagi. Kemudian, klik tombol biru <strong>Simpan</strong> yang berada di bagian akhir form. Jika data valid, Anda akan dialihkan kembali ke daftar sumber informasi dan notifikasi sukses akan muncul.
            </li>
        </ol>
        
        <div style="background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 0.25rem;">
            <strong>Catatan Penting (Troubleshooting):</strong> Jika Anda mendapati pesan error seperti <em>"Terjadi kesalahan saat login"</em> saat menekan tombol Simpan, ini menandakan bahwa sistem sedang mengalami masalah koneksi ke server pusat. Silakan laporkan kepada tim IT Administrator untuk melakukan pengecekan pada <em>API Gateway</em>.
        </div>

        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Master Sumber Informasi')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Master Sumber Informasi',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 16,
            ]
        );
    }
}

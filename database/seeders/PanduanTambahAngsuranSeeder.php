<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahAngsuranSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Master Angsuran (Uang Pangkal)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam membuat konfigurasi <strong>Master Angsuran</strong>. Konfigurasi ini digunakan untuk memberikan fasilitas cicilan pembayaran Uang Pangkal bagi pendaftar, agar mereka dapat membagi beban biaya ke dalam beberapa termin pembayaran sesuai kebijakan sekolah.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Fungsi Utama:</strong> Mengatur jumlah maksimal termin cicilan (Masa Angsuran), presentase biaya (%) yang dibebankan pada tiap termin, beserta batas waktu (Jatuh Tempo) pembayarannya.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Angsuran</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Dari layar admin Anda, silakan akses <strong>Master Data &gt; Angsuran</strong>. Kemudian klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau Anda dapat langsung mengakses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/angsuran/add</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Nama Sekolah (Pencarian Otomatis):</strong> 
                Ketik nama sekolah yang ingin Anda buatkan skema angsurannya. Sistem akan secara dinamis mencari nama sekolah dari <em>database</em>. Klik nama sekolah yang tepat dari <em>dropdown</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Kelas (Otomatis/Manual):</strong> 
                Sama seperti modul lainnya, jika sekolah jenjang TK maka kelas dapat dipilih secara manual, sedangkan untuk jenjang SD, SMP, dan SMA kelas akan otomatis terpilih.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Tahun Ajaran (Otomatis/Manual):</strong> 
                Tentukan tahun ajaran pendaftaran yang berlaku (Misal: 2026/2027). Tahun ajaran ini akan menentukan ketersediaan pilihan Gelombang di bawahnya.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Gelombang (Pencarian Otomatis):</strong> 
                Pilih gelombang pendaftaran yang berlaku (Misal: Gelombang 1, Gelombang 2). 
                <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Mengapa Dropdown Gelombang Kosong?</strong><br>
                    Jika pilihan Gelombang kosong, itu menandakan bahwa Anda belum pernah membuat atau mengaktifkan jadwal penerimaan murid baru (PMB) di menu pendaftaran untuk sekolah tersebut (khususnya untuk Tahun Ajaran yang Anda pilih). Gelombang harus dibuat terlebih dahulu agar bisa dipilih saat mengatur angsuran.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Status (Dropdown):</strong> 
                Atur status angsuran ini menjadi <strong>Aktif</strong> atau <strong>Tidak Aktif</strong>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Masa Angsuran (Banyak Termin):</strong><br>
                Pilih berapa kali maksimal Uang Pangkal dapat diangsur. Anda dapat memilih dari 2 kali, 3 kali, 4 kali, hingga beberapa kali angsuran sesuai opsi yang disediakan oleh sistem.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Tabel Termin Angsuran (Dinamis):</strong><br>
                Setelah memilih <em>Masa Angsuran</em>, tabel di bawahnya akan otomatis menyesuaikan jumlah barisnya (Misal Anda memilih 3 kali, maka akan muncul 3 baris: Angsuran ke-1, ke-2, dan ke-3).
                <ul>
                    <li><strong>Persentase (%):</strong> Masukkan beban persentase pembayaran untuk termin tersebut. <em>Pastikan jika ditotal dari angsuran pertama hingga terakhir jumlahnya tepat 100%.</em></li>
                    <li><strong>Batas Pembayaran / Jatuh Tempo:</strong> Pilih tanggal maksimal batas pembayaran untuk tiap-tiap termin.</li>
                </ul>
                <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Perhatian:</strong> Sistem umumnya akan memvalidasi apakah total seluruh presentase angsuran bernilai persis 100%. Jika kurang atau lebih dari 100%, sistem akan menolak penyimpanan.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Simpan Data:</strong> 
                Setelah memastikan rincian termin dan tanggal jatuh tempo sudah valid, klik tombol <strong>Simpan</strong>, lalu konfirmasi.
            </li>
        </ol>

        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Master Angsuran')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Master Angsuran',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 15,
            ]
        );
    }
}

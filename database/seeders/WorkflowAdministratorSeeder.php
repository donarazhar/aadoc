<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class WorkflowAdministratorSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada untuk menghindari error foreign key
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Alur Kerja (Workflow) Dashboard Administrator Pusat</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Untuk memastikan seluruh sistem aplikasi Al Azhar Apps berjalan dengan lancar sesuai dengan alur kerja (workflow) yang seharusnya, pengguna dengan role <strong>Administrator (Pusat)</strong> memegang peranan paling penting sebagai pembuat fondasi. Jika fondasi ini belum disiapkan, menu operasional lain (seperti PMB, Tagihan, atau input Nilai oleh Guru) tidak akan bisa berjalan.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Ringkasan Alur Delegasi:</strong> Secara garis besar, alur kerja Administrator Pusat hanya berfokus pada <em>Setup Master Data &rarr; Setup Sekolah &rarr; Setup Biaya Pusat &rarr; Setup Gelombang PMB &rarr; Pembuatan Akses Admin Sekolah</em>. Operasional harian selanjutnya akan diteruskan oleh Admin Sekolah, Keuangan, dan Guru.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 1: Setup Master Data (Pondasi Utama Sistem)</h4>
        <p>Langkah pertama yang <strong>wajib</strong> diselesaikan adalah menyiapkan parameter referensi utama. Buka menu <strong>Master Data</strong> dan kerjakan dengan urutan ini:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tahun Ajaran:</strong> Kunci utama seluruh sistem. Buat periode tahun ajaran aktif (misalnya: 2024/2025). Semua aktivitas terikat pada Tahun Ajaran.</li>
            <li><strong>Kelas & Program:</strong> Daftarkan jenjang/tingkat kelas beserta Program pendidikan (contoh: Reguler, Bilingual).</li>
            <li><strong>Kurikulum & Mata Pelajaran:</strong> Buat referensi daftar kurikulum yang berlaku (contoh: Merdeka, K13) dan masukkan daftar Mata Pelajaran.</li>
            <li><strong>Diskon & Angsuran:</strong> (Opsional) Jika yayasan memiliki kebijakan diskon pembayaran atau sistem cicilan.</li>
            <li><strong>Sumber Informasi:</strong> Buat daftar sumber informasi (brosur, medsos) untuk kebutuhan analisis data saat PMB.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 2: Manajemen Unit Sekolah</h4>
        <p>Mendefinisikan unit-unit sekolah (cabang) yang berada di bawah naungan yayasan. Buka menu <strong>Sekolah</strong>:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Sekolah:</strong> Tambahkan profil setiap unit sekolah (misal: SDIA 1, SMPIA 2). Tautkan setiap sekolah dengan jenjang pendidikan yang sesuai.</li>
            <li><strong>Rombel (Rombongan Belajar):</strong> Buat pembagian kelas riil untuk setiap unit sekolah (contoh: Kelas 1A, Kelas 1B) dan tautkan ke Tahun Ajaran yang sedang berjalan.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 3: Pembuatan Akses Pengguna (Manajemen User)</h4>
        <p>Berikan kunci masuk kepada PIC di masing-masing unit sekolah. Buka menu <strong>Manajemen User</strong>:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>User Back Office Pusat:</strong> Tambahkan staf pusat terkait jika ada.</li>
            <li><strong>Pegawai / User Sekolah:</strong> Buat akun untuk Admin Sekolah dan Kepala Sekolah pada masing-masing unit. Setelah Admin Sekolah memiliki akun, mereka bisa melanjutkan tugas mendaftarkan Guru-guru di sekolahnya.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 4: Konfigurasi Keuangan & Tagihan Inti</h4>
        <p>Langkah ini penting sebelum aplikasi dibuka untuk transaksi (PMB/Uang Sekolah). Buka menu <strong>Administrasi > Biaya</strong>:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Uang Pangkal & Uang Sekolah (SPP):</strong> Tentukan besaran/nominal tagihan bulanan (SPP) dan tagihan Uang Pangkal untuk masing-masing jenjang atau sekolah.</li>
            <li><strong>Uang Daftar Ulang & Ekstrakurikuler:</strong> Atur komponen biaya tambahan di luar biaya pokok.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 5: Persiapan Penerimaan Murid Baru (PMB)</h4>
        <p>Membuka keran pendaftaran untuk siklus penerimaan murid baru. Buka menu <strong>Administrasi > PMB</strong>:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Gelombang Pendaftaran:</strong> Buat periode/gelombang pendaftaran dan tentukan tanggal mulai serta batas penutupannya.</li>
            <li><strong>Jadwal Ujian Masuk:</strong> Atur jadwal observasi atau ujian saringan masuk untuk calon murid.</li>
        </ul>
        
        <p style="margin-top: 1.5rem;"><em>Catatan: Setelah tahap 5 selesai, calon murid sudah bisa mendaftar secara online melalui portal pendaftaran, dan operasional unit siap dijalankan.</em></p>
        </div>
        ';

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Workflow Dashboard Administrator',
            'slug' => Str::slug('Workflow Dashboard Administrator Pusat'),
            'content' => trim($htmlContent),
            'is_published' => true,
            'created_by' => $userId,
            'order' => 3,
        ]);
    }
}

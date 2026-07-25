<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class TahapanLanjutanWorkflowPMBSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada untuk menghindari error foreign key
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah & Orang Tua')],
            ['name' => 'Panduan Workflow Admin Sekolah & Orang Tua', 'description' => 'Panduan alur operasional sekolah']
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Tahapan Lanjutan Workflow PMB (Pasca Pendaftaran Orang Tua)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Berdasarkan workflow utama Al-Azhar Apps, setelah Administrator Pusat menyelesaikan Konfigurasi Master (Tahap 1) dan Orang Tua menyelesaikan pendaftaran serta pembayaran melalui Aplikasi Mobile/Web PMB (Tahap 3), maka alur selanjutnya akan sepenuhnya dikendalikan oleh <strong>Admin Sekolah</strong>.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Ringkasan Alur Operasional:</strong> Berikut adalah panduan langkah demi langkah (SOP) operasional bagi Admin Sekolah untuk menyelesaikan proses Penerimaan Murid Baru mulai dari kelulusan hingga pembagian kelas.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 4: Proses Seleksi & Penentuan Kelulusan</h4>
        <p>Pada tahap ini, Admin Sekolah akan memproses data pendaftar yang masuk dari aplikasi Orang Tua.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Akses Menu:</strong> Silakan buka dashboard Backoffice Admin, masuk ke menu <strong>Administrasi &gt; PMB &gt; Kelulusan Peserta</strong> atau <strong>Data Calon Murid</strong>.</li>
            <li><strong>Tindakan:</strong> Cari nama anak yang bersangkutan. Input skor atau hasil ujian seleksi (jika ada). Ubah status penerimaan dari "Belum Lulus / Proses" menjadi <strong>"Lulus"</strong> atau <strong>"Diterima"</strong>.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 5: Penagihan Uang Pangkal</h4>
        <p>Saat Admin Sekolah mengubah status anak menjadi "Lulus", sistem akan secara otomatis bekerja di belakang layar:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Trigger Otomatis:</strong> Sistem akan meng-generate tagihan <strong>Uang Pangkal</strong> berdasarkan setup tarif master yang dibuat Administrator di Tahap 1.</li>
            <li><strong>Tindakan Orang Tua:</strong> Orang Tua akan menerima Notifikasi (Push Notification) dan melihat tagihan tersebut di Aplikasi Mobile mereka.</li>
            <li><strong>Penyelesaian:</strong> Orang Tua diwajibkan melakukan pelunasan tagihan Uang Pangkal tersebut.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 6A: Konversi menjadi Murid Aktif</h4>
        <p>Proses ini merupakan pengesahan status pendaftar menjadi murid reguler yang diakui secara akademis.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Syarat:</strong> Tagihan Uang Pangkal sudah lunas, dan berkas persyaratan (seperti KK/Akta) sudah diverifikasi.</li>
            <li><strong>Akses Menu:</strong> Masuk ke menu <strong>Murid &gt; Murid Aktif</strong>.</li>
            <li><strong>Tindakan:</strong> Admin Sekolah (atau fungsi auto-trigger sistem) memvalidasi data dan menekan tombol Konversi. Status data akan berubah dari tabel <em>Admissions</em> (Calon Murid) berpindah ke tabel <em>Students</em> (Murid Aktif). Murid akan secara resmi mendapatkan NIS (Nomor Induk Siswa).</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Tahap 6B: Setup Rombel / Pembagian Kelas</h4>
        <p>Ini adalah tahap final dari alur PMB, sebelum memasuki siklus akademik berjalan.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Akses Menu:</strong> Buka menu <strong>Sekolah &gt; Rombel (Rombongan Belajar)</strong>.</li>
            <li><strong>Tindakan:</strong> Buat Rombel baru jika belum ada (misal: "TK A - Mekkah"). Masukkan murid-murid baru yang sudah berstatus aktif (memiliki NIS) ke dalam Rombel tersebut.</li>
            <li><strong>Siklus Bulanan Aktif:</strong> Sejak murid dimasukkan ke Rombel, sistem penagihan biaya rutinan seperti <strong>SPP</strong> bulanan akan mulai berputar dan otomatis diterbitkan ke aplikasi Orang Tua setiap bulannya.</li>
        </ul>
        
        <p style="margin-top: 1.5rem;"><em>Catatan: Dokumen ini merupakan panduan SOP standar untuk memperjelas alur kerja antara Admin Pusat, Orang Tua, dan Admin Sekolah.</em></p>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Tahapan Lanjutan Workflow PMB Seleksi Kelulusan s.d Rombel')],
            [
                'category_id' => $categoryId,
                'title' => 'Tahapan Lanjutan Workflow PMB (Seleksi Kelulusan s.d Rombel)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 1,
            ]
        );
    }
}

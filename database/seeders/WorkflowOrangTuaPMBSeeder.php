<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class WorkflowOrangTuaPMBSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Workflow PMB: Panduan Pendaftaran Orang Tua (Mobile/Web)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Dalam alur Penerimaan Murid Baru (PMB), peran aktif <strong>Orang Tua / Wali Murid</strong> sangat krusial sebagai pendaftar utama. Tahapan pendaftaran ini (Tahap 3) menjembatani persiapan yang telah dilakukan oleh Administrator Pusat dengan proses seleksi yang akan dilakukan oleh Admin Sekolah.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Proses pendaftaran dapat dilakukan melalui Aplikasi Mobile Al-Azhar Apps (Tersedia di Play Store / App Store) maupun Portal Web PMB khusus pendaftaran daring.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah 1: Registrasi / Akses Masuk Aplikasi</h4>
        <p>Bagi orang tua yang baru pertama kali mendaftar, langkah pertama adalah membuat akun Wali Murid.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Mendaftar Akun:</strong> Orang tua wajib melakukan pendaftaran dengan memasukkan Nomor Induk Kependudukan (NIK) orang tua, Nama Lengkap, Nomor HP/WhatsApp aktif, serta alamat Email.</li>
            <li><strong>Verifikasi (OTP/PIN):</strong> Setelah mendaftar, orang tua akan mengatur PIN (6-digit) sebagai akses masuk keamanan ke dalam aplikasi.</li>
            <li><strong>Login:</strong> Masukkan Nomor HP dan PIN yang telah dibuat untuk masuk ke Dashboard Beranda aplikasi.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah 2: Memulai Pendaftaran Anak (Calon Murid)</h4>
        <p>Di halaman Beranda aplikasi, orang tua akan menemukan menu khusus <strong>PMB (Penerimaan Murid Baru)</strong>.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Pilih opsi pendaftaran anak baru.</li>
            <li><strong>Pengisian Biodata:</strong> Orang tua wajib melengkapi formulir data diri Calon Murid secara akurat, mulai dari NIK anak, Nama Lengkap, Tempat Tanggal Lahir, hingga asal sekolah (jika ada).</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah 3: Memilih Sekolah Tujuan & Jadwal Ujian</h4>
        <p>Ini adalah bagian krusial di mana orang tua menentukan tujuan pendidikan anaknya dan kapan akan mengikuti ujian observasi/seleksi.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Pemilihan Unit Sekolah:</strong> Sistem akan menampilkan daftar unit sekolah (contoh: TKIA 1, SDIA 2) beserta opsi jenjang pendidikan yang dibuka.</li>
            <li><strong>Gelombang Pendaftaran:</strong> Orang tua memilih gelombang yang sedang aktif.</li>
            <li><strong>Jadwal Ujian Masuk:</strong> Orang tua akan dihadapkan pada pilihan slot jadwal ujian masuk (Tanggal & Jam) yang sebelumnya telah dirilis oleh Admin Sekolah terkait. Pilihlah jadwal ujian yang memungkinkan untuk dihadiri.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah 4: Pembayaran Biaya Pendaftaran (Formulir)</h4>
        <p>Setelah formulir disubmit, status pendaftaran belum bersifat final hingga pembayaran biaya pendaftaran diselesaikan.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Invoicing:</strong> Sistem secara otomatis akan merilis Tagihan Pendaftaran (Uang Formulir).</li>
            <li><strong>Pembayaran:</strong> Orang tua dapat memilih berbagai metode pembayaran yang didukung (Virtual Account, QRIS, e-Wallet) langsung di dalam aplikasi.</li>
            <li>Begitu pembayaran terkonfirmasi lunas oleh sistem, status Calon Murid akan sah terdaftar dan berkas pendaftarannya diteruskan ke meja dashboard Admin Sekolah.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah 5: Pelaksanaan Ujian & Menunggu Hasil</h4>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Pada tanggal yang telah dipilih, anak akan mengikuti ujian tes/observasi baik secara tatap muka (offline) maupun daring (sesuai kebijakan sekolah).</li>
            <li>Orang tua cukup memantau status kelulusan secara real-time dari aplikasi. Jika dinyatakan <strong>Lulus</strong> oleh sekolah, akan muncul notifikasi beserta rincian tagihan Daftar Ulang / Uang Pangkal.</li>
        </ul>
        
        <p style="margin-top: 1.5rem;"><em>Penting: Alur pendaftaran mandiri ini dirancang untuk memaksimalkan efisiensi dan transparansi bagi pihak keluarga pendaftar.</em></p>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Workflow PMB Panduan Pendaftaran Orang Tua Mobile Web')],
            [
                'category_id' => $categoryId,
                'title' => 'Workflow PMB: Panduan Pendaftaran Orang Tua (Mobile/Web)',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 2, // Di antara Administrator Pusat dan Admin Sekolah
            ]
        );
    }
}

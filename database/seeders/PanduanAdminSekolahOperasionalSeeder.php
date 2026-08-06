<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanAdminSekolahOperasionalSeeder extends Seeder
{
    public function run()
    {
        $categoryName = 'Panduan Workflow Admin Sekolah';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Panduan alur kerja untuk Admin Sekolah terkait operasional harian, mulai dari PMB hingga pengaturan rombel.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Workflow Admin Sekolah (Part 4): Operasional Keuangan & Akademik (LMS)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Setelah murid resmi berada di dalam Rombongan Belajar (Rombel), fokus administrasi sekolah akan bergeser dari PMB menuju ke kegiatan operasional sekolah sehari-hari. Pada tahap ini, sistem aplikasi akan melayani dua pilar utama: Keuangan Rutin dan Akademik.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">A. Manajemen Keuangan & Tagihan Rutin (SPP)</h4>
        <p>Sistem dirancang untuk men-<em>generate</em> tagihan bulanan secara otomatis tanpa campur tangan manual setiap bulannya, selama setup tarif sudah benar.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>SPP Bulanan:</strong> Setiap awal bulan (tanggal 1), sistem akan memunculkan tagihan SPP ke aplikasi Orang Tua. Anda bisa men-<em>setup</em> dan mengelola tagihan SPP melalui menu <strong>Administrasi &gt; Biaya &gt; Uang Sekolah</strong>. Untuk memantau pergerakan kas dan tunggakan, Anda dapat menggunakan menu <strong>Laporan &gt; Keuangan &gt; Keuangan Murid</strong>.</li>
            <li><strong>Biaya Tambahan:</strong> Untuk kegiatan ekskul atau lainnya, Anda dapat membuat tagihan khusus melalui menu <strong>Administrasi &gt; Biaya &gt; Uang Ekstrakulikuler</strong>.</li>
            <li><strong>Daftar Ulang:</strong> Di awal semester atau tahun ajaran baru, Anda bisa men-<em>generate</em> tagihan Daftar Ulang bagi seluruh murid aktif melalui menu <strong>Administrasi &gt; Biaya &gt; Uang Daftar Ulang</strong> agar mereka bisa melanjutkan studi.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">B. Manajemen Pembelajaran (LMS) & Akademik</h4>
        <p>Aplikasi Al-Azhar Apps dilengkapi dengan fitur LMS (Learning Management System) yang digunakan oleh Guru dan dikelola oleh Admin Sekolah.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Jurnal Pembelajaran:</strong> Setiap hari, guru (melalui portal guru) diwajibkan mengisi Jurnal Pembelajaran dan Absensi. Admin dapat merekap tingkat kehadiran guru dan murid di menu <strong>LMS &gt; Jurnal</strong>.</li>
            <li><strong>Penilaian dan Ujian:</strong> Pada masa PTS atau PAS, guru akan menginput (submit) nilai murid. Wali Kelas kemudian dapat memeriksa kelengkapan nilai dari menu <strong>LMS &gt; Leger Nilai</strong>.</li>
            <li><strong>Cetak Raport:</strong> Setelah semua nilai valid, wali kelas (atau admin) dapat mencetak raport murid langsung dari sistem untuk dibagikan ke Orang Tua (<strong>LMS &gt; Download Raport</strong>).</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">C. Mutasi Akademik (Akhir Tahun Ajaran)</h4>
        <p>Siklus satu tahun akan ditutup dengan proses mutasi akademik.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Kenaikan Kelas:</strong> Melalui menu <strong>Akademik &gt; Mutasi &gt; Kenaikan Kelas</strong>, Admin dapat memindahkan (promosi) seluruh murid di suatu Rombel ke Rombel di tingkat atasnya secara kolektif (massal).</li>
            <li><strong>Kelulusan (Alumni):</strong> Bagi murid tingkat akhir (misal Kelas 6 SD, 9 SMP, 12 SMA), mereka akan diproses menjadi <strong>Alumni</strong>, yang sekaligus akan menonaktifkan tagihan otomatis mereka untuk bulan-bulan berikutnya.</li>
        </ul>
        
        <div style="background-color: #f8fafc; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; margin-top: 2rem;">
            <p style="margin: 0; font-size: 0.95rem; color: #475569;"><strong>Kesimpulan:</strong> Siklus operasional ini akan terus berulang dari tahun ke tahun. Pastikan Setup Master dan Tarif Keuangan di-<em>review</em> setiap kali menjelang tahun ajaran baru (T.A. Baru).</p>
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah (Part 4): Operasional Keuangan & Akademik (LMS)')],
            [
                'title' => 'Panduan Workflow Admin Sekolah (Part 4): Operasional Keuangan & Akademik (LMS)',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 80,
            ]
        );
    }
}

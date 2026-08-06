<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanAnalisaStrukturMenuSeeder extends Seeder
{
    public function run()
    {
        $categoryName = 'Analisa Sistem & UI/UX';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Kumpulan dokumen hasil analisa sistem, desain antarmuka, dan pengalaman pengguna.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Analisa & Rekomendasi Struktur Menu Dashboard Admin (UI/UX)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini menyajikan hasil analisis terhadap struktur <em>sidebar menu</em> pada Dashboard Backoffice Al-Azhar Apps saat ini. Analisis ini dititikberatkan pada alur kerja (<em>workflow</em>) dan kemudahan pengguna (<em>User Experience</em> / UX), khususnya bagi <strong>Administrator Pusat</strong> dan <strong>Admin Sekolah</strong>.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">1. Analisa Kondisi Saat Ini (Existing Structure)</h4>
        <p>Secara keseluruhan, fungsionalitas sistem telah tercakup dengan baik. Namun, secara arsitektur informasi, terdapat beberapa kendala yang berpotensi menyulitkan pengguna baru dalam memahami alur sistem:</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Redundansi Menu PMB:</strong> Fitur terkait PMB saat ini tersebar di tiga area berbeda: <em>Transaksi &gt; PMB</em>, <em>Sekolah &gt; PMB</em>, dan <em>Administrasi &gt; PMB</em> (yang memuat menu Animo, Jadwal Ujian, dsb). Sebaran ini memaksa Admin Sekolah untuk berpindah-pindah kategori hanya untuk menyelesaikan satu siklus penerimaan murid.</li>
            <li><strong>Pemisahan Data Kesiswaan:</strong> Menu "Data Calon Murid" diletakkan di bawah kategori <em>Administrasi</em>, sementara "Data Murid Aktif" berada di bawah kategori <em>Sekolah</em>. Pemisahan identitas yang esensinya sama (Kesiswaan) mengurangi efisiensi pencarian data.</li>
            <li><strong>Tumpang Tindih Kategorisasi:</strong> Terdapat ambiguitas antara kategori <em>Sekolah</em> dan <em>Administrasi</em>. Beberapa fitur operasional kesiswaan dan keuangan terbagi secara tidak merata di kedua kategori ini.</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">2. Rekomendasi Restrukturisasi Berdasarkan Workflow</h4>
        <p>Untuk menciptakan pengalaman pengguna yang intuitif, struktur menu sebaiknya dirancang sejalan dengan kronologi operasional sekolah dari awal tahun hingga akhir tahun. Berikut adalah usulan struktur hierarki <em>sidebar</em> yang ideal:</p>
        
        <div style="background-color: #f8fafc; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ol style="margin-left: 1rem; font-weight: 500; color: #1e293b;">
                <li style="margin-bottom: 0.75rem;"><strong>Dashboard</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Berisi Summary, Grafik Kinerja, dan Statistik Umum.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Penerimaan Murid Baru (PMB)</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Penyatuan seluruh alur PMB mulai dari: Gelombang Pendaftaran &rarr; Data Animo &rarr; Jadwal Ujian &rarr; Kelulusan &rarr; Transaksi Uang Pangkal.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Kesiswaan & Akademik</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Fokus pada operasional harian: Data Murid Aktif, Rombel, LMS (Jurnal, Leger, Raport), Ekstrakurikuler, Prestasi, dan Mutasi Akademik.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Keuangan & Tagihan</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Penyatuan fungsi finansial: Tagihan SPP, Daftar Ulang, Biaya Tambahan, Pengajuan Diskon, dan Angsuran.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Laporan (Report)</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Kumpulan rekapitulasi data: Laporan Keuangan, Settlement, dan Log Aktivitas.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Manajemen Pengguna</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Pengaturan akses untuk Pegawai, User Pusat, dan User Sekolah.</span></li>
                <li style="margin-bottom: 0.75rem;"><strong>Master Data (Konfigurasi)</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Fondasi sistem yang jarang diubah: Tahun Ajaran, Master Kelas, Program, Mata Pelajaran, dan Tarif Dasar.</span></li>
            </ol>
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">3. Kesimpulan & Manfaat</h4>
        <p>Dengan menerapkan struktur rekomendasi di atas, pengguna sistem (terutama Admin Sekolah yang intensitas penggunaannya tinggi) akan merasakan alur navigasi top-down yang selaras dengan kalender akademik. Saat musim penerimaan, mereka hanya berfokus pada menu nomor 2. Saat kegiatan belajar mengajar berjalan, fokus mereka secara natural akan turun ke menu nomor 3 dan 4.</p>
        <p>Restrukturisasi ini dipercaya mampu menurunkan tingkat kebingungan pengguna baru (<em>learning curve</em>) secara signifikan, sekaligus meminimalisir kesalahan prosedur di lapangan akibat menu operasional yang tersebar.</p>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Analisa dan Rekomendasi Struktur Menu Dashboard Admin')],
            [
                'title' => 'Analisa & Rekomendasi Struktur Menu Dashboard Admin (UI/UX)',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 10,
            ]
        );
    }
}

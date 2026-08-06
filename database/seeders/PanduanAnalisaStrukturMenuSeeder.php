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

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">2. Restrukturisasi Berdasarkan Workflow (Tetap Mempertahankan Redaksi Asli)</h4>
        <p>Untuk menciptakan pengalaman pengguna yang intuitif, struktur menu telah disusun ulang sejalan dengan kronologi operasional sekolah dari hulu ke hilir. Sebagai catatan penting, <strong>semua penamaan menu (redaksi/label) tetap dibiarkan persis sama</strong> seperti versi aslinya (misalnya "Sekolah" tidak diubah menjadi "Konfigurasi Sekolah") agar tidak mengganggu familiaritas pengguna lama. Semua menu tersebut kini dikelompokkan secara cerdas ke dalam 7 (Tujuh) Payung Utama berikut:</p>
        
        <div style="background-color: #f8fafc; padding: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ol style="margin-left: 1rem; font-weight: 500; color: #1e293b;">
                <li style="margin-bottom: 1.25rem;"><strong>Dashboard</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Berisi Summary Kinerja dan statistik umum.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Summary, Sekolah, Murid, Keuangan, Marketing, Dashboard (LMS).</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>Penerimaan Murid Baru (PMB)</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Menampung seluruh operasional penerimaan (PMB) dan kelola Data Calon Murid secara terpusat dalam satu grup.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> PMB, Data Calon Murid.</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>Keuangan & Transaksi</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Penyatuan seluruh fungsi finansial mulai dari Tagihan Uang Pangkal, Uang Sekolah/SPP, Biaya, hingga Pengajuan Diskon dan Angsuran.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Tagihan Uang Pangkal, Uang Sekolah, Biaya, Diskon, Penerimaan.</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>Kesiswaan & Akademik</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Fokus pada operasional kesiswaan berjalan seperti Rombel, Murid, Ekstrakurikuler, Prestasi, dan Mutasi Akademik.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Akademik, Rombel, Murid, Data Murid, Ekstrakulikuler, Prestasi.</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>LMS (Guru & Pembelajaran)</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Memusatkan fungsionalitas harian guru seperti Jurnal, Leger, Submit Nilai, E-Rapot, dan Ijazah.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Jurnal, Leger, Submit Nilai, E-Rapot, Ijazah.</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>Laporan</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Menjadi satu-satunya pintu untuk menarik Laporan Keuangan dan Settlement.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Keuangan (Laporan).</li>
                    </ul>
                </li>
                <li style="margin-bottom: 1.25rem;"><strong>Master Data & Konfigurasi</strong> <br><span style="font-weight: 400; font-size: 0.95rem; color: #475569;">Penyatuan besar-besaran untuk seluruh data fondasi sistem (seperti Tahun Ajaran, Kelas, Kurikulum, Kalender), Konfigurasi Sekolah, hingga Manajemen User dan Pegawai. Semua pengaturan ada di sini.</span>
                    <ul style="font-size: 0.85rem; color: #64748b; margin-top: 0.25rem; margin-left: 1.5rem; list-style-type: circle;">
                        <li><strong>Menu yang digabungkan:</strong> Kelas, Program, Kurikulum, Mata Pelajaran, Tahun Ajaran, Diskon (Master), Angsuran, Sumber Informasi, Sekolah, Profile Sekolah, Sarana Prasarana, Kalender, User Back Office Pusat, User Sekolah, Log Activity, Pegawai.</li>
                    </ul>
                </li>
            </ol>
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">3. Kesimpulan & Manfaat</h4>
        <p>Dengan menerapkan struktur rekomendasi yang solid tanpa memecah atau menghilangkan menu orisinal mana pun, pengguna sistem (terutama Admin Sekolah) kini dapat beroperasi dengan jauh lebih intuitif. Saat musim penerimaan, fokus mereka hanya ada di menu PMB (grup ke-2). Begitu tahun ajaran berjalan, fokus mereka secara natural akan bergeser ke menu Kesiswaan, Keuangan, dan LMS.</p>
        <p>Pendekatan ini menjembatani dua kebutuhan penting sekaligus: <strong>kemudahan bagi user baru</strong> (lewat alur yang kronologis) dan <strong>mempertahankan kenyamanan user lama</strong> (dengan tidak mengubah nama-nama redaksi menu sama sekali).</p>
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

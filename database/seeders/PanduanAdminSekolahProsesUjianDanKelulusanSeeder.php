<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanAdminSekolahProsesUjianDanKelulusanSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Workflow Admin Sekolah (Part 2): Ujian, Kelulusan, dan Uang Pangkal</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Setelah Orang Tua melengkapi formulir pendaftaran dan berkas diverifikasi, calon murid akan memasuki tahapan penjadwalan dan evaluasi penerimaan. Proses ini mencakup pembuatan jadwal ujian, pengelolaan peserta, penginputan nilai kelulusan, dan terakhir penerbitan tagihan Uang Pangkal (DSP).</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">4. Fase Penjadwalan & Persiapan Ujian (Menu: Ujian & Seleksi)</h4>
        <p><strong>Kondisi:</strong> Formulir telah di-submit oleh Orang Tua, dan status calon murid berada pada fase <strong>"Menunggu Ujian"</strong>. Anda perlu menentukan kapan dan di mana ujian diselenggarakan.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu <strong>Ujian & Seleksi &gt; Jadwal Ujian</strong> untuk membuat ruang atau slot waktu ujian baru. Atur kuota ruangan, tanggal, dan pengawas ujian (jika ada).</li>
                    <li>Setelah jadwal terbuat, buka menu <strong>Peserta Ujian</strong> untuk melihat seluruh kandidat yang akan mengikuti tes.</li>
                    <li>Lakukan <strong>Plotting</strong> (memasukkan) nama calon murid ke jadwal ujian yang telah Anda siapkan. Orang Tua akan otomatis mendapat notifikasi di aplikasi mereka terkait jadwal tes anak tersebut.</li>
                    <li>Jika sekolah Anda menggunakan sistem ujian daring (CBT), Anda dapat mengeklik ikon <strong>Generate Akses</strong> untuk membuatkan <em>username</em> dan <em>password</em> ujian secara otomatis.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">5. Fase Kelulusan & Input Nilai (Menu: Kelulusan)</h4>
        <p><strong>Kondisi:</strong> Ujian seleksi / observasi telah dilaksanakan. Sistem membutuhkan konfirmasi akhir dari sekolah mengenai hasil seleksi tersebut.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <strong>Ujian & Seleksi &gt; Kelulusan</strong></li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka tab <strong>"Belum Diproses"</strong> untuk melihat daftar anak yang berstatus <em>"Menunggu Hasil Ujian"</em>.</li>
                    <li>Klik tombol <strong>Input Nilai</strong> pada baris calon murid. Masukkan hasil seleksi akademik, wawancara, maupun tes kesehatan/psikologi.</li>
                    <li>Tentukan keputusan akhir dengan menekan tombol <strong>"Luluskan (Diterima)"</strong> atau <strong>"Tolak"</strong>.</li>
                    <li>Begitu status diubah menjadi <em>Luluskan</em>, sistem seketika mem-<em>publish</em> hasil kelulusan ke aplikasi Orang Tua.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">6. Fase Pembayaran Uang Pangkal / Uang PMB (Menu: Transaksi Uang Pangkal)</h4>
        <p><strong>Kondisi:</strong> Calon murid resmi "Diterima". Orang Tua wajib melunasi Uang Pangkal (DSP) sebagai syarat daftar ulang.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Tepat setelah tombol "Luluskan" ditekan, mesin tagihan sistem secara otomatis menghitung besaran Uang Pangkal berdasarkan Gelombang, Jenjang, Program, dan Diskon otomatis yang mungkin berlaku. Tagihan langsung muncul di akun Orang Tua.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu <strong>Transaksi Uang Pangkal &gt; Data PMB</strong> untuk memantau invoice yang terbit.</li>
                    <li>Kolom "Uang PMB" yang tadinya kosong kini akan terisi angka riil.</li>
                    <li>Jika status pembayaran telah Lunas, calon murid dipersilakan melanjutkan ke <strong>Fase Daftar Ulang (Part 3)</strong>.</li>
                </ul>
            </li>
        </ul>

        <div style="background-color: #f0f9ff; padding: 1rem; border-left: 4px solid #0284c7; border-radius: 0.25rem; margin-bottom: 1.5rem; margin-top: 2rem;">
            <strong style="color: #0284c7;">Catatan Penting:</strong><br>
            Jangan heran jika kolom nominal "Uang PMB" di laporan Anda masih bernilai 0 (kosong) saat anak berstatus Menunggu Ujian. Nominal tagihan uang pangkal hanya akan di-<em>generate</em> secara sistematis <strong>setelah</strong> anak tersebut berstatus Diterima/Lulus.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah (Part 2): Ujian, Kelulusan, dan Uang Pangkal')],
            [
                'title' => 'Panduan Workflow Admin Sekolah (Part 2): Ujian, Kelulusan, dan Uang Pangkal',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 60,
            ]
        );
    }
}

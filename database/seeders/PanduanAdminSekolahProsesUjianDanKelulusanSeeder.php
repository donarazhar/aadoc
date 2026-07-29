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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Lanjutan PMB: Proses Ujian, Kelulusan, dan Uang Pangkal</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Setelah Orang Tua melengkapi formulir pendaftaran secara daring, calon murid akan memasuki tahapan evaluasi dan penerimaan. Proses ini mencakup pengelolaan peserta ujian, penginputan nilai kelulusan, dan terakhir penerbitan tagihan uang pangkal.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">4. Fase Persiapan Ujian (Menu: Daftar Peserta Ujian)</h4>
        <p><strong>Kondisi:</strong> Formulir telah di-submit oleh Orang Tua, dan status calon murid kini berada pada fase <strong>"Menunggu Ujian"</strong>.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <code>admin/peserta</code></li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Pada halaman <strong>Daftar Peserta Ujian</strong>, Anda dapat melihat seluruh kandidat yang akan mengikuti tahapan seleksi tes/observasi.</li>
                    <li>Jika sekolah Anda menggunakan sistem ujian daring (CBT), Anda dapat mengeklik ikon <strong>Generate Akses</strong> untuk membuatkan <em>username</em> dan <em>password</em> ujian secara otomatis bagi murid.</li>
                    <li>Orang Tua selanjutnya akan bisa melihat akses ujian tersebut di aplikasi <em>mobile</em> mereka.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">5. Fase Kelulusan & Input Nilai (Menu: Evaluasi Kelulusan)</h4>
        <p><strong>Kondisi:</strong> Ujian seleksi / observasi telah dilaksanakan. Sistem membutuhkan konfirmasi akhir dari sekolah mengenai hasil seleksi tersebut.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <code>admin/kelulusan</code></li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu Kelulusan dan masuk ke tab <strong>"Belum Diproses"</strong> untuk melihat daftar anak yang baru saja selesai ujian (status <em>"Menunggu Hasil Ujian"</em>).</li>
                    <li>Klik tombol <strong>Input Nilai</strong> pada nama calon murid. Anda dapat memasukkan nilai berdasarkan komponen tes (seperti aspek observasi visual, auditori, bahasa, dsb.).</li>
                    <li>Tentukan keputusan akhir kelulusan dengan menekan tombol <strong>"Luluskan (Diterima)"</strong> atau <strong>"Tolak"</strong>.</li>
                    <li>Setelah klik <em>Luluskan</em>, sistem akan otomatis mengirimkan notifikasi kelulusan ke aplikasi Orang Tua.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">6. Fase Pembayaran Uang Pangkal / Uang PMB (Menu: Transaksi PMB)</h4>
        <p><strong>Kondisi:</strong> Calon murid telah dinyatakan "Diterima", yang berarti mereka resmi berstatus sebagai kandidat murid sekolah Anda. Orang Tua harus melunasi Uang Pangkal (Uang PMB) sebelum proses daftar ulang selesai.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <code>admin/transaksi/pmb</code> (Tab: PMB)</li>
            <li><strong>Tindakan Otomatis Sistem:</strong> Tepat setelah Anda menekan tombol "Luluskan" di fase sebelumnya, sistem secara ajaib <em>(otomatis)</em> menghitung besaran tagihan Uang Pangkal sesuai jenjang, program, dan diskon yang berlaku, lalu menagihkannya ke akun Orang Tua.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Anda bisa masuk ke menu <strong>Transaksi PMB</strong> untuk memantau nilai pada kolom <strong>Uang PMB</strong> yang kini sudah terisi (sebelumnya kolom ini kosong atau <code>-</code> ketika anak masih Menunggu Ujian).</li>
                    <li>Pantau status pembayarannya. Jika statusnya sudah lunas, maka murid tersebut sepenuhnya sudah menyelesaikan siklus PMB awal.</li>
                </ul>
            </li>
        </ul>

        <div style="background-color: #f0f9ff; padding: 1rem; border-left: 4px solid #0284c7; border-radius: 0.25rem; margin-bottom: 1.5rem; margin-top: 2rem;">
            <strong style="color: #0284c7;">Catatan Penting:</strong><br>
            Jangan heran jika kolom "Uang PMB" kosong saat anak belum dievaluasi. Nominal tagihan uang pangkal hanya akan terbentuk (di-generate) <strong>setelah</strong> anak tersebut berstatus Diterima/Lulus.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Lanjutan PMB: Proses Ujian, Kelulusan, dan Uang Pangkal')],
            [
                'title' => 'Lanjutan PMB: Proses Ujian, Kelulusan, dan Uang Pangkal',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 60,
            ]
        );
    }
}

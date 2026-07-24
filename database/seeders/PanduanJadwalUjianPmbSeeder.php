<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanJadwalUjianPmbSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Persiapan PMB Administrator')],
            [
                'name' => 'Setup Persiapan PMB Administrator',
                'description' => 'Panduan tahap kelima (terakhir) terkait persiapan Penerimaan Murid Baru oleh Administrator.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Jadwal Ujian/Observasi Masuk</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Langkah penting dalam persiapan PMB adalah membuat Jadwal Ujian Saringan Masuk atau Observasi. Jadwal ini nantinya akan dipilih oleh calon pendaftar saat mereka melengkapi formulir pendaftaran.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah-langkah Penambahan Jadwal Ujian:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Akses form penambahan jadwal melalui menu <strong>Administrasi &gt; PMB &gt; Jadwal Ujian</strong> lalu klik Tambah, atau akses langsung melalui link: <code style="background-color: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.875em; color: #db2777;">/admin/master/jadwal-ujian/add-jadwal/add?tab=entrance_exam</code>.</li>
            <li><strong>Nama Ujian:</strong> Masukkan nama kegiatan ujian (contoh: "Ujian Gelombang 1 - Tahap 1").</li>
            <li><strong>Jenjang:</strong> Kolom ini akan terisi dan terkunci secara otomatis sesuai dengan unit sekolah akun Anda. <em>(Pengecualian: Khusus untuk peran Administrator, dropdown ini terbuka dan dapat dipilih secara bebas)</em>.</li>
            <li><strong>Tingkat Kelas &amp; Gelombang:</strong> Pilih kelas tujuan dan tautkan ujian ini ke Gelombang PMB yang sedang dibuka.</li>
            <li><strong>Tipe Ujian:</strong> Pilih mode pelaksanaan ujian (<strong>Offline</strong> atau <strong>Online</strong>). <em>Catatan: Untuk unit TK/SD, tipe ujian umumnya akan otomatis terkunci ke Offline.</em></li>
            <li><strong>Ruangan / Link Ujian:</strong>
                <ul style="list-style-type: disc; margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li>Jika Anda memilih <em>Offline</em>, kolom <strong>Ruangan</strong> akan muncul. Pilih ruangan dari daftar fasilitas sekolah.</li>
                    <li>Jika Anda memilih <em>Online</em>, kolom <strong>Link Online</strong> akan muncul. Masukkan tautan *meeting* jarak jauh (misal: link Zoom).</li>
                </ul>
            </li>
            <li><strong>Keterangan:</strong> Tuliskan deskripsi atau instruksi tambahan bagi peserta (contoh: "Harap membawa pensil 2B dan papan dada").</li>
            <li><strong>Waktu Pelaksanaan:</strong>
                <ul style="list-style-type: disc; margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0.5rem;">
                    <li>Pilih <strong>Tanggal Ujian Masuk</strong>.</li>
                    <li>Tentukan <strong>Jam Ujian Mulai</strong> dan <strong>Jam Ujian Selesai</strong> secara spesifik.</li>
                </ul>
            </li>
            <li>Setelah semua data dipastikan benar, klik tombol <strong>Simpan</strong> di bagian bawah halaman.</li>
        </ol>

        <div style="background-color: #f0fdf4; border-left: 4px solid #4ade80; padding: 1rem; margin-top: 1.5rem; border-radius: 0.25rem;">
            <strong>Catatan Penting (Sumber Data):</strong> Pastikan Anda telah membuat data referensi terlebih dahulu sebelum membuat Jadwal Ujian.
            <ul style="list-style-type: disc; margin-left: 1.5rem; margin-top: 0.5rem; margin-bottom: 0;">
                <li><strong>Gelombang:</strong> Mengambil data dari endpoint <code style="background-color: #dcfce7; padding: 0.1rem 0.3rem; border-radius: 0.25rem; font-size: 0.875em; color: #166534;">/school-new/batch</code>. (Data ini berasal dari menu Master Data &gt; Gelombang atau Administrasi &gt; PMB &gt; Gelombang yang sebelumnya telah diinputkan oleh user/panitia).</li>
                <li><strong>Tingkat Kelas:</strong> Mengambil data dari endpoint <code style="background-color: #dcfce7; padding: 0.1rem 0.3rem; border-radius: 0.25rem; font-size: 0.875em; color: #166534;">/school-new/master/class</code>. (Data ini adalah referensi master kelas yang ditarik secara spesifik berdasarkan jenjang sekolah dari akun yang sedang login. Misalnya akun SD otomatis hanya akan ditarik kelas 1 s.d. 6).</li>
            </ul>
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Setup Jadwal Ujian PMB')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Jadwal Ujian/Observasi',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 32,
            ]
        );
    }
}

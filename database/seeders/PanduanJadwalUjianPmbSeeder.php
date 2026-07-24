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
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Setelah membuat Gelombang PMB, langkah persiapan krusial yang terakhir adalah mengatur kuota dan jadwal Ujian Saringan Masuk (untuk SMP/SMA) atau Observasi (untuk TK/SD). Calon pendaftar wajib memilih jadwal ujian ini saat melengkapi data pendaftaran online.</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah-langkah Penambahan Jadwal Ujian:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Buka menu <strong>Master Data &gt; Jadwal Ujian</strong> (atau Administrasi &gt; PMB &gt; Jadwal Ujian).</li>
            <li>Klik tombol <strong>Tambah Jadwal Ujian</strong> atau akses langsung melalui link <code style="background-color: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.875em; color: #db2777;">/admin/master/jadwal-ujian/add-jadwal/add?tab=entrance_exam</code>.</li>
            <li><strong>Jenjang & Gelombang:</strong> Tautkan jadwal ujian ini untuk pendaftar di Jenjang dan Gelombang mana.</li>
            <li><strong>Hari & Tanggal Pelaksanaan:</strong> Tentukan tanggal pasti kapan ujian/observasi tersebut akan dilangsungkan.</li>
            <li><strong>Waktu Mulai & Selesai:</strong> Masukkan jam mulainya ujian dan estimasi selesai (misal: 08:00 - 11:30).</li>
            <li><strong>Kuota Ujian:</strong> Masukkan batasan maksimal peserta (misalnya: 50). Sistem pendaftaran akan otomatis mencegah calon pendaftar memilih jadwal ini jika kuotanya sudah habis dipesan oleh pendaftar lain.</li>
            <li><strong>Ruangan / Tempat Ujian:</strong> Tuliskan nama ruangan ujian atau tautan *online meeting* jika seleksi dilakukan secara jarak jauh.</li>
            <li>Klik tombol <strong>Simpan</strong>.</li>
        </ol>

        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 1.5rem; border-radius: 0.25rem;">
            <strong>Tips Operasional:</strong> Disarankan membuat beberapa opsi jadwal pada tanggal dan jam yang berbeda (atau ruang yang berbeda) jika antusiasme pendaftar pada gelombang tersebut diprediksi sangat tinggi. Ini membantu mengurai kepadatan panitia seleksi.
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class TahunAjaranSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan kategori ada
        $category = Category::firstOrCreate(
            ['slug' => 'setup-panduan'],
            ['name' => 'Setup & Panduan', 'description' => 'Panduan instalasi dan setup lokal aplikasi']
        );

        // 2. Pastikan user pembuat ada (merujuk ke UserSeeder)
        $user = User::where('email', 'donarazhar@gmail.com')->first();
        $userId = $user ? $user->id : 1;

        // 3. Konten HTML
        $content = <<<'HTML'
<div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
    <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Pengisian: Master Tahun Ajaran</h1>
    <p style="font-size: 1.125rem; margin-bottom: 2rem;">Berikut adalah panduan lengkap cara pengisian form <strong>Tambah Tahun Ajaran</strong> di menu <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/master/tahun-ajaran/add</code> berdasarkan struktur formulir di sistem. Semua kolom di bawah ini bersifat wajib (<code style="background: #fef2f2; color: #ef4444; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">required</code>).</p>
    
    <hr style="border: 0; height: 1px; background: #e2e8f0; margin: 2rem 0;">

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">1. Tahun Ajaran Awal (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">start_year</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Tahun kalender di mana semester tersebut dimulai.</li>
        <li><strong>Cara Isi:</strong> Ketikkan angka tahun penuh (4 digit).</li>
        <li><strong>Contoh:</strong> <strong>2026</strong> (jika rentang tahun ajaran adalah 2026/2027).</li>
    </ul>

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">2. Tahun Ajaran Akhir (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">end_year</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Tahun kalender di mana semester tersebut berakhir. Biasanya merupakan satu tahun setelah Tahun Ajaran Awal.</li>
        <li><strong>Cara Isi:</strong> Ketikkan angka tahun penuh (4 digit).</li>
        <li><strong>Contoh:</strong> <strong>2027</strong> (jika rentang tahun ajaran adalah 2026/2027).</li>
    </ul>

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">3. Semester (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">semester</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Menentukan periode kegiatan untuk semester pertama atau kedua.</li>
        <li><strong>Cara Isi:</strong> Klik kotak pilihan (<em>dropdown</em>) dan pilih salah satu:
            <ul style="margin-top: 0.5rem; margin-left: 1.5rem;">
                <li><strong>Ganjil:</strong> Biasanya jatuh pada periode bulan Juli - Desember.</li>
                <li><strong>Genap:</strong> Biasanya jatuh pada periode bulan Januari - Juni.</li>
            </ul>
        </li>
    </ul>

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">4. Status (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">status</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Menentukan apakah tahun ajaran ini sedang aktif berjalan digunakan oleh sistem atau sekadar arsip.</li>
        <li><strong>Cara Isi:</strong> Klik <em>dropdown</em> dan pilih status (biasanya <strong>Aktif</strong> atau <strong>Tidak Aktif</strong>).</li>
    </ul>

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">5. Tanggal Mulai (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">tanggal_mulai</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Tanggal spesifik dimulainya kegiatan belajar mengajar untuk semester/tahun ajaran tersebut.</li>
        <li><strong>Cara Isi:</strong> Klik ikon kalender yang muncul, atau ketikkan tanggal (biasanya format Hari-Bulan-Tahun).</li>
        <li><strong>Contoh:</strong> <strong>15-07-2026</strong> (15 Juli 2026).</li>
    </ul>

    <h3 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">6. Tanggal Akhir (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #475569;">tanggal_akhir</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
        <li><strong>Penjelasan:</strong> Tanggal spesifik berakhirnya kegiatan belajar mengajar untuk semester bersangkutan.</li>
        <li><strong>Cara Isi:</strong> Klik ikon kalender yang muncul, atau ketikkan secara manual.</li>
        <li><strong>Contoh:</strong> <strong>15-12-2026</strong> (15 Desember 2026 untuk penutupan semester Ganjil).</li>
    </ul>

    <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 0.25rem; margin-top: 2rem;">
        <h4 style="color: #1e3a8a; margin-top: 0; font-size: 1.125rem;">Langkah Terakhir</h4>
        <p style="margin-bottom: 0;">Setelah ke-6 kolom tersebut terisi penuh dan valid, klik tombol <strong>Simpan</strong> di bagian pojok kanan bawah. Sebuah <em>pop-up</em> konfirmasi akan muncul; setujui dialog tersebut dan data Tahun Ajaran baru akan sukses tersimpan di database!</p>
    </div>
</div>
HTML;

        // 4. Masukkan ke tabel documents
        $title = 'Panduan Pengisian: Master Tahun Ajaran';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'title' => $title,
                'category_id' => $category->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 2
            ]
        );
    }
}

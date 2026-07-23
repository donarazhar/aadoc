<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanGelombangPmbSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Setup Gelombang Pendaftaran PMB</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Administrator Pusat dalam membuat jadwal buka-tutup pendaftaran penerimaan murid baru, yang dikenal sebagai <strong>Gelombang PMB</strong>.</p>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Akses URL:</strong> Halaman ini dapat diakses melalui menu <a href="/admin/master/gelombang/add-gelombang/add" style="color: #2563eb; font-family: monospace; font-weight: bold; text-decoration: underline;">admin/master/gelombang/add-gelombang/add</a>.
        </div>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Langkah-langkah Penambahan Gelombang:</h4>
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li>Masuk ke menu <strong>Master Data &gt; Gelombang</strong> (atau Administrasi &gt; PMB &gt; Gelombang).</li>
            <li>Klik tombol <strong>Tambah Gelombang</strong>.</li>
            <li><strong>Nama Gelombang:</strong> Isikan nama periode pendaftaran, misalnya <em>Gelombang 1</em>, <em>Gelombang 2</em>, atau <em>Jalur Prestasi</em>.</li>
            <li><strong>Jenjang:</strong> Pilih jenjang pendidikan yang memberlakukan gelombang ini (misalnya SD).</li>
            <li><strong>Tahun Ajaran:</strong> Pilih Tahun Ajaran target (biasanya tahun ajaran berikutnya).</li>
            <li><strong>Tanggal Mulai & Selesai:</strong> Ini adalah parameter paling krusial! Tentukan kapan persisnya portal PMB dibuka dan ditutup untuk gelombang ini. Saat melewati "Tanggal Selesai", sistem akan otomatis menutup akses pendaftaran.</li>
            <li><strong>Biaya Formulir (Pendaftaran):</strong> Tentukan berapa harga/biaya pendaftaran yang harus ditransfer oleh calon pendaftar agar bisa mendapatkan nomor formulir.</li>
            <li>Klik tombol <strong>Simpan</strong>.</li>
        </ol>

        <div style="background-color: #fefce8; padding: 1rem; border-left: 4px solid #eab308; border-radius: 0.25rem; margin-top: 1.5rem;">
            <strong>Catatan Penting:</strong> Anda bisa membuat beberapa gelombang yang saling berkesinambungan. Misalnya, jika Gelombang 1 ditutup bulan Maret, Anda bisa menyetel Gelombang 2 untuk otomatis terbuka pada hari berikutnya di bulan Maret. Harga biaya formulir pun bisa dibedakan tiap gelombangnya.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Setup Gelombang PMB')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Setup Gelombang Pendaftaran',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 31,
            ]
        );
    }
}

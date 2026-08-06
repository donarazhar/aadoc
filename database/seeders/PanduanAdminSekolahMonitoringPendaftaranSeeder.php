<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanAdminSekolahMonitoringPendaftaranSeeder extends Seeder
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Workflow Admin Sekolah (Part 1): Pendaftaran Awal & Pembayaran Formulir</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Sebagai <strong>Admin Sekolah</strong>, salah satu peran krusial Anda pada masa Penerimaan Murid Baru (PMB) adalah memastikan bahwa setiap data pendaftar (Animo) yang masuk ke sistem dapat terpantau prosesnya hingga selesai. Modul PMB Al-Azhar Apps mengotomatisasi seluruh pergerakan status pendaftar.</p>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">1. Fase Animo (Pendaftaran Awal)</h4>
        <p><strong>Kondisi:</strong> Orang Tua membuat akun di aplikasi Al-Azhar Apps, menambahkan profil anak mereka, dan memilih pendaftaran pada unit sekolah Anda.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Sistem langsung memasukkan data ke dalam <strong>Data Animo</strong>. Sebuah tagihan <strong>Uang Formulir</strong> langsung terbit dan dapat dilihat di aplikasi Orang Tua (disertai kode Virtual Account atau link payment gateway).</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu <strong>PMB &gt; Data Animo & Calon Murid</strong>.</li>
                    <li>Status pendaftar baru akan terlihat sebagai <span style="background: #fef08a; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #854d0e; font-size: 0.875rem;">Menunggu Pembayaran Formulir</span>.</li>
                    <li>Jika ada calon murid yang tertahan pada status ini melewati batas waktu, Anda dapat melakukan <em>follow-up</em> langsung menggunakan kontak HP yang tertera.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">2. Fase Pembayaran Uang Formulir & Kelengkapan Biodata</h4>
        <p><strong>Kondisi:</strong> Pembayaran Formulir selesai dilakukan oleh Orang Tua.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Sistem mendeteksi notifikasi sukses dari payment gateway, mengubah status tagihan menjadi Lunas, dan membuka kunci akses formulir pendaftaran lengkap di aplikasi Orang Tua. Status pendaftar berubah menjadi <span style="background: #bfdbfe; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #1e40af; font-size: 0.875rem;">Silahkan Lengkapi Formulir PMB</span>.</li>
            <li><strong>Tugas Orang Tua:</strong> Melengkapi 3 bagian form utama (Gelombang, Biodata Lengkap Anak, dan Biodata Orang Tua/Wali) serta mengunggah dokumen persyaratan dasar (Akte Kelahiran, KK, Pas Foto).</li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">3. Fase Verifikasi Berkas (Opsional namun Disarankan)</h4>
        <p><strong>Kondisi:</strong> Orang Tua telah klik "Kirim Data" dan mengunggah berkas.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Status berubah menjadi <span style="background: #bbf7d0; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #166534; font-size: 0.875rem;">Formulir Selesai</span>. Calon murid kini resmi tercatat dalam daftar peserta siap seleksi.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Klik ikon <strong>Detail (Mata)</strong> pada baris nama calon murid.</li>
                    <li>Lakukan pemeriksaan terhadap lampiran berkas dan data yang diinput. Jika ada kesalahan minor, Admin dapat membantu merevisinya langsung.</li>
                    <li>Jika berkas valid, Anda bisa bersiap untuk tahap selanjutnya yaitu proses Ujian/Observasi.</li>
                </ul>
            </li>
        </ul>

        <div style="background-color: #f0f9ff; padding: 1rem; border-left: 4px solid #0284c7; border-radius: 0.25rem; margin-bottom: 1.5rem; margin-top: 2rem;">
            <strong style="color: #0284c7;">Praktek Terbaik (Best Practice):</strong><br>
            Selalu cek menu PMB setiap hari untuk mengidentifikasi hambatan (<em>bottleneck</em>) yang dialami pendaftar. Langkah selanjutnya setelah berkas lengkap adalah membuat Jadwal Ujian dan menempatkan calon murid ke dalam jadwal tersebut (diuraikan pada <strong>Part 2</strong>).
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah (Part 1): Pendaftaran Awal & Pembayaran Formulir')],
            [
                'title' => 'Panduan Workflow Admin Sekolah (Part 1): Pendaftaran Awal & Pembayaran Formulir',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 50,
            ]
        );
    }
}

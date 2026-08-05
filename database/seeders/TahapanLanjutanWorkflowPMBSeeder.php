<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class TahapanLanjutanWorkflowPMBSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada untuk menghindari error foreign key
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah')],
            ['name' => 'Panduan Workflow Admin Sekolah', 'description' => 'Panduan alur operasional untuk admin sekolah']
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Workflow Admin Sekolah (Part 3): Pembagian Rombel (Rombongan Belajar)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Selamat! Jika calon murid telah melunasi tagihan Uang Pangkal (DSP), status mereka di sistem akan berubah menjadi <strong>"Terdaftar"</strong>. Mereka kini telah sah menjadi bagian dari sekolah Anda. Tahapan terakhir dari siklus PMB ini adalah memasukkan mereka ke dalam kelas atau Rombongan Belajar (Rombel) yang telah disiapkan.</p>
        
        <div style="background-color: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Fase Penempatan Kelas (Menu: Master Rombel Sekolah)</h4>
        <p>Pada tahap ini, Admin Sekolah akan mengelompokkan murid-murid baru ke dalam kelas masing-masing.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Akses Menu:</strong> Buka <strong>Master &gt; Rombel &gt; Rombel Sekolah</strong>. Pilih Rombel atau Kelas tujuan yang sudah Anda buat sebelumnya.</li>
            <li><strong>Tindakan:</strong> 
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Klik <strong>Tambah Murid</strong> pada Rombel yang dituju.</li>
                    <li>Sistem akan menampilkan daftar anak yang berstatus "Terdaftar" atau yang belum memiliki kelas di jenjang tersebut.</li>
                    <li>Pilih nama-nama murid dan simpan. </li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">Selesainya Siklus PMB</h4>
        <p>Dengan masuknya murid ke dalam Rombel, sistem akan mengenali mereka sebagai Murid Aktif sepenuhnya. Murid-murid ini nantinya akan mulai di-<em>generate</em> tagihan bulanan SPP-nya, dan dapat diikutkan dalam penilaian akademik (LMS).</p>
        <div style="background-color: #f8fafc; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; margin-top: 1rem;">
            <p style="margin: 0; font-style: italic;">Dengan selesainya tahap ini, berakhirlah panduan Workflow PMB. Tahapan berikutnya akan berfokus pada operasional reguler sekolah.</p>
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Workflow Admin Sekolah (Part 3): Pembagian Rombel (Rombongan Belajar)')],
            [
                'title' => 'Panduan Workflow Admin Sekolah (Part 3): Pembagian Rombel (Rombongan Belajar)',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 70,
            ]
        );
    }
}

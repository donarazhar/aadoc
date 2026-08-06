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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Workflow Admin Sekolah (Part 3): Daftar Ulang & Pembagian Rombel</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Selamat! Jika calon murid telah melunasi tagihan Uang Pangkal (DSP), status mereka di sistem akan berubah menjadi <strong>"Daftar Ulang"</strong>. Mereka kini bersiap menjadi bagian resmi dari sekolah Anda. Tahapan ini mencakup pemberkasan akhir dan penempatan Rombongan Belajar (Rombel).</p>
        
        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">7. Fase Daftar Ulang & Penyerahan Berkas</h4>
        <p><strong>Kondisi:</strong> Uang Pangkal (DSP) lunas. Orang Tua harus menyerahkan dokumen fisik (seperti pas foto cetak, fotokopi legalisir, dan surat pernyataan) ke sekolah atau mengunggah dokumen susulan.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <strong>Daftar Ulang</strong> atau pemberkasan PMB.</li>
            <li><strong>Tugas Admin Sekolah:</strong> 
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Saat berkas fisik diterima, Admin melakukan finalisasi status Daftar Ulang murid tersebut.</li>
                    <li>Sistem juga mungkin akan menerbitkan tagihan terkait Seragam atau Buku jika belum termasuk di dalam komponen DSP.</li>
                    <li>Setelah semua beres, status calon murid berubah menjadi <strong>"Terdaftar"</strong> atau <strong>"Murid Aktif"</strong>.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 1.5rem;">8. Fase Penempatan Rombongan Belajar (Menu: Master Rombel Sekolah)</h4>
        <p><strong>Kondisi:</strong> Calon murid telah terdaftar secara sah. Kini Admin harus mengelompokkan murid-murid baru ini ke dalam kelas masing-masing (misal: TK A, TK B).</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Lokasi:</strong> Halaman <strong>Kesiswaan & Akademik &gt; Pembagian Rombel</strong> (atau Master Rombel).</li>
            <li><strong>Tugas Admin Sekolah:</strong> 
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu Rombel Sekolah dan pastikan Anda sudah membuat <em>Study Group</em> (Kelas) untuk tahun ajaran baru.</li>
                    <li><strong>Prasyarat Membuat Rombel:</strong> Pastikan Anda telah menginput <strong>Master Ruangan</strong> (di menu Sarana Prasarana) dan <strong>Master Pegawai/Guru</strong> (di menu Kepegawaian), karena saat membuat rombel Anda diwajibkan memilih *Nama Ruangan* dan *Nama Wali Kelas*.</li>
                    <li>Klik tombol <strong>Tambah Murid</strong> pada kelas yang dituju.</li>
                    <li>Sistem hanya akan menampilkan daftar anak yang berstatus "Terdaftar" atau murid aktif yang belum dialokasikan ke kelas mana pun.</li>
                    <li>Pilih nama-nama murid, simpan, dan mereka resmi menjadi anggota Rombel tersebut.</li>
                </ul>
            </li>
        </ul>

        <div style="background-color: #f8fafc; padding: 1rem; border: 1px solid #e2e8f0; border-radius: 0.25rem; margin-top: 1rem;">
            <p style="margin: 0; font-style: italic;">Dengan masuknya murid ke dalam Rombel, sistem akan mengenali mereka sebagai Murid Aktif sepenuhnya. Siklus Penerimaan Murid Baru (PMB) resmi berakhir di sini. Langkah selanjutnya masuk ke ranah Operasional Keuangan dan Akademik (diuraikan pada <strong>Part 4</strong>).</p>
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

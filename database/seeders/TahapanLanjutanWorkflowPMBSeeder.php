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
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: decimal;">
                    <li><strong>Langkah 1: Persiapan Prasyarat Data</strong><br/>
                        Sebelum membuat <em>Study Group</em> (Rombel) baru, Anda wajib melengkapi Master Data berikut agar <em>dropdown</em> pilihan di form Rombel tidak kosong:
                        <ul style="margin-left: 1.5rem; margin-top: 0.25rem; margin-bottom: 0.5rem; list-style-type: disc;">
                            <li><strong>Input Master Ruangan:</strong> Masuk ke menu <strong>Sekolah &gt; Sarana Prasarana</strong>, lalu tambahkan fasilitas bangunan dengan kategori <strong>Ruangan</strong>.</li>
                            <li><strong>Input Master Pegawai (Wali Kelas):</strong> Masuk ke menu <strong>Kepegawaian &gt; Pegawai</strong> (atau <em>Master Personnel</em>), lalu pastikan profil guru yang akan ditunjuk sebagai wali kelas telah terdaftar di sistem.</li>
                        </ul>
                    </li>
                    <li><strong>Langkah 2: Pembuatan Entitas Rombel</strong><br/>
                        Setelah prasyarat terpenuhi, buka menu <strong>Master Rombel Sekolah</strong> dan klik tombol <strong>Tambah Rombel</strong>. Isi kelengkapan form, termasuk memilih <strong>Nama Ruangan</strong> dan <strong>Nama Wali Kelas</strong> (yang kini sudah bisa Anda pilih dari daftar).
                    </li>
                    <li><strong>Langkah 3: Mengalokasikan Murid ke Dalam Rombel</strong><br/>
                        Setelah form Rombel disimpan, Anda akan melihat tombol <strong>Tambah Siswa</strong> pada detail Rombel tersebut. Klik tombol tersebut.
                    </li>
                    <li>Sistem secara otomatis memfilter dan <strong>hanya menampilkan daftar anak yang berstatus "Terdaftar"</strong> (sudah lunas DSP dan berkas lengkap) namun belum memiliki kelas.</li>
                    <li>Pilih nama-nama murid yang bersangkutan melalui <em>checkbox</em>, lalu klik simpan. Mereka kini resmi menjadi anggota Rombel tersebut secara sistem.</li>
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

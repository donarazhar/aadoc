<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUX_05_ManajemenUserJurnalSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Seri Panduan UI/UX Backoffice')],
            ['name' => 'Seri Panduan UI/UX Backoffice']
        );

        $content = <<<HTML
<p>Artikel ini adalah <strong>Seri 5 (Penutup)</strong> dari panduan bedah UI/UX Backoffice ALAZHARAPPS. Membahas dua kelompok menu terbawah pada Sidebar: <strong>Manajemen User</strong> (Otorisasi) dan <strong>Jurnal & E-Rapot</strong> (Akademik Lanjutan).</p>

<h3>1. Kelompok Menu: Manajemen User</h3>
<p>Ini adalah pusat keamanan (<em>Security Center</em>) dari operasional web Backoffice.</p>
<ul>
    <li><strong>User Sekolah:</strong>
        <ul>
            <li><strong>Fungsi UI:</strong> Menampilkan daftar (Tabel) seluruh akun staf yang memiliki hak akses (*login*) ke Backoffice khusus sekolah tersebut.</li>
            <li><strong>Kolom Isian (Form Tambah User):</strong> 
                <ul>
                    <li><code>Email & Password (Text Input):</code> Kredensial dasar.</li>
                    <li><code>Role (Dropdown):</code> Inilah penentu <em>User Experience</em> staf. Jika Admin memilih "Wali Kelas" (Level 10), maka saat user tersebut *login*, *Sidebar* di sebelah kiri akan menyusut secara otomatis, menyembunyikan menu Keuangan dan PMB (Konsep <em>Role-Based Access Control / RBAC UI</em>).</li>
                </ul>
            </li>
        </ul>
    </li>
    <li><strong>Log Activity (Jejak Audit):</strong>
        <ul>
            <li><strong>Fungsi UI:</strong> Menampilkan tabel <em>Read-Only</em> yang berisi jejak kaki digital. Terdapat kolom "Waktu", "User", "Aksi", dan "Target".</li>
            <li><strong>UX Keamanan:</strong> Berguna untuk melacak insiden (<em>Forensic UX</em>). Misalnya, jika nominal "Uang Pangkal" tiba-tiba berubah menjadi 0 rupiah, Kepala Sekolah bisa melihat di menu ini nama Staf yang menekan tombol Edit tersebut pada jam berapa.</li>
        </ul>
    </li>
</ul>

<h3>2. Kelompok Menu: Jurnal & E-Rapot</h3>
<p>Menu ini menjadi penghubung (*Bridge*) antara aktivitas harian guru dengan hasil akhir pencetakan ijazah.</p>
<ul>
    <li><strong>E-Rapot (Rapor Digital):</strong>
        <ul>
            <li><strong>UI Input Nilai Guru (Grid Input):</strong> Berbentuk tabel yang bisa diedit di tempat (*Inline Editing*). Guru tidak perlu menekan tombol 'Edit' di halaman baru, melainkan bisa langsung mengetik nilai (angka 0-100) di dalam kotak-kotak tabel layaknya Microsoft Excel (menggunakan pustaka *Handsontable* atau antarmuka serupa).</li>
            <li><strong>UI Peringatan KKM (Conditional Formatting):</strong> Jika guru mengetik angka "60" (di bawah KKM), UX sistem secara seketika (*OnBlur*) akan mengubah warna kotak tersebut menjadi warna merah (<em>Danger</em>) agar guru sadar tanpa perlu membaca instruksi tertulis.</li>
            <li><strong>Validasi & Penguncian (Locking UX):</strong> Terdapat tombol berlogo "Gembok". Jika Kepala Sekolah menekan tombol ini, seluruh kotak isian nilai tadi akan *Disabled* (Abu-abu, tidak bisa diklik lagi). Tujuannya agar Rapor yang sudah dicetak ke PDF tidak berubah nilainya di masa depan.</li>
        </ul>
    </li>
    <li><strong>Ijazah:</strong>
        <ul>
            <li><strong>UI Eksekusi (Generation):</strong> Berisi daftar siswa tingkat akhir (Kelas 6/9/12) dengan status "Lulus". Tersedia tombol "Generate Batch Ijazah" yang akan memproses pembuatan dokumen PDF masal di latar belakang (<em>Background Job / Worker</em>) dan menampilkan *progress bar* agar UI tidak terkesan <em>hang</em> atau <em>lag</em>.</li>
        </ul>
    </li>
</ul>

<hr>
<p><strong>Kesimpulan Proyek Serial UI/UX:</strong><br>
Keseluruhan desain <em>Sidebar</em> Admin Sekolah di ALAZHARAPPS membuktikan bahwa sistem ini dibuat bukan hanya untuk menyimpan data, tetapi dirancang memandu (<em>Guiding UX</em>) pegawai sekolah agar bekerja sesuai urutan standar operasional yang tepat (Dimulai dari pendaftaran murid, pengaturan biaya, hingga kelulusan di E-Rapot).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Seri 5: UI UX Manajemen User dan E Rapot')],
            [
                'title' => 'Seri 5: Anatomi UI/UX Manajemen User dan E-Rapot',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

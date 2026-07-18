<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUserBackofficeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Pengguna (User Manual)')],
            ['name' => 'Buku Panduan Pengguna (User Manual)']
        );

        $content = <<<HTML
<p>Artikel ini adalah panduan dasar operasional (SOP) bagi para pekerja (Staf/Karyawan) Yayasan ALAZHARAPPS. Karena sistem ini menangani puluhan sekolah di bawah satu yayasan, akses Backoffice dikontrol ketat menggunakan <strong>Role Level (Peran)</strong> agar setiap pengguna hanya melihat apa yang menjadi tanggung jawabnya.</p>

<h3>Hierarki Role (Peran Pengguna) Backoffice</h3>
<pre><code class="language-mermaid">
graph TD
    A[Role Level 1: Administrator Yayasan] --> B(Lintas Sekolah)
    A --> C[Role Level 15: Pengawas]
    
    subgraph Unit Sekolah (Per-Sekolah)
    D[Role Level 11: Kepala Sekolah] --> E[Role Level 9: Admin Sekolah / TU]
    D --> F[Role Level 10: Guru / Wali Kelas]
    D --> G[Role Level 14: Kasi / Kepala Seksi]
    end
</code></pre>

<h3>1. Skenario Superadmin / Administrator Yayasan (Level 1)</h3>
<p>Ini adalah peran tertinggi (Pusat) yang memiliki kontrol penuh terhadap konfigurasi fundamental seluruh yayasan.</p>
<ul>
    <li><strong>Mengelola Master Data:</strong> Membuka atau menutup Tahun Ajaran baru secara serentak untuk seluruh unit sekolah.</li>
    <li><strong>Manajemen Komponen Biaya Pusat:</strong> Membuat standar penamaan komponen tagihan (Misalnya: SPP, Uang Kegiatan, Uang Gedung) agar seragam di semua sekolah.</li>
    <li><strong>Manajemen Akses (RBAC):</strong> Membuatkan akun (<em>User ID</em>) dan mengatur <em>password</em> untuk Kepala Sekolah atau Admin Sekolah baru.</li>
</ul>

<h3>2. Skenario Kepala Sekolah / Principal (Level 11)</h3>
<p>Fokus utama Kepala Sekolah adalah <strong>Pemantauan (Monitoring)</strong> dan <strong>Otorisasi (Approval)</strong> untuk unit sekolahnya sendiri.</p>
<ul>
    <li><strong>Pemantauan Dasbor (Harian):</strong> Membuka Dashboard Keuangan (untuk melihat *Cashflow* harian/persentase siswa nunggak) dan Dashboard Kehadiran (melihat tingkat absensi guru dan siswa).</li>
    <li><strong>Eksekusi Persetujuan (Approval):</strong> Secara berkala membuka kotak masuk (Inbox) di Backoffice untuk menyetujui pengajuan Diskon (seperti Diskon Prestasi) atau menyetujui Skema Angsuran Khusus yang diajukan oleh Tata Usaha.</li>
</ul>

<h3>3. Skenario Admin Sekolah & Tata Usaha (Level 9)</h3>
<p>Role ini adalah ujung tombak operasional harian (Administrasi & Keuangan) di masing-masing sekolah.</p>
<ul>
    <li><strong>Manajemen Pendaftaran (PMB):</strong> Membantu orang tua yang mendaftar secara <em>offline</em> (Walk-in), mencetak kartu ujian, dan memverifikasi dokumen fisik pendaftar.</li>
    <li><strong>Manajemen Keuangan (Finance):</strong>
        <ul>
            <li>Mengeklik tombol <strong>Generate Tagihan Bulanan (SPP)</strong> agar sistem menagihkan ke seluruh aplikasi orang tua.</li>
            <li>Menginput pengajuan diskon (Saudara Kandung) atau menyetting skema cicilan (Angsuran) untuk disetujui Kepala Sekolah.</li>
            <li>Mengeksekusi <strong>Rekonsiliasi Manual (Upload Bank CSV)</strong> jika ada orang tua yang mentransfer langsung ke rekening bank yayasan.</li>
        </ul>
    </li>
    <li><strong>Manajemen Akademik Pokok:</strong> Menaikkan kelas siswa secara massal di akhir tahun ajaran (Skenario Mutasi).</li>
</ul>

<h3>4. Skenario Guru & Wali Kelas (Level 10)</h3>
<p>Role ini berfokus murni pada interaksi akademik dengan murid di kelas yang diajarnya (Rombongan Belajar).</p>
<ul>
    <li><strong>Rutinitas Pagi (Absensi):</strong> Membuka menu Absensi Kelas dari HP atau Laptop, mencontreng kehadiran murid, dan menekan 'Simpan' agar <em>Push Notification</em> otomatis terkirim ke orang tua.</li>
    <li><strong>Manajemen Ujian (LMS & CBT):</strong> Mengunggah bank soal (Pilihan Ganda/Esai) ke dalam sistem, mengatur durasi jam ujian (mengaktifkan *Kiosk/Lockdown mode*), dan memantau siswa yang sedang ujian secara <em>real-time</em>.</li>
    <li><strong>Penilaian Akhir (Rapor Digital):</strong> Menginput nilai akhir semester untuk diolah (kalkulasi) otomatis oleh sistem menjadi PDF Rapor Digital yang siap diunduh orang tua.</li>
</ul>

<h3>5. Skenario Pengawas (Level 15) & Kasi (Level 14)</h3>
<p>Peran Supervisi (seperti Pengawas Dinas atau Kepala Seksi Kurikulum Yayasan).</p>
<ul>
    <li><strong>Skenario Audit:</strong> Mereka memiliki akses <em>View-Only</em> (Hanya Baca) untuk memantau grafik kualitas akademik dan rekapitulasi keterlambatan pegawai/guru melintasi beberapa sekolah tanpa memiliki kemampuan untuk merusak atau mengubah (<em>Edit/Delete</em>) data operasional.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Dasar Penggunaan Backoffice (Berdasarkan Role)')],
            [
                'title' => 'Panduan Dasar Penggunaan Backoffice (Berdasarkan Role)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class AnalisaModulBackofficeArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori Backoffice Salam Al Azhar ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Backoffice Al Azhar Apps')],
            ['name' => 'Backoffice Al Azhar Apps', 'description' => 'Artikel tentang sistem backoffice Al Azhar Apps', 'order' => 1]
        );

        // Buat artikel Analisa Modul Backoffice
        $title = 'Analisa Modul Backoffice';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p><strong>1. Analisa Menyeluruh Dokumen 1 &amp; 2</strong><br>
Dari seluruh halaman (screenshot) yang ada, sistem ini terbagi menjadi beberapa modul utama:</p>

<p><strong>A. Modul Dashboard &amp; Laporan (Eksekutif &amp; Analitik)</strong></p>
<ul>
    <li><strong>Dashboard Summary &amp; Keuangan:</strong> Menampilkan ringkasan penerimaan dana, piutang, diskon, serta grafik pencapaian uang sekolah dan uang pangkal.</li>
    <li><strong>Dashboard Murid:</strong> Menampilkan corong (funnel) PMB mulai dari animo (minat), daftar ulang, hingga murid yang lolos. Terdapat juga statistik murid aktif per kelas.</li>
</ul>

<p><strong>B. Modul Penerimaan Murid Baru (PMB)</strong></p>
<ul>
    <li><strong>Master Gelombang PMB:</strong> Pengaturan gelombang pendaftaran (tanggal buka/tutup) per jenjang dan tahun ajaran.</li>
    <li><strong>Animo &amp; Pendaftaran:</strong> Pendaftaran awal (animo) yang merekam data dasar sebelum melengkapi formulir seutuhnya.</li>
    <li><strong>Ujian &amp; Kelulusan PMB:</strong> Penjadwalan ujian, pendataan peserta ujian, input nilai, dan penentuan kelulusan calon murid.</li>
</ul>

<p><strong>C. Modul Akademik &amp; Master Data Sekolah</strong></p>
<ul>
    <li><strong>Master Sekolah &amp; Profil:</strong> Menyimpan identitas resmi sekolah (NPSN, SK, Akreditasi, Lokasi) dan struktur kepegawaian pimpinan.</li>
    <li><strong>Rombongan Belajar (Rombel) &amp; Kelas:</strong> Pemetaan murid ke dalam kelas, tingkat kelas, beserta wali kelasnya.</li>
    <li><strong>Kurikulum &amp; Program:</strong> Pengaturan jadwal belajar, mata pelajaran, serta program pendidikan (Reguler, dsb).</li>
    <li><strong>Kenaikan Kelas &amp; Kelulusan:</strong> Proses pemindahan murid ke tingkat selanjutnya atau status lulus dari sekolah.</li>
</ul>

<p><strong>D. Modul Keuangan &amp; Pembayaran</strong></p>
<ul>
    <li><strong>Komponen Biaya:</strong> Pengaturan Biaya SPP, Uang Pangkal, dan Biaya Daftar Ulang.</li>
    <li><strong>Tagihan Murid:</strong> Pencatatan tagihan per murid/calon murid (dilengkapi sistem Virtual Account/VA).</li>
    <li><strong>Sistem Diskon/Potongan:</strong> Pengajuan diskon biaya pendidikan dengan berbagai kategori (Prestasi, Hafalan Al-Quran, Saudara Kandung, Anak Pegawai, Lulusan Yayasan).</li>
</ul>

<p><strong>E. Modul Pelengkap &amp; Kepegawaian</strong></p>
<ul>
    <li><strong>Personnel / Kepegawaian:</strong> Data lengkap staf/guru (NIP, pangkat, jabatan, data keluarga).</li>
    <li><strong>Sarana Prasarana &amp; Ekstrakulikuler:</strong> Pendataan fasilitas sekolah dan kegiatan tambahan murid (termasuk biaya ekskul &amp; pelatih).</li>
    <li><strong>Prestasi Murid:</strong> Pencatatan jejak prestasi murid di berbagai tingkatan.</li>
    <li><strong>Cetak Dokumen:</strong> Fitur generate/download Raport dan Ijazah.</li>
    <li><strong>Manajemen User:</strong> Pengaturan akun pengguna, role (peran), dan otorisasi (akses LMS).</li>
</ul>
',
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

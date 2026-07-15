<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUX_04_AdministrasiSeeder extends Seeder
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
<p>Artikel ini adalah <strong>Seri 4 dari 5</strong> panduan bedah UI/UX Backoffice ALAZHARAPPS. Ini adalah artikel terpenting karena membahas Dapur Utama Operasional (Kelompok Menu <strong>Administrasi</strong>), terutama membedah <em>Form</em> Biaya Daftar Ulang.</p>

<h3>1. Sub-Menu Administrasi &rarr; PMB (Penerimaan Murid Baru)</h3>
<p>Kumpulan form ini mengatur logika (<em>Business Logic</em>) penerimaan awal siswa.</p>
<ul>
    <li><strong>Gelombang Pendaftaran:</strong> Form untuk membuat batas waktu. (Kolom: <code>Nama Gelombang</code>, <code>Tanggal Mulai</code>, <code>Tanggal Berakhir</code>, <code>Biaya Formulir</code>).</li>
    <li><strong>Jadwal Ujian & Peserta Ujian:</strong> Form (UI Grid) untuk menentukan tanggal tes (<em>Entrance Test</em>) dan mendaftarkan ID Calon Siswa (Animo) ke dalam ruangan ujian.</li>
</ul>

<h3>2. Sub-Menu Administrasi &rarr; Biaya (Penggerak Keuangan)</h3>
<p>Di sinilah seluruh tagihan sistem bermula. UX didesain agar Admin bisa mengatur tagihan yang rumit menjadi fleksibel.</p>

<h4>Bedah Tuntas UX Form "Tambah Biaya Daftar Ulang" (Berdasarkan Layar Utama)</h4>
<p>Tagihan Daftar Ulang dieksekusi secara periodik (Tahunan) setiap kali murid akan naik kelas. Tata letak form ini sangat bersih (<em>Clean Design</em>) menggunakan form yang dibingkai (<em>Card Layout</em>).</p>
<ul>
    <li><strong>Kolom Atribut Penentu (Sisi Kiri & Kanan Atas):</strong>
        <ul>
            <li><code>Tahun Ajaran (Dropdown)*:</code> Menentukan untuk periode akademik kapan tagihan ini berlaku. Bersifat Wajib (Bintang Merah).</li>
            <li><code>Tingkat Kelas (Dropdown)*:</code> Filter spesifik agar biaya ini hanya mengikat murid di kelas tertentu.</li>
            <li><code>Program (Dropdown)*:</code> (Misal: Reguler, Bilingual, Tahfidz). Menentukan pembedaan harga antar program.</li>
            <li><code>Tanggal Jatuh Tempo (Date Picker)*:</code> Sangat krusial (UX). Format kalender <code>dd/mm/yyyy</code>. Di balik layar, tanggal ini akan dibaca oleh <em>Worker Scheduler</em> untuk menembakkan notifikasi peringatan (<em>Push Notification</em>) ke HP orang tua jika melewati batas waktu.</li>
        </ul>
    </li>
    
    <li><strong>Fitur Dynamic Form (Penambahan Komponen Dinamis):</strong>
        <p>Inilah letak fleksibilitas sistem. Alih-alih membuat satu form kaku "Biaya Total", UX menggunakan teknik <em>Dynamic Input Fields</em>.</p>
        <ul>
            <li><code>Komponen Biaya (Dropdown):</code> Admin memilih elemen penyusun tagihan (Misal: Uang Buku).</li>
            <li><code>Nominal (Input Number):</code> Mengisi harga, biasanya dilengkapi dengan format *masking* otomatis (titik/koma mata uang).</li>
            <li><strong>Tombol Biru [+ Tambah Komponen Biaya]:</strong> UX yang brilian. Admin dapat mengeklik tombol ini berulang kali untuk memunculkan baris *inputan* baru di bawahnya. Sehingga 1 tagihan Daftar Ulang bisa berisi rincian (Uang Buku, Uang Seragam, Uang Kegiatan) yang terpisah.</li>
        </ul>
    </li>

    <li><strong>Indikator Real-time (Total Banner):</strong>
        <p>Di bagian bawah terdapat kotak berwarna biru muda (<em>Light Blue Banner</em>) bertuliskan <strong>"Total Biaya Daftar Ulang: Rp 0"</strong>. Ini adalah fitur perhitungan otomatis (*Auto-Calculate JS*). Saat Admin mengetik Nominal, angka ini akan berubah secara langsung (*real-time*). Mencegah Admin salah hitung sebelum menekan tombol Simpan.</p>
    </li>
</ul>

<h4>Menu Lain di Administrasi Biaya</h4>
<ul>
    <li><strong>Uang Sekolah (SPP):</strong> Secara UX hampir mirip, namun biasanya tidak menggunakan tombol penambahan komponen dinamis yang terlalu banyak karena sifatnya <em>flat rate</em> bulanan.</li>
    <li><strong>Pengajuan Diskon:</strong> Menampilkan tabel *Approval*. Admin harus memilih jenis diskon (Saudara Kandung/Prestasi), mengunggah berkas persetujuan, lalu status tagihan siswa tersebut akan berubah.</li>
</ul>

<hr>
<p><em>Baca penutup seri ini pada <strong>Seri 5: Analisa Manajemen User & Jurnal E-Rapot</strong>.</em></p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Seri 4: UI UX Administrasi Biaya dan PMB')],
            [
                'title' => 'Seri 4: Anatomi UI/UX Administrasi Biaya (Daftar Ulang)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

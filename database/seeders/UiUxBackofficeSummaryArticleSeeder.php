<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeSummaryArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Dashboard Summary
        $title = 'Dashboard Menu Summary';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Dashboard Summary</strong> merupakan pusat informasi eksekutif (Executive Dashboard) yang memberikan ringkasan data finansial dan status penerimaan murid secara real-time untuk tahun ajaran yang sedang aktif.</p>

<h3>Komponen Utama Halaman</h3>

<h4>1. Navigasi dan Filter</h4>
<ul>
    <li><strong>Sidebar Kiri:</strong> Memuat menu navigasi utama seperti Dashboard (Summary, Murid), Transaksi (PMB), Laporan, dan Master Data Sekolah (Data Murid, Profile, Rombel, Kurikulum, dll).</li>
    <li><strong>Top Bar:</strong> Menampilkan breadcrumb, notifikasi, dan profil pengguna aktif (contoh: Admin Sekolah).</li>
    <li><strong>Filter:</strong> Tombol filter di pojok kanan atas memungkinkan admin untuk menyesuaikan rentang data yang ditampilkan (misalnya memfilter berdasarkan tahun ajaran atau jenjang).</li>
</ul>

<h4>2. Kartu Indikator Utama (Key Performance Indicators)</h4>
<p>Menyajikan 5 metrik finansial penting dalam bentuk kartu berwarna agar mudah dibaca dan dievaluasi dengan cepat:</p>
<ul>
    <li><strong>Total Penerimaan:</strong> Total dana pendidikan yang telah masuk/diterima secara keseluruhan.</li>
    <li><strong>Total Penerimaan Titipan:</strong> Dana titipan yang diterima oleh pihak sekolah.</li>
    <li><strong>Total Piutang &amp; Tunggakan:</strong> Jumlah kewajiban pembayaran dari murid yang belum dilunasi.</li>
    <li><strong>Total Piutang Titipan:</strong> Jumlah piutang dari dana titipan.</li>
    <li><strong>Total Diskon:</strong> Total potongan biaya (diskon) yang telah diberikan kepada murid berdasarkan berbagai kriteria (prestasi, saudara kandung, dll).</li>
</ul>

<h4>3. Banner Total Penerimaan</h4>
<p>Sebuah banner grafis menonjol berwarna hijau yang merinci Total Penerimaan ke dalam tiga rentang waktu:</p>
<ul>
    <li>Penerimaan pada bulan berjalan (contoh: Juli 2026).</li>
    <li>Penerimaan akumulatif tahun berjalan (Juli s/d saat ini).</li>
    <li>Komparasi atau perbandingan dengan total penerimaan pada Tahun Ajaran yang lalu.</li>
</ul>

<h4>4. Grafik Analitik (Charts)</h4>
<p>Menyediakan visualisasi data pergerakan tren sepanjang tahun ajaran:</p>
<ul>
    <li><strong>Grafik Penerimaan PMB:</strong> Grafik garis (line chart) yang memantau tren pendaftaran murid baru dari bulan ke bulan.</li>
    <li><strong>Grafik Penerimaan - Tagihan Uang Sekolah:</strong> Grafik batang (bar chart) interaktif yang menyandingkan total Tagihan (warna hijau) dengan total Penerimaan aktual (warna biru) per bulannya (dari Juli hingga Juni).</li>
</ul>

<h4>5. Progress Penerimaan Uang Sekolah</h4>
<p>Komponen ini menampilkan persentase rata-rata penerimaan (AVG) secara keseluruhan melalui sebuah <i>progress bar</i> horizontal. Dilengkapi juga dengan rincian persentase konversi atau progress penerimaan uang sekolah per bulan di bawahnya untuk melacak konsistensi pembayaran siswa.</p>

<h4>6. Ringkasan Status Unit/Sekolah</h4>
<p>Dua kartu di bagian bawah menyajikan data capaian yang lebih spesifik berdasarkan unit sekolah (misal: TK Islam Al Azhar 6 Sentra Primer):</p>
<ul>
    <li><strong>Penerimaan Murid Baru (Jumlah Siswa):</strong> Menampilkan progres persentase jumlah siswa pendaftar dibandingkan dengan kuota/target siswa baru yang dicanangkan.</li>
    <li><strong>Penerimaan Sekolah Tahun Pembelajaran:</strong> Menampilkan ringkasan total uang masuk yang mencakup seluruh komponen biaya (Uang Formulir, Uang Pangkal, Uang Sekolah, Uang Kegiatan, Uang Seragam) beserta jumlah transaksinya.</li>
</ul>
',
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

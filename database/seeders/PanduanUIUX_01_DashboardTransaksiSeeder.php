<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUX_01_DashboardTransaksiSeeder extends Seeder
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
<p>Artikel ini adalah <strong>Seri 1 dari 5</strong> panduan bedah UI/UX Backoffice ALAZHARAPPS. Fokus pada artikel ini adalah membedah kelompok menu pertama pada Sidebar, yaitu <strong>Dashboard</strong> dan <strong>Transaksi</strong>.</p>

<h3>1. Menu: Dashboard &rarr; Summary (Ringkasan)</h3>
<p>Halaman ini adalah wajah (<em>Home</em>) dari Backoffice Admin Sekolah.</p>
<ul>
    <li><strong>UI Layout:</strong> Terdiri dari beberapa kotak (*Cards*) di baris atas yang menampilkan angka absolut (Misal: Total Pemasukan Hari Ini, Total Murid Aktif). Di baris bawahnya, terdapat area grafik visual besar (*Canvas/Chart Area*).</li>
    <li><strong>Kolom Isian (Filter):</strong>
        <ul>
            <li><code>Filter Rentang Waktu (Date Range Picker):</code> Form kalender <em>dropdown</em> (Dari Tanggal - Sampai Tanggal). Digunakan untuk mempersempit data grafik arus kas (*Cashflow*).</li>
            <li><code>Filter Jenis Penerimaan (Dropdown):</code> Opsi untuk melihat grafik khusus "Uang Pangkal" atau "SPP".</li>
        </ul>
    </li>
    <li><strong>UX Behavior:</strong> Halaman ini bersifat <em>Read-Only</em> (Hanya Baca). Tidak ada tombol <em>Submit</em>. Perubahan pada filter akan langsung memicu (*trigger*) pemuatan ulang data grafik secara asinkron tanpa <em>loading</em> halaman penuh (SPA - <em>Single Page Application</em>).</li>
</ul>

<h3>2. Menu: Dashboard &rarr; Murid</h3>
<p>Menampilkan kondisi demografi populasi murid di unit sekolah tersebut.</p>
<ul>
    <li><strong>UI Layout:</strong> Grafik batang (*Bar Chart*) berseri berdasarkan Tahun Ajaran (Misal: Batang Tahun 2024, 2025).</li>
    <li><strong>UX Behavior (Interaktif):</strong> Saat grafik batang di-<em>hover</em> (kursor diletakkan di atasnya), akan muncul <em>Tooltip</em> (balon teks) berisi angka spesifik. Jika di-klik, UX akan memunculkan <em>Bottom Sheet</em> atau Modal Pop-up berisi tabel daftar nama murid yang menyusun angka pada batang tersebut.</li>
</ul>

<h3>3. Menu: Transaksi &rarr; PMB</h3>
<p>Menu ini adalah jalan pintas (<em>Shortcut</em>) bagi Kasir atau Admin TU untuk mengelola validasi pembayaran formulir pendaftaran secara cepat tanpa harus masuk ke modul Master Biaya.</p>
<ul>
    <li><strong>UI Layout:</strong> Tampilan Tabel Data (*DataTables*) dengan fitur pencarian (<em>Search bar</em>) di kanan atas.</li>
    <li><strong>Kolom Isian (Pencarian & Filter):</strong>
        <ul>
            <li><code>Cari Nama/No. Pendaftaran (Input Text):</code> Untuk mencari data calon siswa secara cepat.</li>
            <li><code>Filter Status Pembayaran (Dropdown):</code> Memiliki opsi: <em>Semua, Menunggu Pembayaran, Lunas, Dibatalkan</em>.</li>
            <li><code>Filter Gelombang (Dropdown):</code> Untuk menyortir pendaftar berdasarkan gelombang masuk.</li>
        </ul>
    </li>
    <li><strong>Aksi (UX Actions):</strong> Pada setiap baris data di tabel, terdapat kolom "Aksi" dengan tombol-tombol ikonik:
        <ul>
            <li><strong>Ikon Mata (View):</strong> Membuka *Pop-up* detail tagihan.</li>
            <li><strong>Ikon Uang (Pay/Verify):</strong> Membuka jendela khusus untuk <strong>Verifikasi Manual</strong>. Jika ada orang tua yang gagal memakai DOKU dan transfer langsung ke bank yayasan, Admin menekan tombol ini, lalu mengisi kolom <code>Tanggal Transfer</code> dan mengunggah <code>Bukti Foto Transfer (File Upload)</code>. Sistem kemudian akan mengubah status tagihannya menjadi Lunas secara paksa (<em>Force Paid</em>).</li>
        </ul>
    </li>
</ul>

<hr>
<p><em>Baca kelanjutannya pada <strong>Seri 2: Analisa Menu Laporan</strong>.</em></p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Seri 1: UI UX Dashboard dan Transaksi')],
            [
                'title' => 'Seri 1: Anatomi UI/UX Dashboard dan Transaksi',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

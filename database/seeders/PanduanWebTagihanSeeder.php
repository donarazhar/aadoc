<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWebTagihanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Pengguna (User Manual)')],
            [
                'name' => 'Panduan Pengguna (User Manual)'
            ]
        );

        $content = <<<HTML
<p>Panduan ini ditujukan bagi <strong>Staf Keuangan Yayasan / Kasir Sekolah</strong> untuk menerbitkan, memantau, dan menyusun laporan tagihan siswa (SPP) melalui Backoffice ALAZHARAPPS.</p>

<h3>1. Penerbitan Tagihan Bulanan (Invoicing Massal)</h3>
<p>Daripada membuat tagihan satu per satu untuk 500 siswa, Anda dapat menggunakan fitur Generate Massal.</p>
<ol>
    <li>Di menu samping kiri, klik <strong>Keuangan &gt; Tagihan SPP</strong>.</li>
    <li>Klik tombol <strong>Generate Tagihan Massal</strong> di kanan atas.</li>
    <li>Pilih "Bulan Pembayaran" (Contoh: Juli 2026) dan "Jenjang/Kelas" target. (Sistem akan otomatis mengecek siswa mana yang mendapat keringanan beasiswa).</li>
    <li>Klik <strong>Proses Sekarang</strong>. <em>Tunggu beberapa saat (sekitar 1-2 menit) karena server sedang mencetak ratusan Virtual Account.</em></li>
    <li>Setelah sukses, tagihan akan langsung muncul (Push Notification) di aplikasi *Mobile* orang tua.</li>
</ol>

<h3>2. Monitoring Pembayaran (Real-Time)</h3>
<p>Karena ALAZHARAPPS terhubung ke *Payment Gateway*, Staf Keuangan tidak perlu mengecek mutasi rekening bank secara manual untuk memverifikasi SPP.</p>
<ul>
    <li>Buka menu <strong>Keuangan &gt; Dashboard Penerimaan</strong>.</li>
    <li>Layar akan menampilkan grafik otomatis berapa persen target SPP bulan ini yang sudah terkumpul.</li>
    <li>Di bawah grafik, terdapat "Log Transaksi Harian". Jika orang tua A baru saja membayar via ATM Mandiri 2 detik yang lalu, namanya akan langsung muncul di baris paling atas dengan status "LUNAS" (ikon hijau).</li>
</ul>

<h3>3. Penanganan Kasus Khusus (Tunggakan & Pembayaran Tunai)</h3>
<ol>
    <li><strong>Kirim Surat Peringatan (Reminders):</strong> Buka menu <strong>Keuangan &gt; Laporan Tunggakan</strong>. Filter siswa yang belum membayar lebih dari 2 bulan. Klik tombol <strong>Kirim Notifikasi WA Massal</strong>. Sistem akan menembak pesan tagihan ke nomor ponsel orang tua mereka.</li>
    <li><strong>Pembayaran Tunai di Loket:</strong> Jika orang tua datang membawa uang tunai (cash) ke sekolah, staf dapat menerima uang tersebut. Cari nama anak di kotak Pencarian, buka tab Tagihannya, lalu klik tombol <strong>Bayar Manual (Cash)</strong>. Jangan lupa untuk menyerahkan kwitansi cetak (Print Struk) dari sistem kepada orang tua.</li>
</ol>

<h3>4. Ekspor Jurnal Akuntansi</h3>
<p>Di akhir bulan, Akuntan Yayasan tidak perlu merekap ulang.</p>
<ul>
    <li>Buka menu <strong>Akuntansi &gt; Laporan Jurnal Umum</strong>.</li>
    <li>Pilih rentang tanggal (1-30 Juli).</li>
    <li>Klik tombol <strong>Export Excel / CSV</strong>. File unduhan ini sudah berformat siap pakai (*ready-to-upload*) untuk dipindahkan ke sistem ERP sekunder yayasan atau diserahkan ke auditor.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('5. [Web] Alur Penerbitan Tagihan Finansial (Keuangan)')],
            [
                'title' => '5. [Web] Alur Penerbitan Tagihan Finansial (Keuangan)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

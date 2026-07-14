<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanMobileKeuanganSeeder extends Seeder
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
<p>Panduan ini ditujukan bagi Orang Tua untuk melakukan pengecekan tagihan sekolah (SPP, Uang Kegiatan, Buku) dan cara membayarnya melalui aplikasi *Mobile* ALAZHARAPPS.</p>

<h3>1. Mengecek Daftar Tagihan</h3>
<p>Sistem secara otomatis akan menerbitkan tagihan SPP pada tanggal 1 setiap bulannya. Untuk melihatnya:</p>
<ol>
    <li>Buka aplikasi ALAZHARAPPS di <em>smartphone</em> Anda dan pastikan Anda sudah <em>login</em>.</li>
    <li>Di halaman beranda (*Home*), ketuk menu dengan ikon dompet bertuliskan <strong>Keuangan / Tagihan</strong>.</li>
    <li>Anda akan melihat dua *tab* (halaman): <strong>Belum Lunas</strong> dan <strong>Riwayat Lunas</strong>.</li>
    <li>Pada halaman *Belum Lunas*, tagihan akan diurutkan dari yang paling mendesak (jatuh tempo terdekat). Tagihan yang berlatar merah menandakan telah melewati batas waktu pembayaran.</li>
</ol>

<h3>2. Proses Pembayaran via Virtual Account (VA)</h3>
<p>Sekolah Al-Azhar menggunakan *Payment Gateway* terintegrasi. Anda tidak perlu lagi mengirimkan foto bukti transfer (struk) ke Tata Usaha karena verifikasi berjalan otomatis.</p>
<ol>
    <li>Pilih bulan tagihan yang ingin dibayar (contoh: SPP Juli 2026), lalu ketuk <strong>Bayar Sekarang</strong>.</li>
    <li>Sistem akan menampilkan Rincian Tagihan. Pastikan nama siswa dan nominal sudah sesuai.</li>
    <li>Pilih <strong>Metode Pembayaran</strong> (Misalnya: Mandiri Virtual Account, BCA, BNI, atau e-Wallet seperti GoPay/OVO).</li>
    <li>Ketuk <strong>Konfirmasi &amp; Dapatkan Kode Pembayaran</strong>.</li>
    <li>Layar akan menampilkan <strong>Nomor Virtual Account (VA)</strong>. Ketuk tombol <em>Salin (Copy)</em>. Nomor VA ini hanya berlaku selama 24 jam.</li>
</ol>

<h3>3. Verifikasi Keberhasilan</h3>
<p>Setelah Anda melakukan transfer dana dari M-Banking atau ATM ke nomor VA tersebut:</p>
<ol>
    <li>Tunggu sekitar 1 - 5 menit. Buka kembali menu <strong>Keuangan</strong> di aplikasi ALAZHARAPPS.</li>
    <li>Tagihan yang Anda bayar akan otomatis berpindah dari *tab* Belum Lunas ke *tab* <strong>Riwayat Lunas</strong>.</li>
    <li>Anda juga akan menerima notifikasi pesan WhatsApp dari nomor resmi sekolah yang menyatakan *"Terima kasih, pembayaran SPP Ananda [Nama Siswa] telah diterima."*</li>
    <li>Ketuk tagihan lunas tersebut jika Anda ingin mengunduh atau mencetak Bukti Kwitansi digital dalam format PDF.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('2. [Mobile] Panduan Cek Tagihan & Pembayaran SPP')],
            [
                'title' => '2. [Mobile] Panduan Cek Tagihan & Pembayaran SPP',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

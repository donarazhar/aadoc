<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisThirdPartyWebhookSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Integrasi Eksternal')],
            [
                'name' => 'Integrasi Eksternal',
                'description' => 'Tata kelola koneksi Webhook dan Pihak Ketiga',
                'order' => 6,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini mengupas celah paling rawan (*Attack Surface*) di setiap aplikasi *Fintech*: Manajemen rute *Callback* (Webhook) dari sistem pihak ketiga (Midtrans/Xendit/Bank).</p>

<h3>1. Paradigma Tarik vs Dorong (Pull vs Push)</h3>
<p>Saat transaksi terjadi, ALAZHARAPPS tidak terus-menerus bertanya (<em>polling</em>) ke server Bank setiap menit, "Apakah SPP sudah dibayar?". Sebaliknya, Bank (Payment Gateway) yang akan "mendorong" pesan HTTP POST (*Webhook*) langsung ke peladen ALAZHARAPPS sesaat setelah uang dari orang tua masuk.</p>
<ul>
    <li><strong>Rute Terbuka:</strong> Berbeda dengan API <code>/api/v1/users</code> yang diamankan oleh JWT pengguna, rute <code>/api/v1/payments/webhook</code> sifatnya terbuka untuk publik di internet.</li>
    <li><strong>Risiko Injeksi Palsu:</strong> Seorang siswa nakal/peretas yang tahu format JSON Midtrans bisa saja menembakkan *request* dari laptopnya ke server ALAZHARAPPS dengan *payload* <em>"SPP Bulan ini sudah lunas"</em>. Jika tidak diproteksi, aplikasi akan menganggap pembayaran benar-benar terjadi, dan jurnal yayasan akan bocor (kerugian jutaan Rupiah).</li>
</ul>

<h3>2. Mitigasi dan Validasi Lapis Baja</h3>
<p>Tim pengembangan menerapkan standar kepatuhan tinggi untuk menolak rute *Webhook* palsu:</p>
<ol>
    <li><strong>Validasi IP Whitelisting:</strong> Nginx atau *Gateway* dikonfigurasi untuk hanya menerima *request* masuk ke URL Webhook tersebut jika IP pengirimnya secara sah berasal dari *Data Center* Midtrans/Xendit. (Gagal di sini = Akses Ditolak 403).</li>
    <li><strong>Verifikasi Signature Key (Tanda Tangan Kriptografi):</strong> Meskipun IP bisa dipalsukan (IP Spoofing), server Bank menyertakan *header* khusus yang berisi *hash* (enkripsi gabungan dari ID Transaksi + Status + Server Key Rahasia). ALAZHARAPPS akan membuat *hash* tandingan menggunakan <code>Server_Key</code> miliknya. Jika *hash* tidak cocok (<em>Signature Mismatch</em>), server mengabaikan perintah tersebut!</li>
    <li><strong>Pengecekan Silang (Double Validation):</strong> Untuk transaksi dalam jumlah besar, <code>transaction-service</code> memiliki lapisan keamanan terakhir, yakni melakukan panggilan balik (*Callback API GET*) langsung ke Midtrans guna menanyakan kembali keabsahan transaksi tersebut sebelum mengeksekusi penulisan jurnal keuangan (GORM *Transaction*).</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('5. Integrasi Pihak Ketiga & Validasi Webhook')],
            [
                'title' => '5. Integrasi Pihak Ketiga & Validasi Webhook',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

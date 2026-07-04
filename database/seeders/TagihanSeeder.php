<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;

class TagihanSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Get or Create Category
        $category = Category::firstOrCreate(
            ['slug' => 'ui-ux-mobile-app'],
            [
                'name' => 'UI/UX Mobile App',
                'description' => 'Penjelasan antarmuka, fitur, dan panduan penggunaan halaman pada mobile app Al Azhar Apps untuk orang tua murid.',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        // Get the first user or default to 1 (to prevent foreign key constraint fails)
        $user = User::first();
        $userId = $user ? $user->id : 1;

        // 2. Create Article Content for "Menu Tagihan & Pembayaran"
        $content = <<<HTML
<p>Menu <strong>Tagihan</strong> dirancang untuk memudahkan orang tua murid dalam memeriksa dan melakukan pembayaran administrasi sekolah (seperti Formulir PMB, SPP bulanan, atau kegiatan lainnya) secara langsung dari aplikasi.</p>

<h3>1. Halaman Daftar Tagihan & Infaq</h3>
<p>Saat Anda masuk ke menu Tagihan, Anda akan melihat kartu identitas anak (Nama dan Asal Sekolah) di bagian atas.</p>
<ul>
    <li><strong>Memilih Tagihan:</strong> Sistem akan menampilkan daftar tagihan yang belum dibayar. Anda dapat mencentang kotak di sebelah kanan nominal untuk memilih tagihan mana yang ingin dibayar saat ini.</li>
    <li><strong>Fitur Infaq (Donasi):</strong> Tersedia juga kolom khusus untuk berinfaq. Jika Anda mengetuk tombol <strong>Infaq</strong>, akan muncul <em>pop-up</em> yang berisi kutipan ayat Al-Qur'an dan kolom untuk memasukkan nominal infaq secara sukarela. Nominal infaq ini nantinya akan ditambahkan ke dalam total tagihan Anda.</li>
    <li><strong>Proses Pembayaran:</strong> Setelah memilih tagihan (dan/atau memasukkan infaq), total yang harus dibayar akan tertera di bagian bawah layar. Ketuk tombol biru <strong>Bayar</strong> untuk melanjutkan.</li>
</ul>

<h3>2. Konfirmasi Pembayaran</h3>
<p>Sebelum masuk ke pemilihan bank, sistem akan memunculkan <em>pop-up</em> <strong>Konfirmasi Pembayaran</strong>. Jendela ini berfungsi agar Anda dapat memastikan kembali bahwa total nominal dan jumlah item tagihan yang Anda pilih sudah benar. Jika sudah sesuai, ketuk tombol <strong>Lanjutkan</strong>.</p>

<h3>3. Ringkasan & Pemilihan Metode Pembayaran</h3>
<p>Pada layar berikutnya, Anda akan melihat rincian akhir dari transaksi Anda:</p>
<ul>
    <li><strong>Ringkasan Pembayaran:</strong> Menampilkan detail <em>item</em> yang dibayar (misalnya: Formulir Pendaftaran PMB sebesar Rp 550.000).</li>
    <li><strong>Pilih Metode Pembayaran:</strong> Anda dapat memilih berbagai saluran pembayaran yang didukung, seperti transfer bank via <em>Virtual Account</em> (Bank BCA, CIMB Niaga, Bank Mandiri, dan lainnya).</li>
</ul>
<p>Pilih metode bank yang paling memudahkan Anda dengan mengetuk tombol radio di sebelahnya, lalu ketuk tombol <strong>Lanjutkan</strong> (atau <strong>Bayar Sekarang</strong>). Sistem akan memproses permintaan Anda dan menampilkan instruksi transfer beserta nomor rekening/Virtual Account yang harus dituju.</p>
HTML;

        // 3. Create Document
        Document::updateOrCreate(
            ['slug' => 'menu-tagihan-dan-pembayaran'],
            [
                'category_id' => $category->id,
                'title' => 'Menu Tagihan & Proses Pembayaran',
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 5,
            ]
        );
    }
}

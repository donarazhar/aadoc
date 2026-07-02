<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class PmbWorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori ada
        $categoryName = 'Panduan Penggunaan Aplikasi bagi OTM';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName, 
                'description' => 'Kumpulan panduan dan tutorial penggunaan Al Azhar Apps khusus untuk Orang Tua Murid.', 
                'order' => 6 
            ]
        );

        // Buat artikel Workflow PMB
        $title = 'Workflow Jalur PMB';
        
        $content = '
<h2>Alur Pendaftaran Murid Baru (PMB)</h2>
<p>Berikut adalah langkah-langkah lengkap proses Penerimaan Murid Baru (PMB) melalui Al Azhar Apps, mulai dari mengunduh aplikasi hingga proses pelunasan pembayaran.</p>

<ol>
    <li>
        <strong>Download APP:</strong> Unduh aplikasi resmi Al Azhar Apps melalui <em>App Store</em> (untuk pengguna iOS) atau <em>Google Play Store</em> (untuk pengguna Android).
    </li>
    <li>
        <strong>Registrasi:</strong> Buka aplikasi dan lakukan pendaftaran akun (registrasi) menggunakan nomor WhatsApp aktif Anda, lalu verifikasi menggunakan kode OTP.
    </li>
    <li>
        <strong>Memasukkan Data Anak & Memilih Sekolah:</strong> Setelah login, tambahkan profil calon murid (data anak). Kemudian, pilih unit sekolah tujuan dan jalur pendaftaran yang sesuai dengan jenjang pendidikan anak.
    </li>
    <li>
        <strong>Bayar Biaya Formulir:</strong> Lakukan pembayaran biaya formulir pendaftaran. Setelah pembayaran terverifikasi, proses pendaftaran akan berlanjut ke tahap seleksi.
    </li>
    <li>
        <strong>Jadwal Ujian:</strong> Anda akan mendapatkan informasi mengenai jadwal ujian atau observasi (seleksi masuk) sesuai dengan sekolah yang telah dipilih. Silakan ikuti proses seleksi tersebut.
    </li>
    <li>
        <strong>SK Lulus dengan Rincian Tagihan:</strong> Jika calon murid dinyatakan lulus, Anda akan menerima pengumuman kelulusan berupa SK (Surat Keputusan) Lulus yang memuat rincian tagihan pendidikan, termasuk Uang Pangkal dan Uang Sekolah (SPP).
    </li>
    <li>
        <strong>Pengajuan Diskon (Opsional):</strong> Pada tahap ini, apabila Anda memenuhi syarat khusus (misal: anak pegawai, alumni, atau jalur prestasi), Anda dapat melakukan pengajuan diskon terhadap tagihan pendidikan.
    </li>
    <li>
        <strong>Melakukan Pembayaran:</strong> Lakukan pelunasan atau cicilan tagihan pendidikan sesuai dengan metode pembayaran yang tersedia di dalam aplikasi untuk menyelesaikan tahapan PMB dan meresmikan status penerimaan.
    </li>
</ol>
<p><em>Catatan: Pastikan Anda selalu mengecek notifikasi secara berkala pada aplikasi Al Azhar Apps untuk pembaruan status pendaftaran.</em></p>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

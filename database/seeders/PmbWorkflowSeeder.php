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
        $categoryName = 'Panduan Penggunaan Aplikasi bagi OTM';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName, 
                'description' => 'Kumpulan panduan dan tutorial penggunaan Al Azhar Apps khusus untuk Orang Tua Murid.', 
                'order' => 6 
            ]
        );

        $title = 'Alur Lengkap PMB (Pendaftaran Murid Baru)';
        
        $content = '
<h2 style="color: #0f172a; font-weight: bold; font-size: 1.5rem; margin-bottom: 0.5rem; text-align: center;">Alur Lengkap Penerimaan Murid Baru (PMB)</h2>
<p style="color: #64748b; margin-bottom: 2rem; text-align: center;">Berikut adalah representasi proses pendaftaran dari awal hingga selesai.</p>

<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 2.5rem; font-family: sans-serif;">
    <div style="width: 140px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">1</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Akses &<br>Daftar Awal</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 140px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">2</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Bayar & Lengkapi<br>Formulir</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 140px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">3</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Ujian Masuk &<br>Kelulusan</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 140px; background-color: #f0fdf4; border: 2px solid #22c55e; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #22c55e; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">4</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Daftar Ulang &<br>Biodata Akhir</div>
    </div>
</div>

<div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 1.5rem; margin-bottom: 2.5rem; font-family: sans-serif; color: #334155; line-height: 1.6;">
    <h3 style="color: #0f172a; font-size: 1.15rem; margin-top: 0; margin-bottom: 1rem; border-bottom: 1px solid #cbd5e1; padding-bottom: 8px;">Penjelasan Singkat</h3>
    <ul style="margin: 0; padding-left: 1.2rem;">
        <li style="margin-bottom: 8px;"><strong>Tahap 1:</strong> Orang tua masuk ke aplikasi Al Azhar Apps dan mengisi data dasar untuk membuat profil calon murid.</li>
        <li style="margin-bottom: 8px;"><strong>Tahap 2:</strong> Melakukan pembayaran biaya formulir pendaftaran agar sistem membuka akses untuk melengkapi formulir data asal sekolah dan profil detail murid.</li>
        <li style="margin-bottom: 8px;"><strong>Tahap 3:</strong> Calon murid mengikuti tes menggunakan Kartu Ujian di aplikasi. Setelah pengumuman kelulusan terbit, orang tua menyetujui surat ketentuan keuangan sekolah.</li>
        <li><strong>Tahap 4:</strong> Melakukan pelunasan biaya pendidikan (Daftar Ulang/Uang Pangkal). Setelah lunas, anak resmi terdaftar dan orang tua wajib melengkapi biodata akhir (data kesehatan, orang tua, prestasi).</li>
    </ul>
</div>

<div style="font-family: sans-serif; color: #334155; line-height: 1.5; font-size: 0.95rem;">
    <h3 style="color: #0f172a; font-size: 1.25rem; border-bottom: 2px solid #e2e8f0; padding-bottom: 8px; margin-bottom: 1.5rem;">Keterangan Lengkap Langkah Pendaftaran</h3>
    
    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 1: Akses & Pendaftaran Awal (Langkah 1 - 11)</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Login ke aplikasi dengan memasukkan nomor handphone dan PIN Anda.</li>
        <li>Pada halaman Beranda, pilih menu <strong>PMB</strong>, lalu tekan tombol <strong>Daftar Sekarang</strong>.</li>
        <li>Isi form biodata awal (Tahun Ajaran, Jenjang, Sekolah Tujuan, Nama Anak, dll) lalu tekan <strong>Daftar PMB</strong>.</li>
        <li>Tekan <strong>Oke</strong> pada notifikasi verifikasi berhasil, lalu pilih nama calon murid yang baru didaftarkan pada daftar yang muncul.</li>
    </ul>

    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 2: Bayar Formulir & Lengkapi Data (Langkah 12 - 26)</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Status anak akan berada pada "Menunggu Pembayaran Formulir". Tekan tombol <strong>Ke Halaman Tagihan</strong>.</li>
        <li>Centang opsi tagihan <strong>Formulir Pendaftaran</strong>, tekan <strong>Bayar</strong>, lalu <strong>Lanjutkan</strong>.</li>
        <li>Pilih metode pembayaran yang diinginkan (misal: QRIS), unduh QR Code, dan lakukan pelunasan via aplikasi perbankan Anda.</li>
        <li>Setelah pembayaran sukses, kembali ke menu PMB. Status anak kini berubah menjadi "Silahkan Lengkapi Formulir PMB".</li>
        <li>Klik nama anak tersebut, lengkapi data <strong>Asal Sekolah</strong> dan <strong>Profil Murid</strong> secara menyeluruh, lalu tekan <strong>Ajukan</strong>.</li>
    </ul>

    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 3: Ujian Masuk & Pengumuman (Langkah 27 - 36)</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Kembali buka profil anak di menu PMB untuk melihat <strong>Kartu Peserta Ujian Masuk</strong>. Kartu ini wajib ditunjukkan saat jadwal ujian berlangsung.</li>
        <li>Tinjau pop-up Syarat & Ketentuan yang muncul, lalu tekan <strong>Download Surat</strong> Pernyataan.</li>
        <li>Bila anak dinyatakan <strong>LULUS</strong> seleksi, pengumuman kelulusan akan otomatis muncul di dalam aplikasi.</li>
        <li>Buka halaman Syarat & Ketentuan pembayaran keuangan, centang kotak persetujuan, lalu tekan <strong>Setuju & Lanjutkan</strong>.</li>
    </ul>

    <h4 style="color: #22c55e; font-size: 1.05rem; margin-bottom: 10px;">Tahap 4: Daftar Ulang & Biodata Akhir (Langkah 37 - 44)</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Masuk ke menu Tagihan untuk melunasi biaya keuangan sekolah (seperti DSP dan Uang SPP) menggunakan QRIS atau metode pembayaran lain yang tersedia.</li>
        <li>Setelah pembayaran uang pangkal berhasil dikonfirmasi, profil/card anak akan muncul di halaman <strong>Beranda (Home)</strong> aplikasi.</li>
        <li>Klik profil anak tersebut, lalu masuk ke menu <strong>Biodata</strong>.</li>
        <li>Lengkapi data riwayat akhir secara komprehensif, meliputi: Data Ayah, Ibu, Wali, Riwayat Kesehatan, Dokumen pendukung, dan Prestasi anak.</li>
    </ul>
</div>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}
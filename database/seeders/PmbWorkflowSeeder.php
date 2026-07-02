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

<h3 class="text-lg font-bold text-slate-800 mb-4 mt-8">Bagan Alur PMB</h3>
<div class="w-full overflow-x-auto pb-8 pt-4 mb-8">
    <div class="flex items-center w-max px-2">
        
        <!-- Langkah 1 -->
        <div class="w-40 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">1</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Download APP</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 2 -->
        <div class="w-40 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">2</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Registrasi</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 3 -->
        <div class="w-48 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">3</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Isi Data & Pilih Sekolah</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 4 -->
        <div class="w-48 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">4</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Bayar Biaya Formulir</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 5 -->
        <div class="w-40 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">5</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Jadwal Ujian</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 6 -->
        <div class="w-48 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">6</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">SK Lulus & Tagihan</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 7 -->
        <div class="w-48 bg-white border border-slate-200 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-alazhar text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">7</div>
            <div class="font-semibold text-slate-700 text-sm mt-1">Pengajuan Diskon</div>
        </div>
        
        <!-- Arrow -->
        <div class="px-2 text-alazhar flex-shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </div>
        
        <!-- Langkah 8 -->
        <div class="w-48 bg-white border-2 border-green-500 shadow-md rounded-lg p-4 text-center relative flex-shrink-0">
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 bg-green-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full shadow-sm">8</div>
            <div class="font-bold text-slate-800 text-sm mt-1">Melakukan Pembayaran</div>
        </div>
        
    </div>
</div>

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

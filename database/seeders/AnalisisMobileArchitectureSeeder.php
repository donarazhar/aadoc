<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisMobileArchitectureSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Frontend & Mobile Apps')],
            [
                'name' => 'Frontend & Mobile Apps',
                'description' => 'Arsitektur klien untuk Web dan Aplikasi Genggam',
                'order' => 3,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini mendeskripsikan arsitektur dan pola integrasi aplikasi klien bergerak (Mobile Apps) yang digunakan oleh ratusan orang tua, guru, dan siswa di ekosistem ALAZHARAPPS &amp; LMSALAZHARAPPS.</p>

<h3>1. Pendekatan Pengembangan Lintas Platform (Cross-Platform)</h3>
<p>Berdasarkan struktur repositori <code>mobile</code> dan <code>lms-mobile</code>, pengembangan aplikasi pintar ini menggunakan kerangka kerja lintas platform (kemungkinan besar <strong>Flutter</strong> atau <strong>React Native</strong>).</p>
<ul>
    <li><strong>Manfaat Bisnis:</strong> Dengan satu basis kode (*single codebase*), yayasan dapat merilis aplikasi berekstensi <code>.apk</code> untuk pengguna Android di Google Play Store dan ekstensi <code>.ipa</code> untuk pengguna iPhone di Apple App Store. Ini memangkas biaya pemeliharaan IT hingga 50%.</li>
    <li><strong>Pola Komunikasi API:</strong> Sama persis dengan portal Web (NextJS), aplikasi *Mobile* bertindak murni sebagai "Lapisan Tampilan" (View Layer). Seluruh beban logika (apakah siswa boleh ikut ujian atau apakah tagihan SPP sudah dibayar) diserahkan ke API Backend Golang.</li>
</ul>

<h3>2. Penyimpanan Kredensial di Mobile (Secure Storage)</h3>
<p>Berbeda dengan *browser* Web yang memiliki sistem <em>Cookie</em> ketat, aplikasi *mobile* memiliki tantangan keamanan tersendiri.</p>
<ul>
    <li>Saat orang tua *login* ke aplikasi <code>mobile</code>, token otorisasi (JWT) yang didapat dari <code>account-service</code> tidak boleh disimpan di <em>SharedPreferences</em> biasa (karena mudah dibajak di perangkat Android yang di-*root*).</li>
    <li>Pengembang menggunakan modul khusus seperti <code>Flutter Secure Storage</code> atau <code>EncryptedSharedPreferences</code> untuk membungkus token tersebut dalam *Brankas Terenkripsi* (Keystore/Keychain) milik sistem operasi *smartphone*.</li>
</ul>

<h3>3. Integrasi Khusus: Safe Exam Browser (CBT)</h3>
<p>Repositori <code>safeexam-browser-android</code> adalah modul keamanan yang paling esensial dalam ekosistem pendidikan masa kini.</p>
<ul>
    <li><strong>Sistem Penguncian Layar (Kiosk Mode):</strong> Aplikasi Android ini berinteraksi langsung dengan API sistem operasi tingkat rendah (*low-level*). Saat mode ujian diaktifkan, aplikasi akan memblokir fitur *screenshot*, *split-screen*, notifikasi melayang (pop-up), dan secara agresif mencegah perpindahan aplikasi (App Switching).</li>
    <li><strong>Deteksi Kecurangan (Anti-Cheat):</strong> Layanan ini terhubung secara *realtime* (via WebSocket/gRPC) ke <code>course-service</code> di LMS. Jika siswa terdeteksi mencoba meminimize layar, aplikasi *mobile* akan langsung mengirim sinyal darurat ke server, yang secara otomatis akan membekukan lembar jawaban siswa (Auto-Lock).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('2. Arsitektur Mobile Apps (Siswa & Orang Tua)')],
            [
                'title' => '2. Arsitektur Mobile Apps (Siswa & Orang Tua)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisKeamananSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id ?? 1;

        $category = Category::firstOrCreate(
            ['slug' => 'analisis-arsitektur-sistem'],
            [
                'name' => 'Analisis Arsitektur Sistem',
                'description' => 'Dokumentasi komprehensif terkait arsitektur ALAZHARAPPS',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        $content4 = <<<HTML
<p>Evaluasi keamanan terhadap jembatan komunikasi API menunjukkan sejumlah potensi kerentanan yang memerlukan perhatian serius sebelum produk dirilis secara publik.</p>

<h3>Mekanisme Autentikasi & Penyimpanan JWT</h3>
<p>Saat ini, JSON Web Token (JWT) yang dihasilkan dari backend dikirim sebagai respons biasa dan disimpan oleh frontend menggunakan skrip JavaScript murni ke dalam Cookies (<code>Cookies.set</code>). Mekanisme <strong>tanpa perlindungan HttpOnly</strong> ini sangat rentan terhadap eksploitasi peretasan <strong>Cross-Site Scripting (XSS)</strong> di mana pihak ketiga dapat mencuri token aktif milik pengguna.</p>

<h3>Miskonfigurasi CORS (Cross-Origin Resource Sharing)</h3>
<p>Ditemukan miskonfigurasi tingkat tinggi pada layanan GoFiber, di mana parameter akses diatur sangat terbuka (<code>AllowOrigins: "*"</code>). Hal ini memungkinkan domain manapun di internet menembakkan kueri lintas situs ke backend tanpa adanya pemblokiran dari sistem keamanan bawaan web peramban pengguna (rentan terhadap CSRF sekunder).</p>

<h3>Rate Limiting & Proteksi Serangan</h3>
<p>Tidak ditemukannya mekanisme <strong>Rate Limiter</strong> aktif pada ujung-ujung API krusial (seperti <code>/login</code> atau OTP). Absennya fitur keamanan ini membuka celah eksploitasi <em>Brute-Force</em> (tebak kata sandi ribuan kali) atau pembengkakan beban SMS (OTP Bombing).</p>

<h3>Skema Validasi Input</h3>
<p>Backend belum sepenuhnya mengintegrasikan kerangka <em>struct validation</em> ekstensif dari komunitas Go. Validasi pada tahap awal lebih sering menggunakan <em>if-statement</em> fungsional dasar, menjadikan logika penyaringan input kurang terpusat.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'keamanan-autentikasi'],
            [
                'category_id' => $category->id,
                'title' => 'Keamanan & Autentikasi',
                'content' => $content4,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 4,
            ]
        );
    }
}

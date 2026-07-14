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
<p>Analisis ini berfokus pada mekanisme keamanan, autentikasi, dan perlindungan API (CORS &amp; Rate Limiting) yang menjembatani antara Frontend (NextJS) dan Backend (Golang). Ditemukan beberapa <strong>celah keamanan kritis</strong> yang berpotensi membahayakan sistem jika di-deploy ke lingkungan produksi.</p>

<h3>1. Mekanisme Autentikasi &amp; Penyimpanan JWT</h3>
<p><strong>Status:</strong> &#9888; <strong>Rentan terhadap serangan XSS (Cross-Site Scripting)</strong></p>

<ul>
    <li><strong>Penerbitan Token:</strong> Backend (Golang) menghasilkan token JWT saat proses login berhasil dan mengembalikannya ke frontend dalam bentuk respons JSON biasa (<code>{ "results": { "token": "ey..." } }</code>).</li>
    <li><strong>Penyimpanan di Frontend:</strong> Kode frontend (<code>authSlice.ts</code>) mengambil token tersebut dan menyimpannya menggunakan pustaka <code>js-cookie</code>:
<pre><code>// Lokasi: frontend/apps/apps/app/store/slices/auth/
Cookies.set("authToken", token);</code></pre>
    </li>
    <li><strong>Analisis Kerentanan:</strong> Penyimpanan token JWT secara langsung menggunakan <code>Cookies.set()</code> tanpa flag <code>HttpOnly</code> membuat token dapat dibaca dan dicuri oleh <strong>kode JavaScript apapun</strong> yang berjalan di browser (<code>document.cookie</code>). Jika ada script berbahaya yang berhasil disusupkan ke halaman web (melalui form input, komentar, atau pustaka pihak ketiga yang disusupi &mdash; XSS), peretas dapat mencuri token sesi pengguna dan mengambil alih akun mereka (Session Hijacking).</li>
</ul>

<p><strong>[!CAUTION] Rekomendasi:</strong> Backend Golang <strong>wajib</strong> mengubah metode pengiriman token. Token tidak boleh dikirim via body JSON, melainkan langsung di-set oleh backend ke dalam header <code>Set-Cookie</code> dengan parameter <code>HttpOnly</code>, <code>Secure</code>, dan <code>SameSite=Strict</code>. Dengan cara ini, JavaScript di peramban tidak akan bisa membaca token tersebut.</p>

<h3>2. CORS (Cross-Origin Resource Sharing)</h3>
<p><strong>Status:</strong> &#10060; <strong>Sangat Berbahaya (Miskonfigurasi Kritis)</strong></p>

<ul>
    <li><strong>Konfigurasi Saat Ini:</strong> Berdasarkan penelusuran pada file pengaturan server GoFiber, aturan CORS diatur secara terbuka:
<pre><code>// Lokasi: account-service/infrastructure/rest/serve
app.Use(cors.New(cors.Config{
 AllowOrigins: "*", // &lt;-- SANGAT BERBAHAYA
 AllowHeaders: "Origin, Content-Type, Accept, 
 AllowMethods: "GET, POST, PUT, DELETE, OPTIO
 AllowCredentials: false,
}))</code></pre>
    </li>
    <li><strong>Analisis Kerentanan:</strong> Pengaturan <code>AllowOrigins: "*"</code> berarti <strong>APAPUN dan SIAPAPUN</strong> di internet (domain peretas, aplikasi asing) dapat mengirimkan request Ajax/Fetch ke API <code>dev-api.alazhar.or.id</code> tanpa diblokir oleh peramban pengguna. Ini adalah miskonfigurasi yang sering dieksploitasi untuk serangan CSRF (Cross-Site Request Forgery) sekunder.</li>
</ul>

<p><strong>[!CAUTION] Rekomendasi:</strong> Konfigurasi CORS harus segera diperketat berdasarkan <em>Environment Variables</em>. Untuk <em>production</em>, pastikan <code>AllowOrigins</code> diisi spesifik hanya untuk domain frontend (misal: <code>"https://admin.alazhar.or.id"</code>).</p>

<h3>3. Rate Limiting &amp; Perlindungan Brute-Force</h3>
<p><strong>Status:</strong> &#9888; <strong>Tidak Ditemukan Proteksi Aktif</strong></p>

<ul>
    <li><strong>Pengecekan Kode:</strong> Tidak ditemukan implementasi middleware Rate Limiter (seperti <code>fiber/v2/middleware/limiter</code>) pada level aplikasi Golang (di <code>server.go</code> maupun rute spesifik seperti <code>/login</code> dan <code>/otp/request</code>).</li>
    <li><strong>Analisis Kerentanan:</strong> Ketiadaan batasan request membuat endpoint autentikasi sangat rentan terhadap <strong>Serangan Brute-Force</strong> (peretas mencoba ribuan kombinasi kata sandi) dan <strong>DDoS (Distributed Denial of Service)</strong> yang bisa membuat server down akibat kehabisan memori.
        <ul>
            <li>Endpoint <code>/otp/request</code> berpotensi dieksploitasi untuk serangan <em>SMS/WhatsApp Bombing</em>, yang mana peretas membanjiri nomor korban dengan OTP, mengakibatkan perusahaan membengkak tagihan Fonnte/Qontak-nya.</li>
        </ul>
    </li>
</ul>

<p><strong>[!WARNING] Rekomendasi:</strong> Wajib menambahkan Rate Limiter berbasis IP atau Username. Misalnya, batasi maksimal 5 percobaan login atau request OTP dalam waktu 15 menit.</p>

<h3>4. Skema Validasi Input (Data Validation)</h3>
<p><strong>Status:</strong> &#9888; <strong>Terlalu Sederhana (Manual Validation)</strong></p>

<ul>
    <li><strong>Frontend:</strong> Validasi input form tidak menggunakan pustaka standar industri (seperti <code>Yup</code> atau <code>Zod</code>). Tim menggunakan kode validasi kostum buatan sendiri (<code>frontend/packages/libs/src/formValidator.ts</code>). Walaupun bekerja (mengecek <code>minLength</code>, <code>onlyNumber</code>), ini rentan terhadap <em>edge-cases</em> dan sulit diperluas (scale) untuk tipe data yang kompleks.</li>
    <li><strong>Backend:</strong> Terdapat kerangka fungsi <code>middleware.Validator()</code> di GoFiber, namun statusnya masih kosong (hanya berisi komentar: <code>// Bisa tambahkan validasi global di sini</code>). Pengecekan saat proses login hanya menggunakan operator dasar (<code>if data.Username != ""</code>). Tidak ditemukan penggunaan pustaka seperti <code>go-playground/validator</code> yang umumnya digunakan untuk memvalidasi request payload secara ketat sebelum data menyentuh logika bisnis (usecase).</li>
</ul>

<p><strong>[!TIP] Rekomendasi Praktik Terbaik:</strong> Implementasikan Data Transfer Object (DTO) validation di backend menggunakan Struct Tags (misal: <code>validate:"required,email"</code>). Backend <strong>tidak boleh</strong> mempercayai validasi dari frontend, karena peretas bisa membypass UI frontend dan menembak API secara langsung.</p>
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisAPIEndpointSeeder extends Seeder
{
    public function run(): void
    {
        // Get Admin User dynamically
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        // Kategori: Analisis Sistem
        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Analisis Sistem ALAZHARAPPS')],
            ['name' => 'Analisis Sistem ALAZHARAPPS']
        );

        $content = <<<HTML
<p>Dokumen ini meringkas arsitektur titik temu (Endpoint) API yang bertindak sebagai jembatan komunikasi antara klien (Frontend/Mobile) dan pelayan (Backend) di ekosistem ALAZHARAPPS.</p>

<h3>1. Pendekatan RESTful API</h3>
<p>Komunikasi keluar (External Communication) dari klien ke backend dilayani menggunakan arsitektur REST (Representational State Transfer) murni dengan muatan data berupa JSON. Pola pengalamatannya diatur secara rapi berdasarkan versi (Versioning) di dalam direktori <code>infrastructure/rest/routes</code>.</p>
<ul>
    <li><strong>Rute Autentikasi Publik:</strong> <code>POST /api/v1/auth/login</code>, <code>POST /api/v1/auth/otp/request</code>. Endpoint ini umumnya tidak membutuhkan token JWT karena di sinilah siklus login bermula.</li>
    <li><strong>Rute Terproteksi (Protected Routes):</strong> Semua endpoint dengan awalan fitur inti seperti <code>/api/v1/users/*</code>, <code>/api/v1/students/*</code>, atau <code>/api/v1/transactions/*</code> dibungkus oleh sebuah *Middleware* JWT. Jika *Request* dari frontend tidak menyertakan *Header Authorization: Bearer [Token]*, maka API akan menolaknya dengan pesan galat <em>401 Unauthorized</em>.</li>
    <li><strong>Struktur Respons Standar:</strong> Pengembang backend menggunakan pembungkus JSON standar agar frontend mudah mengurainya, contohnya: <code>{ "meta": { "code": 200, "message": "Success" }, "data": { ... } }</code>. Ini sesuai dengan *Coding Standards* untuk respons REST API modern.</li>
</ul>

<h3>2. Dokumentasi Otomatis (Swagger / OpenAPI)</h3>
<p>Dalam proyek terdistribusi yang besar (lebih dari 10 servis), dokumentasi manual melalui *file teks* sangat berisiko kedaluwarsa. Oleh karenanya, pengembang backend ALAZHARAPPS menerapkan anotasi (komentar) langsung di atas *handler* fungsi GoFiber.</p>
<ul>
    <li>Anotasi ini (contoh: <code>// @Summary Get User List</code>) dibaca oleh pustaka seperti <code>swaggo/swag</code> saat kompilasi.</li>
    <li>Hasilnya, sistem secara otomatis menghasilkan berkas <code>swagger.json</code> dan merender antarmuka UI interaktif yang biasanya dapat diakses di rute <code>/api/v1/docs/index.html</code> (jika rute Swagger tidak dimatikan pada *production*).</li>
</ul>

<h3>3. Komunikasi Internal (gRPC Protocol)</h3>
<p>Walaupun Klien menggunakan REST, antar-servis backend (Internal Communication) berbicara satu sama lain menggunakan gRPC.</p>
<ul>
    <li>Protokol RPC (Remote Procedure Call) ini menggunakan skema biner (Protobuf) yang sangat ringan dan berkali-kali lipat lebih cepat daripada REST JSON.</li>
    <li>Sebagai contoh, saat <code>transaction-service</code> ingin mendapatkan nama lengkap siswa, ia tidak memanggil <em>REST API</em> milik <code>student-service</code>, melainkan menggunakan klien gRPC internal melalui porta 9090. Hal ini secara drastis menekan latensi aplikasi (*response time*) pada saat trafik sedang tinggi.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('11. Dokumentasi API (Endpoint Summary)')],
            [
                'title' => '11. Dokumentasi API (Endpoint Summary)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

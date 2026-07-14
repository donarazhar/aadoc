<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisOtorisasiRBACSeeder extends Seeder
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
<p>Dokumen ini membedah arsitektur keamanan tingkat lanjut pada ALAZHARAPPS, khususnya implementasi Matriks Otorisasi dan Hak Akses Berjenjang (Role-Based Access Control / RBAC) yang membentengi ratusan endpoint API.</p>

<h3>1. Arsitektur Role &amp; Permission (RBAC)</h3>
<p>Karena ALAZHARAPPS digunakan oleh puluhan sekolah di bawah naungan yayasan, struktur hak aksesnya sangat kompleks (Multi-Tenant RBAC). Model data dasar di dalam <code>account-service</code> berpusat pada 3 entitas utama:</p>
<ul>
    <li><strong>Users:</strong> Individu otentik yang melakukan *login*.</li>
    <li><strong>Roles (Peran):</strong> Jabatan abstrak, contoh: <code>Superadmin</code>, <code>Principal</code> (Kepala Sekolah), <code>Teacher</code>, <code>Finance</code>, <code>Student</code>, dan <code>Parent</code>.</li>
    <li><strong>Permissions (Hak Spesifik):</strong> Izin granular terkecil, contoh: <code>create_student</code>, <code>delete_invoice</code>, <code>view_report_card</code>.</li>
</ul>
<p>Sebuah <em>Role</em> akan memiliki sekumpulan <em>Permissions</em>. Pengguna (User) kemudian dihubungkan ke <em>Role</em>. Khusus untuk posisi seperti Kepala Sekolah atau Guru, <em>Role</em> mereka juga diikat ke <strong>School_ID</strong> tertentu agar seorang Kepala Sekolah TK tidak bisa melihat data transaksi unit SD.</p>

<h3>2. Siklus JWT (JSON Web Token)</h3>
<p>Tim pengembangan mengandalkan JWT (melalui pustaka internal <code>jwtaccess</code>) untuk mendistribusikan informasi otorisasi ke seluruh *microservices* secara *stateless* (tanpa membebani *database* untuk mengecek akses di setiap klik).</p>
<ol>
    <li>Saat berhasil login di <code>account-service</code>, *backend* mencetak (sign) string JWT menggunakan <code>JWT_SECRET</code>.</li>
    <li>Di dalam JWT <em>Payload (Claims)</em>, tidak hanya disematkan <code>user_id</code>, tetapi juga disisipkan <em>array</em> dari <code>roles</code> dan <code>school_id</code> pengguna tersebut (contoh: <code>"role": "finance", "school_id": 5</code>).</li>
    <li>Frontend (NextJS) atau Mobile menerima token ini dan menyimpannya (idealnya di dalam <em>HttpOnly Cookie</em> untuk Web, atau <em>Secure Storage</em> untuk Mobile). Di setiap pemanggilan API (seperti mengecek data murid), token ini dilampirkan di dalam <em>Header Authorization: Bearer [TOKEN]</em>.</li>
</ol>

<h3>3. Mekanisme Kunci pada Golang Middleware</h3>
<p>Bagaimana layanan lain (seperti <code>student-service</code>) tahu bahwa yang mengakses adalah seorang Admin Keuangan? Di sinilah peran <strong>API Middleware</strong> Golang bekerja.</p>
<ul>
    <li>Sebelum kode program masuk ke lapisan <em>Usecase</em> (logika bisnis), *request* akan ditangkap oleh *Middleware Auth*.</li>
    <li>*Middleware* ini akan mengurai (parse) JWT menggunakan <code>JWT_SECRET</code> publik/bersama. Jika tanda tangannya (*signature*) valid dan belum kedaluwarsa, ia akan mengekstrak informasi <code>role</code> dari token.</li>
    <li>Jika *Endpoint* dideklarasikan dengan syarat <em>"Hanya bisa diakses oleh Role: Finance"</em>, maka *Middleware* akan mencocokkannya dengan isi token. Jika pengguna terdeteksi sebagai <code>Student</code>, *Middleware* langsung menendang *request* dengan kode respons <strong>403 Forbidden</strong> tanpa pernah menyentuh <em>database</em> sama sekali.</li>
    <li><strong>Isolasi Multi-Tenant:</strong> Pada level *Usecase*, klaim <code>school_id</code> dari JWT digunakan secara otomatis pada setiap <em>query</em> SQL (contoh: <code>WHERE school_id = ?</code>) untuk memastikan kebocoran data silang-sekolah (*Cross-Tenant Data Leakage*) mustahil terjadi.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('13. Matriks Otorisasi & Hak Akses Berjenjang (RBAC)')],
            [
                'title' => '13. Matriks Otorisasi & Hak Akses Berjenjang (RBAC)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

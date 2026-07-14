<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisSkemaDatabaseSeeder extends Seeder
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
<p>Dokumen ini memetakan desain fisik dari pangkalan data (database) yang digunakan oleh aplikasi ALAZHARAPPS, khususnya pola pemisahan data pada arsitektur <em>microservices</em>.</p>

<h3>1. Pola Database per Layanan (Database-per-Service)</h3>
<p>ALAZHARAPPS menerapkan pola desain terdistribusi di mana setiap <em>microservice</em> memiliki skema atau basis datanya sendiri. Hal ini ditunjukkan oleh konfigurasi di masing-masing repositori:</p>
<ul>
    <li><strong>Isolasi Data:</strong> Layanan <code>account-service</code> hanya memiliki akses ke tabel yang berkaitan dengan pengguna dan kredensial (misalnya <code>users</code>, <code>roles</code>, <code>permissions</code>). Layanan <code>student-service</code> memegang tabel <code>students</code>, <code>parents</code>, dan <code>enrollments</code>.</li>
    <li><strong>Tidak Ada JOIN Lintas Layanan:</strong> Karena data terpisah, tidak mungkin melakukan *SQL JOIN* langsung antara tabel *User* dan tabel *Student*. Sebagai gantinya, layanan-layanan ini berkomunikasi lewat API (gRPC/REST) untuk menggabungkan data (*Data Composition*).</li>
</ul>

<h3>2. Entitas Utama dan Migrasi (Migrations)</h3>
<p>Skema tabel dikelola menggunakan mekanisme migrasi (migration) bawaan dari GORM (AutoMigrate) atau alat pihak ketiga seperti Golang Migrate (berdasarkan file <code>.sql</code> di dalam direktori <code>infrastructure/postgres/migrations</code>).</p>
<ul>
    <li><strong>Tabel Pengguna (<code>users</code>):</strong> Berisi kolom standar keamanan (<code>id</code>, <code>email</code>, <code>password_hash</code>). Terlihat penggunaan UUID (Universal Unique Identifier) pada <em>Primary Key</em> sebagai standar keamanan, alih-alih integer *Auto Increment*, untuk mencegah *ID Enumeration Attack*.</li>
    <li><strong>Tabel Relasional:</strong> Penggunaan *Foreign Key* diatur ketat (dengan klausa <code>ON DELETE CASCADE</code> atau <code>SET NULL</code>) untuk menjaga konsistensi data (*Referential Integrity*).</li>
    <li><strong>Kolom Pelacakan Audit (Audit Trails):</strong> Hampir setiap tabel penting memiliki kolom <code>created_at</code>, <code>updated_at</code>, <code>deleted_at</code> (mendukung <em>Soft Deletes</em>), dan <code>created_by</code>. Hal ini sangat penting untuk aplikasi pendidikan guna melacak siapa operator atau admin yang mengubah data nilai atau mutasi.</li>
</ul>

<h3>3. Optimasi Skema (Indeks)</h3>
<p>Berdasarkan model data (<em>structs</em> di Golang), terlihat penggunaan *tag* khusus (seperti <code>gorm:"index"</code>) pada kolom-kolom yang sering dicari, seperti <code>email</code>, <code>nisn</code>, atau <code>school_id</code>. Pengindeksan ini sangat krusial untuk mencegah penurunan performa saat tabel siswa atau transaksi mencapai jutaan baris.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('4. Skema Database & Entitas Tabel Berdasarkan Migrasi')],
            [
                'title' => '4. Skema Database & Entitas Tabel Berdasarkan Migrasi',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

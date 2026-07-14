<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanERDSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Analisis Sistem ALAZHARAPPS')],
            ['name' => 'Analisis Sistem ALAZHARAPPS']
        );

        $content = <<<HTML
<p>Dokumen ini menyajikan <strong>Entity Relationship Diagram (ERD)</strong> logis dari tabel-tabel paling kritikal yang menyangga aplikasi ALAZHARAPPS. Meskipun secara fisik tabel-tabel ini terpisah di beberapa <em>database microservices</em> yang berbeda (seperti <code>account-service</code>, <code>student-service</code>, dan <code>transaction-service</code>), diagram ini menunjukkan bagaimana mereka saling berelasi secara bisnis.</p>

<h3>Diagram Relasi Entitas Inti (Core ERD)</h3>
<pre><code class="language-mermaid">
erDiagram
    %% Account Service (Manajemen Pengguna & Akses)
    USERS {
        uuid id PK
        string email
        string password
        boolean is_active
        timestamp created_at
    }
    ROLES {
        int id PK
        string role_name
    }
    ROLE_LEVELS {
        int id PK
        string label
    }
    USER_HAS_ROLES {
        uuid user_id FK
        int role_id FK
        int role_level_id FK
        int school_id FK
    }

    %% Student Service (Master Data Sekolah)
    SCHOOLS {
        int id PK
        string school_name
        string address
    }
    CLASSES {
        uuid id PK
        int school_id FK
        string class_name
        string academic_year
    }
    STUDENTS {
        uuid id PK
        uuid user_id FK
        string nisn
        string full_name
        string status
    }
    STUDENT_CLASSES {
        uuid student_id FK
        uuid class_id FK
    }

    %% Transaction Service (Keuangan)
    INVOICES {
        uuid id PK
        uuid student_id FK
        string invoice_number
        decimal amount
        string status "UNPAID / PAID"
        date due_date
    }
    PAYMENTS {
        uuid id PK
        uuid invoice_id FK
        string payment_method
        decimal amount_paid
        timestamp paid_at
    }

    %% Relasi (Relationships)
    USERS ||--o{ USER_HAS_ROLES : "memiliki akses"
    ROLES ||--o{ USER_HAS_ROLES : "ditugaskan ke"
    ROLE_LEVELS ||--o{ USER_HAS_ROLES : "menentukan hierarki"
    
    SCHOOLS ||--o{ CLASSES : "memiliki"
    SCHOOLS ||--o{ USER_HAS_ROLES : "mengisolasi data (tenant)"
    
    USERS ||--o| STUDENTS : "terhubung sebagai (jika role murid/ortu)"
    CLASSES ||--o{ STUDENT_CLASSES : "berisi"
    STUDENTS ||--o{ STUDENT_CLASSES : "terdaftar di"
    
    STUDENTS ||--o{ INVOICES : "memiliki tagihan"
    INVOICES ||--o{ PAYMENTS : "dibayar melalui"
</code></pre>

<h3>Penjelasan Relasi Kritis</h3>
<ul>
    <li><strong>Isolasi Multi-Tenant (Multi-Sekolah):</strong> Tabel <code>USER_HAS_ROLES</code> bertindak sebagai jembatan yang menghubungkan Pengguna dengan Peran (Misal: Admin Keuangan), dan langsung mengikatnya ke <code>school_id</code> tertentu. Ini memastikan Admin SD tidak bisa melihat data SMP.</li>
    <li><strong>Pemisahan Akun &amp; Identitas:</strong> Tabel <code>USERS</code> hanya menyimpan <em>Email</em> dan <em>Password</em> untuk otentikasi (berada di <code>account-service</code>). Identitas aslinya (Nama, NISN, Golongan Darah) disimpan secara terpisah di tabel <code>STUDENTS</code> (berada di <code>student-service</code>). Relasi antar keduanya dijembatani oleh <code>user_id</code>.</li>
    <li><strong>Relasi Keuangan:</strong> Tabel <code>INVOICES</code> (Tagihan SPP) menempel langsung ke <code>STUDENTS</code> (menggunakan <code>student_id</code>), bukan ke orang tua. Satu tagihan (misal SPP Juli) bisa dilunasi melalui beberapa kali cicilan <code>PAYMENTS</code> (meskipun pada ALAZHARAPPS mayoritas adalah lunas penuh via <em>Virtual Account</em>).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('10. Gambaran Nyata ERD (Entity Relationship Diagram)')],
            [
                'title' => '10. Gambaran Nyata ERD (Entity Relationship Diagram)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

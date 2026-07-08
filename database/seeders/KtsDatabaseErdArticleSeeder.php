<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsDatabaseErdArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryName = 'Knowledge Transfer Session (KTS)';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Dokumentasi hasil sesi transfer pengetahuan terkait proyek Fintech Al-Azhar Apps.',
            ]
        );

        $title = 'Skema Database (ERD)';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Skema Database & Entitas Tabel Berdasarkan Migrasi

Berdasarkan eksplorasi ke dalam *file migration* (Liquibase XML) dan entitas *domain* di masing-masing service, berikut adalah skema detail ERD (*Entity Relationship Diagram*) yang menjabarkan nama-nama tabel yang ada secara riil pada database tiap-tiap *microservices*.

### Struktur Global Antar Service

```mermaid
erDiagram
    %% ==========================================
    %% ACCOUNT SERVICE (AutoMigrate)
    %% ==========================================
    users ||--o{ user_has_roles : "memiliki"
    roles ||--o{ user_has_roles : "ditetapkan di"
    role_levels ||--o{ user_has_roles : "tingkat"
    
    users {
        uuid id PK
        string name
        string username
        string phone
        string email
        string nik
        string password
        int status
    }
    user_has_roles {
        int id PK
        uuid user_id FK
        int role_id FK
        int role_level_id FK
        uuid school_id FK
        uuid student_id FK
        uuid personnel_id FK
    }
    roles {
        int id PK
        string role_name
    }
    role_levels {
        int id PK
        string label
    }

    %% ==========================================
    %% SCHOOL SERVICE (Liquibase XML Migrations)
    %% ==========================================
    schools ||--o{ facilities : "memiliki"
    schools ||--o{ extracurriculars : "memiliki"
    schools ||--o{ awards : "penghargaan"
    schools ||--o{ school_programs : "menyelenggarakan"
    programs ||--o{ school_programs : "program"
    schools ||--o{ admissions : "buka pendaftaran (master)"
    schools ||--o{ endowment_fees : "biaya SPP/pangkal"
    schools ||--o{ batchs : "gelombang"
    
    schools {
        uuid id PK
        string institution_name
        string principal_name
        string address
        string npsn
    }
    school_programs {
        uuid id PK
        uuid school_id FK
        uuid program_id FK
    }
    programs {
        uuid id PK
        string name
    }
    facilities {
        uuid id PK
        uuid school_id FK
        string name
    }
    extracurriculars {
        uuid id PK
        uuid school_id FK
        string name
    }
    endowment_fees {
        uuid id PK
        uuid school_id FK
        float amount
    }
    batchs {
        uuid id PK
        uuid school_id FK
        string name
    }

    %% ==========================================
    %% STUDENT SERVICE (Liquibase XML Migrations)
    %% ==========================================
    students ||--o{ admission_medical_records : "riwayat medis"
    students ||--o{ admission_parents : "data orangtua"
    
    students {
        uuid id PK
        uuid user_id FK
        string nis
        string nisn
        string nik
        string language
        int child_number
    }
    admissions {
        uuid id PK
        uuid student_id FK
        uuid school_id FK
        string registration_number
    }
    admissions ||--o{ admission_former_schools : "asal sekolah"
    admissions ||--o{ admission_destination_schools : "tujuan sekolah"
    admissions ||--o{ admission_parents : "orang tua"
    admissions ||--o{ admission_medical_records : "rekam medis"
    admissions ||--o{ admission_documents : "dokumen lampiran"
    admissions ||--o{ admission_achievements : "prestasi"
    admissions ||--o{ admission_exams : "ujian masuk"

    %% ==========================================
    %% TRANSACTION SERVICE (Liquibase XML Migrations)
    %% ==========================================
    bills ||--o{ discounts : "memiliki diskon"
    bills ||--o{ additional_fees : "biaya tambahan"
    payment_channels ||--o{ settlements : "via"
    
    bills {
        uuid id PK
        uuid payer_id FK
        string bill_type
        float amount
        float discount
        string status
        bool is_installment
    }
    discounts {
        uuid id PK
        uuid bill_id FK
        float amount
        string reason
    }
    additional_fees {
        uuid id PK
        uuid bill_id FK
        float amount
    }
    payment_channels {
        uuid id PK
        string name
        string type
    }
    institution_va_accounts {
        uuid id PK
        string bank_code
        string va_number
    }
    settlements {
        uuid id PK
        uuid bill_id FK
        float settled_amount
    }
    settlement_accounts {
        uuid id PK
        string account_number
        string bank_name
    }
    settlement_reports {
        uuid id PK
        uuid settlement_id FK
    }

    %% ==========================================
    %% RELASI LOGIS (VIRTUAL RELATIONS ACROSS Dbs)
    %% ==========================================
    user_has_roles }..|| students : "student_id"
    user_has_roles }..|| schools : "school_id"
    admissions }..|| schools : "school_id"
    bills }..|| students : "payer_id = student_id"

```

### Penjelasan Detail Tiap Modul (Service)

**1. Account Service** *(Tidak Menggunakan XML Migration, melainkan GORM AutoMigrate)*
Merupakan *service* fondasi untuk RBAC (Role-Based Access Control).
- `users`: Data utama pengguna (Email, Password, NIK, Status).
- `roles` & `role_levels`: Definisi hak akses seperti "Siswa", "Guru", "Admin", dsb.
- `user_has_roles`: Tabel jembatan relasional yang paling krusial. Tabel ini menghubungkan satu user menjadi seorang aktor tertentu, misalnya User A bertindak sebagai siswa (dihubungkan dengan kolom `student_id`), atau User B bertindak sebagai pegawai di sekolah X (dihubungkan dengan `school_id` dan `personnel_id`).

**2. School Service** *(Liquibase: `001` - `018` XML Migrations)*
Modul master organisasi kependidikan.
- `schools`: Identitas utama institusi Al-Azhar, termasuk email, nama kepsek, NPSN, hingga alamat detail.
- Master pendukung sekolah: `facilities`, `extracurriculars`, `awards`, `programs` (program studi), `batchs` (gelombang pendaftaran).
- Master Keuangan Sekolah: `endowment_fees` (biaya pangkal / sumbangan wajib per sekolah).
- Master Pendaftaran: `admissions` (setting pembukaan pendaftaran siswa).

**3. Student Service** *(Liquibase: `001` - `999` XML Migrations)*
Berfungsi ganda sebagai penyimpanan data siswa aktif dan jalur aplikasi Penerimaan Peserta Didik Baru (PPDB).
- `students`: Profil data lengkap siswa yang mencakup NIK, NIS, NISN.
- `admissions` (pendaftaran siswa): Mencatat registrasi calon siswa. Relasi tabel yang bercabang dari ini sangat kompleks untuk mendukung formulir pendaftaran, yaitu:
  - `admission_parents`: Data Ayah, Ibu, Wali.
  - `admission_former_schools` & `admission_destination_schools`: Data sekolah asal dan yang dituju.
  - `admission_medical_records`: Rekam jejak medis anak.
  - `admission_documents`, `admission_achievements`, `admission_exams`: Kelengkapan berkas, prestasi, dan hasil ujian.

**4. Transaction Service** *(Liquibase: `001` - `040` XML Migrations)*
Pusat manajemen keuangan (fintech) untuk tagihan dan cicilan.
- **Billing**: `bills` adalah pusat tagihan, terhubung dengan `additional_fees` dan `discounts` (potongan biaya).
- **Payment & Webhooks**: Memiliki integrasi bank langsung (`institution_va_accounts`) serta tabel *webhook* untuk mendengarkan *callback* pembayaran dari pihak ke-3 seperti Midtrans, Nobu Bank, VA, dan QRIS (`webhook_midtrans`, `webhook_nobu`, dsb).
- **Settlement & Reporting**: Mengatur pencairan/pengendapan dana (rekonsiliasi) melalui tabel `settlements`, `settlement_accounts`, `settlement_reports`, serta pendistribusian rekening `settlement_account_schools`, `settlement_account_ypia`.

> [!TIP]
> Garis putus-putus (`..`) pada diagram di atas merepresentasikan **Relasi Virtual (Logical Constraint)** antar *service*. Karena letaknya di *database* berbeda secara fisik, maka relasi *Foreign Key* (FK) SQL tidak dapat dibentuk dan hanya dijaga integritas datanya di tingkat kode API backend.

EOT
        );

        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;
        while(Document::where('slug', $slug)->exists()) {
            $existingDoc = Document::where('slug', $slug)->first();
            if ($existingDoc->title === $title) {
                break;
            }
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Document::updateOrCreate(
            ['slug' => $slug],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 4
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsManajemenDataArticleSeeder extends Seeder
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

        $title = 'Manajemen Data';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Strategi Manajemen Data (Backup & Archiving)

Berdasarkan penelusuran terhadap basis kode (*codebase*) dari keseluruhan *microservices* dan proyek pendukungnya, berikut adalah analisis mengenai strategi **Backup, Recovery, dan Data Archiving** yang diterapkan pada sistem Fintech Al-Azhar Apps.

---

## 1. Strategi Backup & Recovery

Setelah melakukan pemindaian menyeluruh, **tidak ditemukan adanya skrip otomatisasi backup (seperti *cron job*, *pg_dump*, atau skrip shell harian)** di dalam repositori aplikasi Golang maupun Next.js ini.

Hal ini mengindikasikan bahwa proyek ini menganut arsitektur modern di mana **Manajemen Basis Data dipisahkan secara ketat dari *Codebase* Aplikasi (Infrastructure as a Service)**.

**Kesimpulan Backup & Recovery:**
- **Level Infrastruktur**: Proses pencadangan (*backup*) kemungkinan besar ditangani sepenuhnya di level infrastruktur / DevOps (misalnya menggunakan fitur *Automated Backups & Snapshots* bawaan dari Cloud Provider seperti AWS RDS, Google Cloud SQL, atau kluster *database* spesifik).
- **Pemulihan (Recovery)**: Mengandalkan fitur *Point-in-Time Recovery* (PITR) dari sisi penyedia *database* (*Cloud*), bukan mengandalkan skrip *restore* manual yang dipanggil oleh aplikasi. Hal ini tertulis pula di dalam dokumen *Privacy Policy* *frontend* bahwa "Data di-backup secara berkala untuk mencegah kehilangan data", yang menunjukkan adanya jaminan infrastruktur eksternal.

---

## 2. Pembersihan Data (*Data Archiving*) & Retensi

Untuk strategi pembersihan data secara berkala, sistem tidak melakukan "penghapusan murni" yang membuang data selamanya. Strateginya dibagi menjadi dua pendekatan:

### A. Strategi *Soft Delete* (Level Aplikasi Harian)
Jika Anda melihat skema migrasi database (Liquibase) di hampir semua *service*, setiap tabel utama selalu dibekali kolom `deleted_at`:
```xml
<column name="deleted_at" type="TIMESTAMP WITH TIMEZONE"/>
```
- **Cara Kerja**: Aplikasi Golang (melalui ORM GORM) menggunakan fitur **Soft Delete**. Saat sebuah data dihapus melalui API, data tersebut **tidak benar-benar dihapus (hard delete)** dari tabel PostgreSQL. Sistem hanya akan mengisi kolom `deleted_at` dengan waktu saat ini.
- **Tujuan (Audit & Arsip Ringan)**: Pendekatan ini memastikan data historis transaksi keuangan atau data pendaftaran siswa tetap utuh dan aman di dalam database untuk keperluan audit/investigasi di masa depan, meskipun data tersebut tidak lagi dimunculkan di UI aplikasi.

### B. Strategi Proses ETL (Level Periode / Semesteran)
Untuk pembersihan, perpindahan, atau pengarsipan data secara massal (*bulk archiving*), proyek ini mendelegasikan tugas tersebut ke dalam modul khusus **`etl-main`** (Extract, Transform, Load).

Di dalam modul ini ditemukan bukti aktivitas data secara periodik:
- **Dokumen Panduan**: Terdapat file *"Panduan Stored Procedure untuk Perpindahan Semester.docx"*.
- **Skrip Kustom**: File seperti `query_insert_bill_from_bill_raw.sql` dan `query_insert_student_from_student_raw.sql`.

**Cara Kerja *Archiving* Berkala**:
- Alih-alih membebani *microservice* API yang melayani pengguna (*real-time*), proses pemindahan data berkapasitas besar (seperti arsip kelulusan siswa, penyiapan data awal semester baru, dan rekapitulasi data tagihan lama) dieksekusi secara manual/terjadwal melalui skrip ETL terpisah.
- Modul ETL ini akan mengambil "Data Mentah" (*raw*) atau data lama, memprosesnya, dan menaruhnya kembali ke dalam arsip tabel riil (atau sebaliknya).

---
**Kesimpulan**: 
Aplikasi ini sangat berhati-hati dengan data (karena berurusan dengan Fintech dan Pendidikan). Sistem tidak pernah menghapus data secara permanen secara sepihak dari sisi aplikasi (*Soft Delete*). Sedangkan untuk pencadangan bencana dan pengarsipan massal tutup tahun/semester, tugas tersebut dialihkan keluar dari kode Golang, yakni ke *Database Cloud Infrastructure* dan skrip *ETL terpisah*.

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
                'order' => 6
            ]
        );
    }
}
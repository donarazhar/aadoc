<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsQueryKritisArticleSeeder extends Seeder
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

        $title = 'Analisis Query Kritis';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Analisis Query Kritis & Logika Database

Berdasarkan peninjauan mendalam pada seluruh *file migration* (Liquibase XML) dan repositori kode secara menyeluruh, berikut adalah hasil analisis mengenai penggunaan Stored Procedures, Triggers, maupun View kompleks di tingkat *database*.

### 1. Temuan: Tidak Ada Stored Procedure & Trigger Kompleks
Setelah menelusuri skrip migrasi (pencarian tag `<createProcedure>`, `<createView>`, `CREATE TRIGGER`, maupun blok `<sql>`), **tidak ditemukan adanya *Stored Procedure*, *Trigger*, ataupun *View* yang menyimpan logika bisnis utama**.

Satu-satunya *raw query* SQL yang dieksekusi langsung ke database pada tahap migrasi hanyalah pengaturan utilitas dasar PostgreSQL, yakni:
```sql
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";
```
Skrip di atas digunakan murni untuk memungkinkan pembuatan *Universally Unique Identifier* (UUID) bawaan, bukan untuk mengatur alur data.

### 2. Mengapa Demikian? (Keputusan Arsitektural)
Ketiadaan *Trigger* dan *Stored Procedure* ini bukan berarti sistem tidak memiliki logika bisnis yang kompleks, melainkan karena proyek ini mengadopsi pola pikir modern dalam ekosistem **Golang Microservices & Clean Architecture**:

- **Database is a Dumb Datastore**: Dalam arsitektur ini, *database* (seperti PostgreSQL) diperlakukan murni sebagai media penyimpanan (*storage*) pasif. Ia tidak boleh "berpikir" atau memanipulasi data secara tersembunyi.
- **Logika Berpindah ke *Application Layer***: Seluruh kalkulasi yang biasanya dilakukan oleh *trigger* (misalnya: ketika tabel `payments` berhasil di-insert, maka kurangi total tagihan di tabel `bills`) secara eksplisit diatur dan dikoding menggunakan **Bahasa Go** di dalam layer `usecase`.
- **Penggunaan ORM (GORM)**: Proyek ini sangat bergantung pada GORM. Proses relasi yang kompleks, *Cascading Delete*, dan validasi sebelum penyimpanan (*BeforeSave / AfterCreate hook*) dilakukan di memori aplikasi Golang menggunakan fitur GORM Hooks, bukan di mesin *database* itu sendiri.

### 3. Di Mana Logika Kritis Berada?
Jika Anda ingin menelusuri atau mengubah "Query Kritis" maupun "Trigger" (efek samping) yang memengaruhi jalannya bisnis utama (seperti rekonsiliasi pembayaran atau mutasi pendaftaran), Anda tidak akan menemukannya di SQL *database*, melainkan harus melihat pada direktori Golang berikut:

- **Layer Usecase (`/usecase`)**: Di setiap *microservice* (contoh: `transaction-service/usecase/settlement.go` atau `bill.go`), semua logika transaksional (seperti mengalkulasi total cicilan dan meng-update status tagihan berantai) berjalan melalui fungsi-fungsi Go.
- **GORM Database Transactions (`tx.Begin()`)**: Untuk memastikan atomicity data layaknya *stored procedure*, aplikasi menggunakan `gorm.Transaction`. Jika satu langkah kalkulasi pembayaran gagal di Golang, maka seluruh fungsi akan di-*rollback* (*undo*).
- **Domain Event / Message Broker**: Efek samping eksternal (seperti mengirimkan email tagihan sukses ketika data tagihan di-update) biasanya ditangani dengan mempublikasikan *event* ke RabbitMQ/Kafka, bukan menggunakan *Database Trigger* ke tabel *notification*.

---
**Kesimpulan**: 
Proyek Fintech Al-Azhar ini 100% tersentralisasi pada kode *backend* Golang-nya (*Application-Centric*). Tidak ada "Black Magic" atau proses logika gaib yang berjalan secara tersembunyi di balik layar PostgreSQL. Hal ini sangat menguntungkan karena mempermudah *versioning* kode, mempermudah *unit testing*, dan menghindari ketergantungan yang mengikat (vendor lock-in) pada satu spesifik merek *database*.

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
                'order' => 5
            ]
        );
    }
}
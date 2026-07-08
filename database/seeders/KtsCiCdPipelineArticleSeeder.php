<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsCiCdPipelineArticleSeeder extends Seeder
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

        $title = 'Analisis Deployment CI/CD';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Analisis Otomatisasi Deployment (CI/CD Pipeline)

Berdasarkan peninjauan pada berkas `.gitlab-ci.yml` di layanan *backend* maupun *frontend*, proyek **Fintech Al-Azhar Apps** menerapkan strategi otomatisasi (*deployment*) tingkat lanjut yang sangat efisien. 

Berikut adalah ulasan mendalam mengenai alur *pipeline* dan tips otomatisasi yang telah berjalan:

## 1. Arsitektur Terpusat (*Centralized Pipeline*)
Hal paling menarik dari *setup* CI/CD proyek ini adalah tidak dituliskannya tahapan *pipeline* secara berulang-ulang di setiap *microservice*. Sistem menggunakan pendekatan **Infrastructure as Code (IaC) terpusat**.

Setiap *microservice* (seperti `account-service` atau `frontend-develop`) hanya memiliki kode *include* yang memanggil templat utama dari repositori `al-azhar-iac/cicd-template`:
```yaml
include:
  - project: 'al-azhar-iac/cicd-template'
    ref: main
    file:
      - 'v1/app/go-backend-v1-account.yml' # Untuk Backend
      # atau 'v1/app/node-frontend-v1.yml' untuk Frontend
```
**Tips Otomatisasi (Keuntungan):**
Jika suatu saat ada perubahan versi Docker, perbaikan keamanan (SAST), atau perubahan alamat *server staging*, tim DevOps cukup mengubah kode di 1 (satu) repositori templat pusat. Maka puluhan *microservices* lainnya akan otomatis mendapatkan alur pembaruan (*pipeline*) yang seragam tanpa perlu mengubah kode `gitlab-ci.yml` satu per satu.

## 2. Alur Kerja (Workflow Pipeline)
Meski detail skrip utamanya disembunyikan di repositori *template*, berdasarkan konfigurasi `override` yang ada, kita bisa menarik kesimpulan mengenai alurnya:

### A. Tahap Build & Containerization (Docker)
Setiap pembaruan kode (Commit / Merge Request) akan memicu eksekusi Docker untuk membangun *image* (*Containerization*).
- **Docker Login & Registry**: Kode menyertakan skrip rahasia `$REGISTRY_USER` dan `$REGISTRY_PASSWORD` untuk masuk ke *private Docker Registry* guna menyimpan *image* hasil *build*.
- **Private Dependency Fetching**: Khusus untuk Golang (*Backend*), terdapat pengaturan *override* berkas `.netrc`. Ini sangat esensial karena proyek mengimpor *library* internal pribadi (seperti `scm.alazhar.or.id/al-azhar-apps/go-lib`). Berkas `.netrc` memungkinkan `go mod download` untuk mengautentikasi diri dan mengunduh pustaka privat tersebut di dalam *runner* GitLab sebelum dikompilasi oleh Docker.

### B. Tahap Lingkungan: Dev vs Prod
Terdapat pemisahan blok konfigurasi `build-dev` dan `build-prod`. 
- **`build-dev`**: Kemungkinan akan otomatis berjalan setiap kali ada *commit* baru ke *branch* `develop`. *Image* ini kemudian akan di-*deploy* ke *environment* Staging secara berkesinambungan (CI/CD).
- **`build-prod`**: Kemungkinan hanya berjalan apabila ada *commit* atau pembuatan Tag Rilis di *branch* `main`/`master`, yang menjamin stabilitas untuk pengguna akhir.

## 3. Proses Deployment
Berdasarkan dokumentasi *boilerplate* di `README.md` pada setiap *service*, setelah proses Docker Build selesai, tahap selanjutnya didistribusikan menggunakan orkestrator kontainer modern. Proyek ini menyarankan dan mendukung rilis melalui sistem pendorong otomatis (*Auto Deploy* ke Amazon EC2/ECS) atau rilis berbasis tarikan (*pull-based deployments*) seperti **GitLab Kubernetes Agent**.

---
**Kesimpulan**: 
Pipeline (*CI/CD*) di sistem ini didesain menggunakan **GitLab CI** dengan pola **Templat Sentral** dan berfokus pada hasil akhir berupa **Docker Container Image**. Hal ini memungkinkan penyebaran rilis (*deployment*) aplikasi Golang dan Next.js menjadi 100% otomatis, aman dari sisi pustaka privat (berkat injeksi `.netrc`), dan sangat gampang diskalakan (*highly scalable*) jika di masa depan akan ada puluhan layanan *microservice* tambahan.

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
                'order' => 9
            ]
        );
    }
}
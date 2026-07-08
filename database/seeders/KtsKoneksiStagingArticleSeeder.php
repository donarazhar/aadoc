<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsKoneksiStagingArticleSeeder extends Seeder
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

        $title = 'Informasi Koneksi Staging';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Informasi Koneksi & Kredensial Staging

Berdasarkan eksplorasi ke seluruh berkas konfigurasi repositori, berikut adalah informasi yang berhasil dikumpulkan terkait akses lingkungan *staging* / *development*:

### 1. Kredensial Basis Data (PostgreSQL & Redis)
Di dalam kode *backend*, tidak ditemukan satupun kredensial asli (berupa *password* nyata atau *IP host*) yang dituliskan / di-*commit* secara langsung (*hardcoded*).

Satu-satunya contoh konfigurasi yang ada di dalam `backend-codebase-main/config.dev.env` berisi nilai buatan (dummy) sebagai templat:
```env
DB.DRIVER="postgres"
DB.HOST="host"
DB.PORT=1234
DB.NAME="salam"
DB.USERNAME="username"
DB.PASSWORD="password"

REDIS.HOST="redis_host"
REDIS.PORT=6379
```
**Apa artinya ini?**
Proyek ini mengadopsi prinsip keamanan *The Twelve-Factor App*. Konfigurasi asli, khususnya kata sandi *database*, tidak disimpan di repositori Git, melainkan disuntikkan secara dinamis saat aplikasi di-*deploy* ke server *staging* (baik melalui *Docker Environment Variables*, *Kubernetes Secrets*, atau *GitLab CI/CD Variables*). 

**Solusi Eksplorasi Data:**
Untuk dapat mengeksplorasi data di level SQL secara langsung, Anda wajib meminta akses (seperti IP *Database Host*, VPN, *Username*, dan *Password*) kepada tim **DevOps** atau **Infrastructure/System Administrator** yang memegang akses peladen (*server*).

### 2. URL Endpoint API (Staging)
Dari sisi *frontend* web (`frontend-develop/.env.development`), kredensial yang dapat diakses secara terbuka karena sifatnya *public* adalah:
- **Base URL API Staging (Dev)**: `https://dev-api.alazhar.or.id/v1`
- **ReCaptcha Site Key**: `6Le4iZwrAAAAAKNXz8hRNszlTYxTK_jRbXaKYiD6`

**Catatan Tambahan untuk Eksplorasi Mandiri:**
Jika Anda ingin mengeksplorasi secara fungsional tanpa membedah database menggunakan SQL, Anda dapat memanfaatkan Base URL API di atas (menggunakan Postman atau cURL) ke *endpoint* masing-masing service (misal `/account`, `/student`, `/transaction`) asalkan Anda telah membuat atau diberikan token akses JWT (*Bearer Token*) dari tim Anda.

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
                'order' => 7
            ]
        );
    }
}
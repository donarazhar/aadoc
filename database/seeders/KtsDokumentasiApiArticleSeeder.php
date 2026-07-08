<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsDokumentasiApiArticleSeeder extends Seeder
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

        $title = 'Dokumentasi API';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Dokumentasi API (Endpoint Summary)

Berdasarkan penelusuran mendalam terhadap seluruh arsitektur *microservices*, saya menemukan fakta krusial mengenai dokumentasi API pada proyek Fintech Al-Azhar Apps ini.

### 1. Status Dokumentasi Otomatis (Swagger / Postman)
Saat ini, proyek **belum mengadopsi atau memiliki dokumentasi API terpusat** (seperti *file* `swagger.yaml`, koleksi *Postman* `.json`, ataupun anotasi `@Router` yang masif melalui *swaggo/swag*). 

Oleh karena itu, **tidak mungkin untuk me- *generate* koleksi Postman yang instan** dari kode saat ini tanpa menulisnya satu per satu secara manual.

### 2. Cara Melacak dan Mengeksplorasi Endpoint Secara Mandiri
Karena ketiadaan *Swagger*, cara terbaik bagi Anda sebagai *developer* untuk membedah fungsi-fungsi API adalah dengan melihat berkas pengatur lalu lintas (*Routing*) di tiap-tiap *service*.

Proyek ini menggunakan *web framework* **Fiber** (Golang). Anda dapat melacak struktur API dengan mudah melalui berkas:
👉 `[nama-service]/infrastructure/rest/route.go` (atau di dalam `presentation/controller/`).

Di sana Anda akan menemukan pola pendaftaran *endpoint* (*Group*, *Get*, *Post*) yang sangat deskriptif.

### 3. Sampel Pemetaan Endpoint (Studi Kasus: Account Service)
Sebagai contoh, berdasarkan temuan di dalam file `account-service-develop/infrastructure/rest/route.go`, berikut adalah dokumentasi parsial dari modul Akun & Autentikasi:

#### A. Modul Otentikasi Terbuka (Public)
URL Base: `http://localhost:8080/`
| Method | Endpoint | Kegunaan |
|--------|----------|----------|
| `POST` | `/check-phone` | Mengecek ketersediaan / validitas nomor HP saat mendaftar. |
| `POST` | `/check-email` | Mengecek ketersediaan email pendaftar. |
| `POST` | `/register-mobile`| Pendaftaran profil pengguna dari aplikasi Mobile. |
| `POST` | `/register-web` | Pendaftaran profil pengguna dari antarmuka Web. |
| `POST` | `/login` | Proses *Login* yang akan mengembalikan token JWT. |
| `POST` | `/reset-pin` | Menyetel ulang PIN (Web). |

#### B. Modul OTP (One Time Password)
URL Base: `http://localhost:8080/otp/`
| Method | Endpoint | Kegunaan |
|--------|----------|----------|
| `POST` | `/request` | Meminta pengiriman OTP (ke WhatsApp/Email). |
| `POST` | `/verify` | Memvalidasi kode OTP yang dimasukkan *user*. |

#### C. Modul Terproteksi (Butuh JWT Token)
Endpoint berikut memerlukan *header* otentikasi: `Authorization: Bearer <token_jwt>`
| Method | Endpoint | Kegunaan |
|--------|----------|----------|
| `GET` | `/me` | Mendapatkan profil detail *user* yang sedang *login*. |
| `POST` | `/logout` | Keluar dari sesi. |
| `POST` | `/device-token` | Menyimpan token perangkat (Firebase) untuk Push Notification. |

#### D. Modul Notifikasi
URL Base: `http://localhost:8080/notifications/`
| Method | Endpoint | Kegunaan |
|--------|----------|----------|
| `GET` | `/user` | Mendapatkan daftar notifikasi milik pengguna. |
| `GET` | `/:id` | Detail spesifik sebuah notifikasi. |
| `PATCH`| `/:id/read` | Menandai satu notifikasi telah dibaca (*read*). |
| `DELETE`| `/:id` | Menghapus notifikasi. |

---

### Saran Peningkatan (Improvement)
Jika ke depannya proyek ini ingin memiliki halaman dokumentasi interaktif yang cantik layaknya *Swagger UI*, sangat disarankan agar tim backend mulai menyelipkan anotasi komentar *Swaggo* (contoh: `// @Summary`, `// @Router /login [post]`) di atas fungsi-fungsi *handler*-nya, lalu memicu perintah `swag init` agar *file JSON* generasinya dapat diimpor langsung ke Postman.

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
                'order' => 11
            ]
        );
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsStrukturProyekArticleSeeder extends Seeder
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

        $title = 'Struktur Proyek & Microservices';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Struktur Proyek & Arsitektur Microservices

Aplikasi Fintech Al-Azhar (YPIA) dikembangkan menggunakan pendekatan **Microservices Architecture**. Hal ini terlihat jelas dari pembagian folder (repositori) di akar proyek, di mana setiap *service* memiliki tanggung jawab fungsional yang terisolasi.

## 1. Pembagian Layanan (Services)

Berdasarkan eksplorasi direktori, kita dapat mengidentifikasi beberapa layanan mikro independen (semuanya ditulis dalam bahasa **Golang**):

- `account-service-develop`: Menangani autentikasi, otorisasi, profil pengguna, dan pendaftaran (PPDB/Ujian).
- `transaction-service-develop`: Pusat pemrosesan uang, tagihan (bills), *settlement*, rekonsiliasi, dan gerbang pembayaran.
- `school-service-new-develop`: Mengelola data master sekolah, tahun ajaran, dan pengaturan kurikulum.
- `student-service-develop`: Menyimpan dan mengelola data demografis serta profil akademik siswa.
- `report-service-develop`: Menyajikan fungsi pelaporan (PDF/Excel) untuk pihak manajemen.
- `etl-main`: Modul khusus untuk sinkronisasi data masal, ekstraksi, transformasi (perpindahan semester).

Selain *backend*, terdapat pula repositori *Frontend*:
- `frontend-develop`: Proyek berbasis Next.js (Monorepo Turborepo) untuk melayani antarmuka pengguna, baik itu portal wali murid, administrator, maupun panitia sekolah.
- `backend-codebase-main`: Berfungsi sebagai *library* / *template* standar struktur proyek Golang yang diadopsi oleh *microservices* lainnya.

## 2. Struktur Direktori Internal (Golang Clean Architecture)

Jika kita membedah isi salah satu *service* (misal: `account-service-develop`), kita akan menemukan konvensi folder yang sangat rapi dan ketat yang mengadopsi **Clean Architecture** ala Uncle Bob.

| Folder | Tujuan & Tanggung Jawab |
| --- | --- |
| `cmd/` | Titik masuk (entry point) eksekusi aplikasi (`main.go`). |
| `config/` | Berisi pengaturan konfigurasi sistem, variabel lingkungan (`.env`), dan inisialisasi koneksi statis. |
| `domain/` | Menyimpan *Entity* (Model GORM/Database), *DTO* (Data Transfer Object), dan *Interface Repository/Usecase*. Ini adalah jantung dari logika. Tidak boleh bergantung pada library eksternal. |
| `usecase/` | Tempat bernaungnya logika bisnis (Business Rules). Di sinilah kalkulasi transaksi, validasi berlapis, dan orkestrasi pemanggilan ke repositori terjadi. |
| `infrastructure/` | Layer untuk hal-hal teknis: implementasi akses ke PostgreSQL, Redis, Firebase, WhatsApp API, dll. |
| `presentation/` | Layer untuk jalur masuk (Delivery). Tempatnya *Controller* (REST/Fiber) dan *Handler* (gRPC). Ia hanya bertugas menerima request HTTP/RPC dan mem-parsingnya ke Usecase. |

## Kesimpulan

Pendekatan ini sangat cocok untuk skala *Enterprise*. Pemisahan *domain* bisnis dengan *delivery mechanism* (HTTP/RPC) memastikan sistem mudah diuji (*Unit Testing*) dan sangat fleksibel jika suatu saat framework (misal dari Fiber ganti ke Gin) perlu diganti tanpa mengubah logika bisnis utamanya.

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
                'order' => 1
            ]
        );
    }
}
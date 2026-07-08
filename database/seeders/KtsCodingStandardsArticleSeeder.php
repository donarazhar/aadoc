<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class KtsCodingStandardsArticleSeeder extends Seeder
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

        $title = 'Coding Standards';
        $content = \Illuminate\Support\Str::markdown(<<<'EOT'
# Panduan Gaya Penulisan Kode (Coding Standards)

Dokumen ini merangkum standar penulisan kode (*coding standards*), format, dan aturan *linting* yang diterapkan dalam proyek **Fintech Al-Azhar Apps**, baik pada sisi Backend (Golang) maupun Frontend (Next.js/TypeScript).

---

## 1. Frontend (Next.js & TypeScript)

Aturan penulisan kode di Frontend dikelola secara otomatis menggunakan *linter* dan *formatter* yang dikonfigurasi secara terpusat (*monorepo*).

### 🛠️ Linter & Formatter
- **ESLint** (Menggunakan Flat Config `eslint.config.mjs`):
  - Mengadopsi *ruleset* standar bawaan ESLint (`js/recommended`).
  - Mengadopsi standar TypeScript (`typescript-eslint/recommended`).
  - Mengadopsi standar React (`eslint-plugin-react/recommended`).
- **Prettier**: Digunakan untuk memastikan konsistensi format penulisan (spasi, tanda kutip tunggal/ganda, titik koma) di seluruh file `**/*.{ts,tsx,md}`. (Berdasarkan skrip `"format": "prettier --write ..."` di `package.json`).

### 📐 Aturan TypeScript (TSConfig)
Berdasarkan `tsconfig.base.json`, beberapa aturan TypeScript yang diterapkan meliputi:
- **`strict: false`**: Mode strict (ketat) pada TypeScript **dinonaktifkan**. Ini berarti *developer* diperbolehkan menggunakan pengetikan yang lebih longgar (misalnya variabel bertipe `any` diperbolehkan, dan pengecekan null yang ketat diabaikan).
- **`forceConsistentCasingInFileNames: true`**: Memastikan penamaan file menggunakan *casing* (huruf besar/kecil) yang konsisten (penting saat berkolaborasi antara pengguna Windows dan macOS/Linux).
- **Path Aliases**: Proyek menggunakan alias direktori absolut untuk menghindari *relative import* yang terlalu panjang (misal: `../../../../`), dengan alias yang terdaftar:
  - `@repo/ui/*` -> Modul UI bersama.
  - `@repo/utils/*` -> Utilitas fungsi.
  - `@repo/libs/*` -> Pustaka internal.

---

## 2. Backend (Golang)

Untuk layanan backend (microservices), selain mengikuti konvensi penulisan standar bahasa Go, proyek ini memberlakukan aturan penempatan struktur tingkat lanjut berdasarkan **Clean Architecture**.

### 🏗️ Konvensi Arsitektur (Struktur Direktori)
Setiap layanan wajib mematuhi pemisahan kode berdasarkan lapisan tanggung jawab (*layer of responsibilities*):
- **`domain/`**: Khusus untuk mendefinisikan model/entitas utama dan *interface* repositori. Dilarang meletakkan dependensi ke *framework* luar di sini.
- **`infrastructure/`**: Semua kode yang berinteraksi dengan database (Gorm), Redis, atau HTTP eksternal harus diisolasi di folder ini.
- **`usecase/`**: Berisi murni logika bisnis (*business rules*) yang mengimplementasikan *interface* dari domain.
- **`presentation/`**: Satu-satunya layer yang berinteraksi langsung dengan *request* masuk (seperti *handlers* Fiber REST API atau gRPC *handlers*).

### 🎨 Gaya Penamaan (Naming Conventions)
Sebagai standar Golang (*Idiomatic Go*), aturan penamaan yang biasanya diterapkan:
- **File**: Menggunakan *snake_case* (contoh: `user_repository.go`).
- **Struct, Interface, dan Fungsi Publik (Exported)**: Menggunakan *PascalCase* (diawali huruf besar) agar dapat diakses dari *package* lain. (contoh: `type UserRepository interface {}` atau `func NewUserRepository()`).
- **Variabel Lokal dan Fungsi Privat (Unexported)**: Menggunakan *camelCase* (diawali huruf kecil) untuk membatasi aksesibilitas di dalam *package* yang sama (contoh: `func calculateTax()`).
- **Konstanta**: Menggunakan *PascalCase* atau *camelCase*, bukan *UPPER_SNAKE_CASE* kecuali untuk nilai *enum* khusus.

### ⚙️ Formatter Standar Go
Meskipun tidak ditemukan konfigurasi `.golangci.yml` kustom yang spesifik di setiap root layanan, pengembangan berbasis Go wajib dan dianjurkan menggunakan utilitas bawaan:
- `go fmt` (atau `gofmt` / `goimports`): Untuk merapikan indentasi dan spasi secara otomatis.
- `go vet`: Penganalisa statis bawaan untuk menemukan <i>bug</i> ringan dalam struktur kode Go.
- `go mod tidy`: Digunakan untuk membersihkan dan merapikan *dependency* tidak terpakai di berkas `go.mod` dan `go.sum`.

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
                'order' => 3
            ]
        );
    }
}
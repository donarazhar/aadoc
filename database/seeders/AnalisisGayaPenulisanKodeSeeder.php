<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisGayaPenulisanKodeSeeder extends Seeder
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
<p>Dokumen ini merangkum konvensi atau standar aturan penulisan kode (*Coding Standards*) yang diterapkan oleh tim pengembang dalam proyek ALAZHARAPPS.</p>

<h3>1. Standar Penulisan Golang (Backend)</h3>
<p>Dalam ekosistem *backend*, pengembang mengikuti aturan dan konvensi *idiomatic* dari bahasa Go yang sangat ketat.</p>
<ul>
    <li><strong>Gaya Penamaan Variabel (Naming Convention):</strong> Seluruh penamaan menggunakan standar <code>camelCase</code> (contoh: <code>userId</code>, <code>fetchData()</code>). Penamaan konstanta menggunakan <code>UPPER_SNAKE_CASE</code> (contoh: <code>MAX_RETRY_COUNT</code>).</li>
    <li><strong>Penamaan *Struct* &amp; *Interface*:</strong> Menggunakan <code>PascalCase</code>, dengan aturan bahwa jika huruf pertamanya kapital (contoh: <code>type UserRepository interface</code>), maka entitas tersebut akan diekspor (*public*). Jika huruf kecil, ia disembunyikan dalam *package* lokal (*private*).</li>
    <li><strong>Penamaan File:</strong> Secara universal menggunakan <code>snake_case.go</code> (contoh: <code>user_repository.go</code>, <code>auth_handler.go</code>). Tidak boleh ada spasi atau tanda hubung.</li>
    <li><strong>Manajemen Kesalahan (Error Handling):</strong> Menggunakan praktik standar Go yaitu mengembalikan *error* sebagai nilai balik kedua (<code>val, err := function()</code>). Terlihat juga penggunaan *custom error struct* untuk menstandarisasi respons API jika terjadi kegagalan (misalnya me-return *JSON Message: Internal Server Error*).</li>
    <li><strong>Komentar (Docstrings):</strong> Setiap fungsi *public* atau entitas yang diekspor idealnya didahului dengan komentar penjelasan teknis yang sesuai dengan standar GoDoc, meskipun implementasinya belum merata di seluruh kode.</li>
</ul>

<h3>2. Standar Penulisan TypeScript &amp; React (Frontend)</h3>
<p>Sisi klien (frontend) memiliki sistem penegakan standar kode yang lebih otomatis dibandingkan backend, mengingat tim menggunakan Node.js.</p>
<ul>
    <li><strong>Otomatisasi Linter (ESLint):</strong> Proyek menggunakan <code>eslint.config.mjs</code> untuk menertibkan aturan penulisan di seluruh monorepo. ESLint dikonfigurasi untuk mencegah pemanggilan variabel yang tidak terpakai (no-unused-vars) dan memberikan peringatan keras terhadap penulisan tipe <code>any</code> di dalam Typescript (karena berisiko merusak type-safety).</li>
    <li><strong>Pembentukan Komponen (React Components):</strong> Menggunakan pendekatan <em>Functional Components</em> modern dengan <em>React Hooks</em>. Penamaan file komponen antarmuka harus selalu menggunakan huruf kapital <code>PascalCase.tsx</code> (contoh: <code>Sidebar.tsx</code>, <code>ExamCard.tsx</code>), sedangkan penamaan fungsi internal atau utilitas (helpers) menggunakan <code>camelCase.ts</code>.</li>
    <li><strong>Pemisahan Modul (Modularity):</strong> Komponen dipecah berdasarkan ukuran hierarkinya menjadi kecil-kecil, tidak boleh ada satu file yang membengkak melebihi seribu baris. Ini menjaga efisiensi proses perenderan React saat DOM dimanipulasi.</li>
    <li><strong>Arahan Kompilator:</strong> Sering ditemukannya arahan eksplisit <code>"use client"</code> di awal deklarasi file halaman NextJS (*App Router*) yang menandakan pengembang dengan teliti memastikan bagian mana yang di-render di *client* dan bagian mana yang *server-side*.</li>
</ul>

<h3>3. Standar Pengelolaan Repositori Git</h3>
<p>Kedua proyek (baik backend maupun frontend) menunjukkan kedewasaan alur kerja *version control*.</p>
<ul>
    <li><strong>Pola *Git Branching*:</strong> Menerapkan konsep umum seperti <em>GitFlow</em> atau <em>Trunk-based development</em>, yang terbukti dengan adanya beberapa cabang referensi pada *pull history* (seperti branch <code>master</code>, <code>develop</code>, <code>hotfix</code>, dan bahkan cabang nama personal dari pembuat kodenya, contoh <code>rahmat</code>).</li>
    <li><strong>Commit Message:</strong> Tim infrastruktur cenderung memisahkan pembaruan spesifik di luar *master* sebelum siap diuji dan digabung (*merge*).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('3. Panduan Gaya Penulisan Kode (Coding Standards)')],
            [
                'title' => '3. Panduan Gaya Penulisan Kode (Coding Standards)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

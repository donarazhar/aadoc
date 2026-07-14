<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisFrontendNextJSSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id ?? 1;

        $category = Category::firstOrCreate(
            ['slug' => 'analisis-arsitektur-sistem'],
            [
                'name' => 'Analisis Arsitektur Sistem',
                'description' => 'Dokumentasi komprehensif terkait arsitektur ALAZHARAPPS',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        $content3 = <<<HTML
<p>Analisis ini berfokus pada implementasi arsitektur antarmuka pengguna (Frontend) ALAZHARAPPS yang dibangun menggunakan ekosistem NextJS dan Turborepo.</p>

<h3>1. Versi Router &amp; Struktur Proyek</h3>
<p>Aplikasi ini telah bermigrasi dan menggunakan <strong>NextJS App Router</strong> (direktori <code>/app</code>). Namun, ada beberapa pola campuran (hybrid) yang ditemukan:</p>
<ul>
    <li><strong>App Router (<code>/app</code>):</strong> Merupakan pusat utama dari seluruh antarmuka pengguna (UI), <em>routing</em> halaman, dan komponen aplikasi (seperti <code>/app/admin/...</code> dan <code>/app/auth/...</code>).</li>
    <li><strong>Pages Router (<code>/pages</code>):</strong> Direktori ini masih ada tetapi <strong>tidak digunakan untuk UI</strong>. Direktori ini hanya menyimpan beberapa <em>API Routes</em> lama di <code>/pages/api/</code> (misalnya <code>raport-preview.ts</code>, <code>verify-recaptcha.ts</code>).</li>
</ul>

<p><strong>Pembagian Server vs Client Components</strong><br>
Meskipun menggunakan App Router yang secara default berorientasi pada <em>Server Components</em>, aplikasi ini <strong>sangat bergantung pada Client Components</strong>.</p>
<p>Lebih dari 400 file secara eksplisit menggunakan direktif <code>"use client"</code>, termasuk pada tingkat hierarki teratas halaman (contoh: <code>app/admin/dashboard/page.tsx</code>). Hal ini membuat aplikasi berperilaku lebih mirip dengan <em>Single Page Application</em> (SPA) React tradisional dibandingkan aplikasi SSR modern.</p>

<h3>2. Strategi Perenderan (Rendering Strategy)</h3>
<p>Karena dominasi direktif <code>"use client"</code> di level halaman (page-level), strategi perenderan utama yang digunakan adalah <strong>Client-Side Rendering (CSR)</strong> murni.</p>

<p><strong>Konsekuensi dari Pola Ini:</strong></p>
<ol>
    <li><strong>Tidak Ada SSR/SSG untuk Data:</strong> Halaman tidak mengambil data (fetching) di sisi server sebelum dikirim ke peramban (browser). Sebaliknya, server hanya mengirimkan kerangka HTML kosong (atau komponen loading), lalu React melakukan proses hidrasi (hydration) dan memulai pengambilan data di sisi klien.</li>
    <li><strong>Pertimbangan Pemilihan Strategi:</strong> Pendekatan ini umum dipilih ketika memigrasikan aplikasi React lama (seperti Create React App) ke NextJS tanpa mau merombak ulang logika <em>data fetching</em>. Selain itu, karena aplikasi ini bersifat "Admin Dashboard" yang berada di balik <em>login wall</em> (membutuhkan autentikasi), faktor SEO (Search Engine Optimization) tidak relevan, sehingga CSR dianggap cukup memadai.</li>
</ol>
<p><strong>[!WARNING] Risiko Performa:</strong> Menggunakan CSR secara ekstensif pada dashboard yang berat dapat menyebabkan <em>Time to Interactive (TTI)</em> lambat pada perangkat berspesifikasi rendah, karena peramban pengguna harus mengunduh bundel JavaScript yang besar dan melakukan <em>fetching</em> API secara berantai (waterfall) di sisi klien.</p>

<h3>3. State Management &amp; Caching Frontend</h3>
<p>Proyek ini tidak menggunakan pustaka fetching modern seperti SWR atau React Query (TanStack Query). Pengelolaan status (state) dan caching sepenuhnya bergantung pada dua teknologi utama:</p>

<h4>1. Redux Toolkit (RTK)</h4>
<ul>
    <li><strong>Penggunaan:</strong> Sebagai pusat manajemen state global. Aplikasi ini memiliki tidak kurang dari <strong>37 Redux Slices</strong> di <code>/store/slices/</code>.</li>
    <li><strong>Data Fetching:</strong> Menggunakan <code>createAsyncThunk</code> untuk melakukan pemanggilan API asinkron via Axios, lalu menyimpan hasilnya, status <em>loading</em>, dan status <em>error</em> secara manual ke dalam store Redux.</li>
    <li><strong>Kekurangan:</strong> Tanpa pustaka seperti React Query, tim developer harus menulis kode (boilerplate) yang berulang untuk menangani loading state dan harus mengelola invalidasi cache secara manual jika data di server berubah.</li>
</ul>

<h4>2. Manajemen Sesi dengan Cookies (<code>js-cookie</code>)</h4>
<ul>
    <li>Sistem sangat mengandalkan cookies sisi peramban untuk menyimpan data sesi yang melintasi navigasi halaman (persisten).</li>
    <li>Data yang disimpan meliputi <code>authToken</code>, pengaturan <code>tahun_ajaran_aktif</code>, dan akses role pengguna.</li>
    <li><strong>Keamanan:</strong> Ditemukan praktik baik di mana data krusial (seperti payload role atau academic year) dienkripsi terlebih dahulu menggunakan utilitas lokal (<code>EncryptionUtil.encrypt/decrypt</code>) sebelum disimpan ke cookie.</li>
</ul>

<h3>4. Optimasi Aset Visual (CLS Prevention)</h3>
<p><strong>Status:</strong> &#9989; <strong>Sudah Dioptimalkan</strong></p>
<p>Berdasarkan penelusuran kode, proyek ini secara konsisten menggunakan komponen bawaan <strong><code>next/image</code></strong> untuk perenderan gambar.</p>
<ul>
    <li><strong>Distribusi:</strong> Komponen <code>next/image</code> ditemukan digunakan di seluruh elemen antarmuka utama seperti Sidebar, ExamCard, TableReport, dan berbagai komponen Dashboard.</li>
    <li><strong>Manfaat:</strong> Penggunaan ini secara otomatis mengoptimalkan format gambar (WebP/AVIF), memperkecil ukuran file (resizing) sesuai ukuran layar pengguna, dan secara eksplisit memesan ruang dimensi di tata letak halaman untuk mencegah terjadinya masalah <strong>Cumulative Layout Shift (CLS)</strong> (loncatan tampilan halaman saat gambar tiba-tiba selesai dimuat).</li>
    <li><strong>Konfigurasi:</strong> Konfigurasi <code>next.config.js</code> juga telah diatur untuk mengizinkan (whitelist) <em>remote patterns</em> dari server aset eksternal (<code>assets.alazhar.or.id</code>).</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => 'pendalaman-frontend-nextjs'],
            [
                'category_id' => $category->id,
                'title' => 'Pendalaman Frontend: NextJS',
                'content' => $content3,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 3,
            ]
        );
    }
}

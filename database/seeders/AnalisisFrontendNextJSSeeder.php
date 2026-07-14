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
<p>Frontend ALAZHARAPPS dibangun menggunakan framework NextJS dalam ekosistem Turborepo. Berikut adalah evaluasi performa dan metodenya.</p>

<h3>Versi Router & Struktur</h3>
<p>Aplikasi ini berpusat pada <strong>NextJS App Router</strong> (direktori <code>/app</code>). Direktori lama <code>/pages</code> hanya disisakan untuk mengakomodasi beberapa API route terpisah. Namun, sebagian besar halaman utama dieksekusi menggunakan arahan <code>"use client"</code> di level puncak komponen.</p>

<h3>Strategi Perenderan (Rendering Strategy)</h3>
<p>Karena dominasi penggunaan komponen klien (Client Components), strategi perenderan yang dianut adalah murni <strong>Client-Side Rendering (CSR)</strong>. Server NextJS menyajikan kerangka dasar, dan data di-<em>fetch</em> setelah UI termuat di peramban pengguna. Strategi ini sangat cocok untuk dasbor admin tertutup, meski berisiko terhadap lambatnya <em>Time to Interactive</em> jika ukuran JavaScript terlalu besar.</p>

<h3>State Management & Caching Frontend</h3>
<p>Alih-alih menggunakan pustaka caching canggih seperti React Query, sistem manajemen keadaan memusatkan lalu lintas datanya menggunakan <strong>Redux Toolkit</strong>. Eksekusi API diimplementasikan dalam bentuk <em>thunk</em> (<code>createAsyncThunk</code>). Sistem sesi dan variabel penting aplikasi sangat bergantung pada manajemen <strong>Cookies</strong> lokal.</p>

<h3>Optimasi Aset Visual</h3>
<p>Manajemen visual telah sesuai dengan standar produksi dengan digunakannya komponen <strong><code>next/image</code></strong>. Praktik ini secara signifikan mengompresi ukuran gambar dan memberikan reservasi tata letak ruang (placeholder dimensi) untuk mencegah pergeseran fatal konten layar (<em>Cumulative Layout Shift/CLS</em>).</p>
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

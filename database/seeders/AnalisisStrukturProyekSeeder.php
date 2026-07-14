<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisStrukturProyekSeeder extends Seeder
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
<p>Dokumen ini membedah arsitektur makro dan pembagian (struktur) direktori dari sistem ALAZHARAPPS, yang secara keseluruhan mengadopsi pola <strong>Microservices</strong> dengan repositori terpisah (Polyrepo).</p>

<h3>1. Pembagian Repositori (Microservices)</h3>
<p>Sistem ALAZHARAPPS dipecah menjadi 12 modul/repositori independen untuk memastikan skalabilitas dan isolasi kegagalan:</p>
<ul>
    <li><code>account-service</code>: Mengurus manajemen pengguna (user), autentikasi (login), dan hierarki *Role-Based Access Control* (RBAC).</li>
    <li><code>student-service</code>: Menangani data induk siswa, mutasi, dan pendaftaran.</li>
    <li><code>school-service-new</code>: Mengelola entitas sekolah, tahun ajaran, dan pengaturan kurikulum tingkat yayasan.</li>
    <li><code>transaction-service</code>: Mengurus tagihan (billing), pembayaran (payment gateway), dan riwayat transaksi.</li>
    <li><code>report-service</code>: Melayani pembuatan dan pencetakan rapor, rekap kehadiran, dan ekspor data agregat (PDF/Excel).</li>
    <li><code>lms-course-service</code>: Menangani kelas online, materi pembelajaran, dan pengumpulan tugas (di sisi LMS).</li>
    <li><code>frontend</code>: Memuat aplikasi berbasis antarmuka web interaktif (NextJS) untuk Admin Dashboard.</li>
    <li><code>landing-page</code>: Memuat situs web publik untuk profil yayasan dan pendaftaran awal.</li>
    <li><code>backend-codebase</code> (opsional): Mungkin digunakan sebagai referensi pola lama atau repositori monolit/legacy.</li>
    <li><code>etl</code>: Menjalankan proses *Extract, Transform, Load* untuk migrasi data historis atau sinkronisasi dengan sistem pemerintah (Dapodik).</li>
    <li><code>jwtaccess</code> &amp; <code>go-lib</code>: Pustaka internal (library) milik tim untuk standardisasi JWT dan *common utilities* yang diimpor oleh microservice lainnya.</li>
</ul>

<h3>2. Struktur Internal Backend (Clean Architecture)</h3>
<p>Setiap repositori backend Golang menerapkan <strong>Clean Architecture</strong> karya Uncle Bob, yang terbagi dalam 4 lapisan (layer) direktori utama:</p>
<ol>
    <li><strong><code>domain/</code> (Entities)</strong>: Berisi definisi struktur data murni (struct) dan antarmuka (interface) dari repository. Tidak boleh ada dependensi ke *framework* luar di sini.</li>
    <li><strong><code>usecase/</code> (Logika Bisnis)</strong>: Berisi otak dari aplikasi. Di sinilah aturan bisnis (seperti pengecekan apakah siswa sudah membayar sebelum ujian) divalidasi. Lapisan ini berkomunikasi dengan domain.</li>
    <li><strong><code>presentation/</code> (Delivery/Controller)</strong>: Berisi *handler* HTTP, REST, atau gRPC yang bertugas menerima *request* pengguna, mengubah JSON menjadi format Go, lalu memanggil fungsi di *usecase*.</li>
    <li><strong><code>infrastructure/</code> (Teknis)</strong>: Berisi konfigurasi teknis yang menghubungkan aplikasi ke dunia luar. Di sinilah koneksi PostgreSQL, Redis, Fiber Server, dan SMTP Mailer diletakkan.</li>
</ol>
<p><strong>Keuntungan Pendekatan Ini:</strong> Memisahkan logika bisnis dari teknologi *database* atau *framework* (seperti Fiber), sehingga jika di masa depan tim ingin mengganti *database* dari Postgres ke MySQL, hanya direktori <code>infrastructure/</code> yang perlu diubah.</p>

<h3>3. Struktur Internal Frontend (Monorepo Turborepo)</h3>
<p>Repositori <code>frontend/</code> merupakan sebuah monorepo berbalut <strong>Turborepo</strong>. Di dalamnya terdapat:</p>
<ul>
    <li><code>apps/</code>: Berisi proyek aplikasi utama (seperti <code>apps/apps/</code> untuk dashboard admin berbasis NextJS).</li>
    <li><code>packages/</code>: Berisi pustaka antarmuka bersama, konfigurasi ESLint, TypeScript config, dan utilitas (*helpers*) yang bisa digunakan ulang oleh berbagai aplikasi di dalam monorepo tersebut.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('1. Struktur Proyek & Arsitektur Microservices')],
            [
                'title' => '1. Struktur Proyek & Arsitektur Microservices',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

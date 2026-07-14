<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisArsitekturGlobalSeeder extends Seeder
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

        $content1 = <<<HTML
<p>ALAZHARAPPS adalah sistem informasi sekolah Al Azhar yang dibangun dengan arsitektur <strong>microservices</strong>. Sistem terdiri dari 8 backend services (Golang), 1 frontend monorepo (Next.js/Turborepo), 1 landing page (React/Vite), 1 shared Go library, 1 shared JWT library, dan 1 ETL pipeline (Python).</p>

<h3>1. Protokol Komunikasi API</h3>
<p><strong>Frontend → Backend:</strong> 100% menggunakan REST API (HTTP/JSON) via Axios. Frontend berkomunikasi melalui API Gateway (dev-api.alazhar.or.id/v1) dan tidak ada GraphQL atau gRPC yang digunakan pada sisi klien.</p>
<p><strong>Backend ↔ Backend:</strong> Komunikasi antar microservices sepenuhnya menggunakan gRPC (Protobuf). Setiap service menjalankan dual-protocol server (REST + gRPC).</p>

<h3>2. Dokumentasi API (Kontrak Data)</h3>
<p>Tidak ditemukan dokumentasi API yang terpusat seperti Swagger, OpenAPI, atau Postman Collection. Kontrak data didasarkan pada file proto untuk internal gRPC, dan antarmuka TypeScript di sisi frontend. Perubahan struktur respons harus dikomunikasikan secara manual.</p>

<h3>3. Pemisahan Logika Bisnis</h3>
<p>Logika bisnis utama (seperti perhitungan tagihan, settlement, dan otorisasi) dikelola 100% di sisi backend Golang dengan Clean Architecture. Frontend Next.js berfungsi murni sebagai <em>thin client</em> untuk presentasi data dan <em>state management</em> UI.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'analisis-arsitektur-global'],
            [
                'category_id' => $category->id,
                'title' => 'Analisis Arsitektur Global & Integrasi Sistem',
                'content' => $content1,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 1,
            ]
        );
    }
}

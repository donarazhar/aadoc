<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisDevopsSeeder extends Seeder
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

        $content5 = <<<HTML
<p>Standar DevOps yang digunakan ALAZHARAPPS tergolong tinggi dengan integrasi alur berkelanjutan yang baik. Hal ini didukung oleh kematangan pengelolaan <em>container</em>.</p>

<h3>Containerization & Docker Multi-stage Build</h3>
<p>Seluruh repositori Golang dan NextJS dibungkus ke dalam arsitektur <em>Multi-stage build</em>. Dockerfile Golang menggunakan <em>base image</em> <code>scratch</code> (kosong dari OS) pada tahap akhir yang menghasilkan fail super ringan (belasan MB) tanpa celah serangan eksploitasi (Zero-Attack Surface). Dockerfile NextJS menugaskan user non-root (<code>nextjs</code>) secara eksplisit untuk keamanan mesin.</p>

<h3>NextJS Standalone Mode</h3>
<p>Parameter <code>output: 'standalone'</code> dipastikan aktif dalam berkas konfigurasi Next.js. Proses perakitan ini berhasil melucuti ratusan MB dependensi usang dalam <code>node_modules</code>, memastikan mesin <em>container</em> bekerja sangat optimal, gesit saat dijalankan, dan meminimalkan pemakaian memori Node.js pada server produksi.</p>

<h3>Pipeline CI/CD (Infrastructure as Code)</h3>
<p>Garis waktu rilis peranti lunak diotomasikan secara mutlak lewat GitLab CI. File konfigurasi utama <code>.gitlab-ci.yml</code> sengaja dipendekkan dengan cara memanggil pustaka terpusat (<em>include</em>) dari repositori infrastruktur internal (<code>al-azhar-iac</code>). Ini menjamin keseragaman standar pengujian untuk puluhan servis mikronya, sekaligus mempercepat tindakan mitigasi <strong>rollback</strong> kontainer yang lebih stabil saat terjadi kendala fatal.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'devops-deployment-infrastruktur'],
            [
                'category_id' => $category->id,
                'title' => 'DevOps, Deployment, & Infrastruktur',
                'content' => $content5,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 5,
            ]
        );
    }
}

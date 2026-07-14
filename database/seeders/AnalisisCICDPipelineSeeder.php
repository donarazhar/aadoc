<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisCICDPipelineSeeder extends Seeder
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
<p>Dokumen ini menyajikan analisis teknis mengenai alur otomatisasi *Deployment* atau siklus rilis piranti lunak (CI/CD Pipeline) di ALAZHARAPPS yang menggunakan GitLab CI.</p>

<h3>1. Pendekatan IaC (Infrastructure as Code)</h3>
<p>Alih-alih menulis ulang puluhan baris konfigurasi pipa (pipeline) di masing-masing direktori *microservice*, tim merancang repositori terpusat khusus untuk infrastruktur bernama <code>al-azhar-iac</code>. </p>
<ul>
    <li>Semua file <code>.gitlab-ci.yml</code> di repositori layanan hanya berisi fungsi pemanggilan tunggal (<em>include</em>) yang menunjuk pada rujukan (<em>template</em>) di dalam repo IaC tersebut.</li>
    <li><strong>Keuntungan Tingkat Tinggi:</strong> Jika di masa depan tim DevOps ingin mengubah server tujuan (misalnya beralih dari AWS ke GCP) atau mengubah standar pengujian (SonarQube), mereka hanya perlu mengedit satu file *template* di repo IaC, dan otomatis 12 repositori aplikasi yang bergantung padanya akan menggunakan alur rilis yang baru tanpa sentuhan manual (*Zero-touch configuration update*).</li>
</ul>

<h3>2. Fase Pipeline (Pipeline Stages)</h3>
<p>Berdasarkan praktik terbaik yang terlihat pada konfigurasi *Docker multi-stage*, CI/CD kemungkinan besar beroperasi melalui tahapan berikut ketika pengembang melakukan <code>git push</code> ke cabang utama (<em>main/master</em>):</p>
<ol>
    <li><strong>Tahap LINT &amp; TEST:</strong> GitLab Runner mengeksekusi linter kode (seperti <code>golangci-lint</code> atau <code>eslint</code>) dan menjalankan <em>Unit Test</em>. Jika ada galat atau kode tidak memenuhi standar, proses rilis digagalkan saat itu juga (*Fail-fast*).</li>
    <li><strong>Tahap BUILD:</strong> GitLab merakit kode menjadi *Image Docker* murni. Seperti yang diketahui, ukuran *image backend* ditekan hingga belasan Megabyte (berkat OS Scratch) dan ukuran frontend dikompresi lewat modus *Standalone* NextJS.</li>
    <li><strong>Tahap PUSH REGISTRY:</strong> Hasil *image* diunggah (di-*push*) ke layanan *Private Docker Registry* milik YPIA (<code>registry.ypia-cloud.id</code>). GitLab akan memberi tag unik (berbasis *commit hash* atau *semantic versioning* seperti <code>v1.2.3</code>).</li>
    <li><strong>Tahap DEPLOY:</strong> Skrip GitLab mengakses *Server Production* (biasanya via agen SSH atau konfigurasi Kubernetes/Kustomize) untuk menarik (*pull*) image terbaru tadi, mematikan kontainer lama, dan menghidupkan versi baru tanpa *downtime* signifikan.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('9. Analisis Otomatisasi Deployment (CI/CD Pipeline)')],
            [
                'title' => '9. Analisis Otomatisasi Deployment (CI/CD Pipeline)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

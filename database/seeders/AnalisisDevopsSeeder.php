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
<p>Analisis ini membahas bagaimana aplikasi ALAZHARAPPS dikemas (containerization), dioptimasi untuk lingkungan produksi, dan diotomatisasi rilisnya melalui sistem CI/CD (Continuous Integration / Continuous Deployment).</p>

<h3>1. Containerization (Docker)</h3>
<p>Kedua sisi aplikasi (Golang Backend dan NextJS Frontend) telah memanfaatkan fitur <strong>Multi-Stage Build</strong> pada Docker. Pendekatan ini sangat krusial karena memisahkan lingkungan "pembangunan kode" (build environment) dari lingkungan "penjalanan aplikasi" (runtime environment), menghasilkan image yang sangat ringan, cepat didistribusikan, dan jauh lebih aman.</p>

<h4>A. Dockerfile Golang (Backend)</h4>
<pre><code># Stage 1: Pembangunan (Builder)
ARG BASE_IMAGE_GO=registry.ypia-cloud.id/golang/golang:1.
FROM \${BASE_IMAGE_GO} AS builder
...
RUN CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build -o acc 

# Stage 2: Hasil Akhir (Scratch)
FROM scratch
COPY --from=builder /app/account-service .
...
CMD ["./account-service"]</code></pre>
<ul>
    <li><strong>Analisis:</strong> Dockerfile Golang menggunakan pola <em>scratch</em> murni. Image akhir tidak memiliki sistem operasi (<code>FROM scratch</code>), tidak ada shell bash, dan tidak ada dependensi eksternal. Ia murni hanya berisi satu file biner (<code>account-service</code>). Ini membuat ukuran image <strong>sangat kecil</strong> (hanya belasan MB) dan meniadakan celah keamanan dari eksploitasi sistem operasi (Zero-Attack Surface).</li>
</ul>

<h4>B. Dockerfile NextJS (Frontend)</h4>
<pre><code># Stage 1: Builder
FROM node:22.17-alpine AS builder
...
RUN npm run build-apps

# Stage 2: Runner
FROM node:22.17-alpine AS runner
RUN addgroup --system --gid 1001 nodejs
RUN adduser --system --uid 1001 nextjs
...
COPY --from=builder --chown=nextjs:nodejs /app/apps/apps/ 
...
USER nextjs
CMD ["node", "apps/apps/server.js"]</code></pre>
<ul>
    <li><strong>Analisis:</strong> Sangat matang. Sistem tidak menjalankan aplikasi Node.js menggunakan akses <code>root</code> (praktik standar yang sering terabaikan). Ia membuat akun spesifik (<code>nextjs</code>) sehingga kalaupun terjadi kompromi pada aplikasi, peretas tidak memiliki hak admin pada wadah (container).</li>
</ul>

<h3>2. NextJS Standalone Mode</h3>
<p><strong>Status:</strong> &#9989; <strong>Diaktifkan</strong></p>
<p>Pada <code>next.config.js</code> dan Dockerfile NextJS, fitur ini terbukti diaktifkan:</p>
<pre><code>// next.config.js
output: "standalone",</code></pre>
<ul>
    <li><strong>Keuntungan:</strong> Secara default, <code>node_modules</code> NextJS berisi ratusan megabyte dependensi (termasuk modul pengembangan). Dengan mode <code>standalone</code>, NextJS akan membuat bundel mini yang <strong>hanya berisi file dan modul yang benar-benar dibutuhkan</strong> untuk menjalankan aplikasi di server. Mode ini mengurangi ukuran image Docker lebih dari 80%, mempercepat proses deployment, dan menurunkan konsumsi memori server.</li>
</ul>

<h3>3. Pipeline CI/CD &amp; Strategi Rollback</h3>
<p>Proses rilis tidak dilakukan secara manual melainkan diotomatisasi penuh menggunakan <strong>GitLab CI</strong>.</p>

<h4>Konfigurasi Tersentralisasi (IaC)</h4>
<p>Pada setiap repositori (contohnya <code>account-service/.gitlab-ci.yml</code>), konfigurasi pipeline utamanya tidak ditulis berulang, melainkan mengambil referensi eksternal:</p>
<pre><code>include:
 - project: 'al-azhar-iac/cicd-template'
   ref: main
   file:
     - 'v1/app/go-backend-v1-account.yml'</code></pre>
<ul>
    <li><strong>Analisis:</strong> Tim infrastruktur memisahkan <em>template</em> rilis ke dalam repositori tersendiri (<code>al-azhar-iac/cicd-template</code>). Pendekatan ini (Infrastructure as Code) sangat ideal untuk arsitektur <em>microservices</em> karena memastikan standar build, testing, dan deployment seragam di belasan layanan yang ada.</li>
</ul>

<h4>Strategi Rollback</h4>
<p>Walaupun detail instruksi rollback spesifik disembunyikan di dalam repositori <code>cicd-template</code> internal, berdasarkan pola Docker dan Registry (<code>registry.ypia-cloud.id</code>), mekanisme umum jika terjadi kegagalan (fatal crash) di production adalah:</p>
<ol>
    <li>Karena setiap rilis (push Git) menghasilkan Image Docker dengan tag versi unik (misalnya <code>account-service:v1.2.3</code>),</li>
    <li>Jika <code>v1.2.3</code> gagal, rollback dilakukan dengan sangat cepat dengan cara <strong>memutar mundur status deployment ke tag image sebelumnya</strong> (misalnya <code>v1.2.2</code>). Wadah (container) rusak dimatikan dan digantikan wadah lama dalam hitungan detik. Pendekatan <em>immutable container</em> ini jauh lebih aman dibandingkan membatalkan (revert) komit kodingan dan melakukan rilis ulang (rebuild).</li>
</ol>
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

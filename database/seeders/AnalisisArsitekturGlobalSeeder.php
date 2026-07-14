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
<p><strong>Ringkasan Eksekutif</strong><br>
ALAZHARAPPS adalah sistem informasi sekolah <strong>Al Azhar</strong> yang dibangun dengan arsitektur <strong>microservices</strong>. Sistem terdiri dari <strong>8 backend services (Golang)</strong>, <strong>1 frontend monorepo (Next.js/Turborepo)</strong>, <strong>1 landing page (React/Vite)</strong>, <strong>1 shared Go library</strong>, <strong>1 shared JWT library</strong>, dan <strong>1 ETL pipeline (Python)</strong>.</p>

<hr>

<h3>1. Peta Komponen Sistem</h3>
<pre><code>graph TD
 subgraph "Frontend Layer"
 FE["frontend (Next.js 15 + Turborepo)"]
 LP["landing-page (React + Vite)"]
 end
 subgraph "API Gateway / Reverse Proxy"
 GW["dev-api.alazhar.or.id/v1"]
 end
 subgraph "Backend Microservices (Golang)"
 ACC["account-service"]
 STU["student-service"]
 SCH["school-service-new"]
 TXN["transaction-service"]
 RPT["report-service"]
 LMS["lms-course-service"]
 BE["backend-codebase (base template)"]
 end
 subgraph "Shared Libraries (Golang)"
 GOLIB["go-lib (REST, Logger)"]
 JWT["jwtaccess (JWT Auth)"]
 end
 subgraph "Data & Integration"
 ETL["etl (Python ETL Framework)"]
 PG["PostgreSQL"]
 RD["Redis"]
 FB["Firebase (Push Notifications)"]
 WA["WhatsApp (Fonnte/Qontak)"]
 end

 FE --&gt;|"REST API (axios)"| GW
 LP -.->|"Static site"| GW
 GW --&gt;|"/account/*"| ACC
 GW --&gt;|"/student/*"| STU
 GW --&gt;|"/school-new/*"| SCH
 GW --&gt;|"/report/*"| RPT
 GW --&gt;|"/transaction/*"| TXN

 ACC --&gt;|"gRPC Client"| SCH
 TXN --&gt;|"gRPC Client"| ACC
 TXN --&gt;|"gRPC Client"| STU
 SCH --&gt;|"gRPC Client"| ACC
 SCH --&gt;|"gRPC Client"| STU
 SCH --&gt;|"gRPC Client"| TXN

 ACC --&gt; GOLIB
 STU --&gt; GOLIB
 SCH --&gt; GOLIB
 TXN --&gt; GOLIB
 RPT --&gt; GOLIB

 ACC --&gt; JWT
 SCH --&gt; JWT
 TXN --&gt; JWT

 ACC --&gt; PG
 ACC --&gt; RD
 ACC --&gt; FB
 ACC --&gt; WA
 TXN --&gt; PG
 TXN --&gt; RD
 STU --&gt; PG
 SCH --&gt; PG
 RPT --&gt; PG

 ETL --&gt;|"SQL/Python"| PG</code></pre>

<hr>

<h3>2. Protokol Komunikasi API</h3>

<h4>2.1 Frontend &rarr; Backend: REST API (HTTP/JSON)</h4>
<p><strong>[!IMPORTANT]</strong> Frontend berkomunikasi ke backend <strong>100% melalui REST API</strong> menggunakan <strong>Axios</strong> sebagai HTTP client. <strong>Tidak ada GraphQL maupun gRPC</strong> yang digunakan dari sisi frontend.</p>

<p><strong>Mekanisme Detail</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Aspek</th><th>Detail</th></tr>
    <tr><td>HTTP Client</td><td>Axios via singleton instance (<code>axiosInstance.ts</code>)</td></tr>
    <tr><td>Base URL</td><td><code>NEXT_PUBLIC_API_URL = https://dev-api.alazhar.or.id/v1</code></td></tr>
    <tr><td>Auth</td><td>Bearer Token JWT (disimpan di Cookie <code>authToken</code>)</td></tr>
    <tr><td>Timeout</td><td>70 detik</td></tr>
    <tr><td>State Management</td><td>Redux Toolkit (<code>createAsyncThunk</code> untuk async API calls)</td></tr>
    <tr><td>Data Format</td><td>JSON</td></tr>
</table>

<p><strong>Alur Data Fetching</strong></p>
<pre><code>Next.js Component (page/hook)
 &darr; dispatch(action)
Redux Slice (createAsyncThunk)
 &darr; axiosInstance.get/post/put/delete(endpoint)
Axios Interceptor (inject Bearer token)
 &darr; HTTP Request
API Gateway (dev-api.alazhar.or.id/v1)
 &darr; Routing berdasarkan path prefix
Golang Microservice (GoFiber handler)
 &darr; Response JSON
Redux Slice (extraReducers &rarr; state update)
 &darr; re-render
Next.js Component</code></pre>

<p><strong>Pola Endpoint Frontend</strong></p>
<p>Frontend mendefinisikan endpoint dalam <strong>33 file service</strong> di <code>app/services/</code>:</p>
<ul>
    <li>Endpoint dispampaikan sebagai <strong>path string relatif</strong> (tanpa base URL)</li>
    <li>Path prefix menentukan ke microservice mana request diarahkan oleh API Gateway:</li>
</ul>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Path Prefix</th><th>Backend Service</th></tr>
    <tr><td><code>/account/*</code></td><td>account-service</td></tr>
    <tr><td><code>/student/*</code></td><td>student-service</td></tr>
    <tr><td><code>/school-new/*</code></td><td>school-service-new</td></tr>
    <tr><td><code>/school/*</code></td><td>school-service-new</td></tr>
    <tr><td><code>/report/*</code></td><td>report-service</td></tr>
    <tr><td><code>/transaction/*</code></td><td>transaction-service</td></tr>
</table>

<p><strong>Contoh pola yang digunakan:</strong></p>
<pre><code>// Dari apiAccount.ts
export const authEndpoints = {
 login: () =&gt; `/account/login`,
 me: () =&gt; `/account/me`,
};

// Dari apiDashboard.ts
export const dashboardtEndpoints = {
 finance_card: ({ schoolId, accademicYear }) =&gt;
 `/report/dashboard/finance?schoolId=\${schoolId}&amp;accademicYear=\${accademicYear}`,
};</code></pre>

<h4>2.2 Backend &harr; Backend: gRPC (Protobuf)</h4>
<p><strong>[!IMPORTANT]</strong> Komunikasi antar microservices <strong>sepenuhnya menggunakan gRPC</strong> dengan Protocol Buffers sebagai serialization format. Setiap service menjalankan <strong>dual-protocol server</strong> (REST + gRPC) secara bersamaan.</p>

<p><strong>Peta Komunikasi gRPC Antar Service</strong></p>
<pre><code>graph LR
 ACC["account-service&lt;br/&gt;gRPC Server :grpc_port"]
 STU["student-service&lt;br/&gt;gRPC Server :grpc_port"]
 SCH["school-service-new&lt;br/&gt;gRPC Server :grpc_port"]
 TXN["transaction-service&lt;br/&gt;gRPC Server :grpc_port"]

 TXN --&gt;|"pb.AccountClient"| ACC
 TXN --&gt;|"pb.StudentClient"| STU
 ACC --&gt;|"pb.SchoolNewClient"| SCH
 SCH --&gt;|"pb.AccountClient"| ACC
 SCH --&gt;|"pb.StudentClient"| STU
 SCH --&gt;|"pb.TransactionClient"| TXN</code></pre>

<p><strong>Proto File Definitions</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Service</th><th>Proto File</th><th>RPC Methods</th></tr>
    <tr><td><strong>Account</strong></td><td><code>account.proto</code></td><td>BlockLmsAccess, UnblockLmsAccess, CreateSchoolUser, CreateExamUser, InquiryExamUserLogin, InquiryLmsUsername, SendNotification, SendWaMessage, SubmitNotificationExamResult</td></tr>
    <tr><td><strong>Transaction</strong></td><td><code>transaction.proto</code></td><td>CreateRegistrationBill, CreateDspBill, CreateDspBills, CreateSppBill, CreateEnrollmentBill, CreateDiscountBill, ActivateDiscountBill, DeleteDiscountBill, HasOutstandingBill, HasInstallmentBill</td></tr>
    <tr><td><strong>Student</strong></td><td><code>student.proto</code></td><td>AnimoPaymentSuccess, CreateNewStudent, CreateWaitingListStudent, GenerateSpp, GetCountRombelBySchoolID, GetStudentCountByAcademicYear, GetTotalStudent, FindPersonnelAssignment</td></tr>
    <tr><td><strong>SchoolNew</strong></td><td><code>schoolnew.proto</code></td><td>CreateDsp, GetCapacityById, GetSchoolByUid, GetPersonnelDiscountByPersonnelType, GetEndowmentSppDsp, GetTargetBatch</td></tr>
</table>

<hr>

<h3>3. Dokumentasi API (Kontrak Data)</h3>
<p><strong>[!CAUTION] Tidak ada dokumentasi API yang terpusat dan mutakhir.</strong> Sistem TIDAK memiliki Swagger/OpenAPI Spec, Postman Collection, maupun API documentation generator yang terintegrasi.</p>

<p><strong>Apa yang Ada</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Jenis Dokumentasi</th><th>Status</th><th>Lokasi</th></tr>
    <tr><td>Swagger/OpenAPI</td><td>&#10060; Tidak ada</td><td>&mdash;</td></tr>
    <tr><td>Postman Collection</td><td>&#10060; Tidak ada</td><td>&mdash;</td></tr>
    <tr><td>Proto Files (gRPC)</td><td>&#9989; Ada</td><td>Setiap service memiliki folder <code>proto/</code></td></tr>
    <tr><td>API Endpoint JSON</td><td>&#9888; Parsial</td><td><code>student-service-api.json</code> &mdash; hanya route dump, tanpa request/response schema</td></tr>
    <tr><td>Markdown API Docs</td><td>&#9888; Sangat Minimal</td><td><code>ADMISSION.md</code> &mdash; hanya 1 file, hanya contoh request tanpa response</td></tr>
    <tr><td>README files</td><td>&#9888; Ada tapi generik</td><td>Setiap repo punya README tapi isinya template standar</td></tr>
</table>

<p><strong>Bagaimana Frontend Mengetahui Kontrak Data?</strong><br>
Berdasarkan analisis kode:</p>
<ol>
    <li><strong>Kontrak data implisit</strong> &mdash; Frontend mendefinisikan TypeScript interfaces di <code>app/interfaces/</code> (35 domain-specific directories), tapi ini di-maintain <strong>secara manual dan terpisah</strong> dari backend.</li>
    <li><strong>Standard response envelope</strong> &mdash; Backend menggunakan format respons standar yang konsisten:
<pre><code>{
 "version": 1,
 "message": "string",
 "success": true/false,
 "errors": true/false,
 "metadata": null | {...},
 "results": null | {...} | [...]
}</code></pre>
Didefinisikan di <code>response/json.go</code>.
    </li>
    <li><strong>Tidak ada mekanisme notifikasi perubahan</strong> &mdash; Jika backend mengubah response structure, frontend harus mengetahui melalui koordinasi manual antar developer (kemungkinan besar melalui GitLab/komunikasi tim).</li>
</ol>
<p><strong>[!WARNING]</strong> Risiko: Perubahan response backend yang tidak dikomunikasikan dapat menyebabkan <strong>silent bugs</strong> di frontend (data undefined, rendering error) karena tidak ada kontrak otomatis yang memvalidasi kedua sisi.</p>

<hr>

<h3>4. Pemisahan Logika Bisnis</h3>
<p><strong>[!IMPORTANT]</strong> Logika bisnis utama <strong>dikelola sepenuhnya di sisi backend Golang</strong>. Frontend Next.js berperan sebagai <strong>thin client</strong> yang fokus pada presentasi dan state management.</p>

<h4>4.1 Backend: Pusat Logika Bisnis</h4>
<p>Setiap microservice menerapkan arsitektur <strong>Clean Architecture / Hexagonal</strong> yang konsisten:</p>
<pre><code>cmd/            &rarr; Entry point (wiring dependencies)
config/         &rarr; Configuration management
domain/         &rarr; Domain entities, value objects, repository interfaces
 &boxvr;&boxh;&boxh; entity/
 &boxvr;&boxh;&boxh; aggregate/
 &boxvr;&boxh;&boxh; repository/ (interfaces)
 &boxur;&boxh;&boxh; valueobject/
usecase/        &rarr; Business logic (core rules)
presentation/   &rarr; Controllers, handlers, response formatting
 &boxvr;&boxh;&boxh; controller/ (REST handlers)
 &boxvr;&boxh;&boxh; handler/    (gRPC handlers)
 &boxvr;&boxh;&boxh; middleware/
 &boxur;&boxh;&boxh; response/
infrastructure/ &rarr; Technical implementations
 &boxvr;&boxh;&boxh; postgres/   (database)
 &boxvr;&boxh;&boxh; redis/      (caching)
 &boxvr;&boxh;&boxh; grpc/       (inter-service communication)
 &boxvr;&boxh;&boxh; rest/       (HTTP server - GoFiber)
 &boxvr;&boxh;&boxh; firebase/   (push notifications)
 &boxvr;&boxh;&boxh; email/      (SMTP)
 &boxur;&boxh;&boxh; whatsapp/   (Fonnte/Qontak)</code></pre>

<p><strong>Contoh Logika Bisnis Krusial di Backend</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Domain</th><th>Lokasi</th><th>Fungsi</th></tr>
    <tr><td><strong>Billing &amp; Tagihan</strong></td><td><code>billing_usecase.go</code> (462 baris)</td><td>Pembuatan tagihan DSP, SPP, biaya pendaftaran, kalkulasi diskon</td></tr>
    <tr><td><strong>Settlement / Pembayaran</strong></td><td><code>settlement_usecase.go</code> (37.661 byte!)</td><td>Penyelesaian pembayaran, integrasi payment gateway, mapping rekening settlement</td></tr>
    <tr><td><strong>Angsuran</strong></td><td><code>installment_plan_usecase.go</code></td><td>Rencana cicilan, validasi, perpanjangan</td></tr>
    <tr><td><strong>Autentikasi</strong></td><td><code>auth_usecase.go</code></td><td>Login web/mobile, token generation, forgot/reset password</td></tr>
    <tr><td><strong>OTP</strong></td><td><code>otp_usecase.go</code></td><td>Request &amp; verify OTP via email/WhatsApp</td></tr>
    <tr><td><strong>Scheduled Jobs</strong></td><td><code>scheduler_usecase.go</code></td><td>Cron jobs: pengecekan tagihan tertunggak (jam 21:00 daily)</td></tr>
    <tr><td><strong>Event-Driven</strong></td><td><code>event_usecase.go</code></td><td>Event bus, mediator pattern</td></tr>
</table>

<h4>4.2 Frontend: Presentasi &amp; State Management</h4>
<p>Frontend <strong>TIDAK</strong> mengandung logika bisnis krusial. Yang ada di frontend hanya:</p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Kategori</th><th>Detail</th><th>Lokasi</th></tr>
    <tr><td><strong>UI Logic</strong></td><td>Routing, layout, conditional rendering</td><td><code>app/admin/</code></td></tr>
    <tr><td><strong>State Management</strong></td><td>Redux Toolkit (37 slices!)</td><td><code>store/slices/</code></td></tr>
    <tr><td><strong>Form Validation</strong></td><td>Basic input validation (length, format)</td><td><code>formValidator.ts</code></td></tr>
    <tr><td><strong>Auth Guard</strong></td><td>JWT decode untuk routing (bukan validasi!)</td><td><code>proxy.ts</code></td></tr>
    <tr><td><strong>Role-Based UI</strong></td><td>Show/hide menu berdasarkan role dari JWT</td><td><code>useMenu.ts</code></td></tr>
    <tr><td><strong>Encryption</strong></td><td>Encrypt payload sebelum login (security)</td><td><code>@repo/utils (EncryptionUtil)</code></td></tr>
    <tr><td><strong>Normalisasi Data</strong></td><td>Format username, format tagihan type</td><td><code>normalizeUsername.ts</code></td></tr>
</table>
<p><strong>[!NOTE]</strong> Frontend menggunakan <strong>custom hooks pattern</strong> yang sangat terstruktur (25 hook directories di <code>app/hooks/</code>), tetapi hooks ini hanya membungkus API calls dan state management &mdash; bukan logika bisnis.</p>

<hr>

<h3>5. Infrastruktur Pendukung</h3>

<p><strong>Shared Libraries</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Library</th><th>Fungsi</th><th>Digunakan Oleh</th></tr>
    <tr><td><code>go-lib</code></td><td>REST base handler, response format, logger, value objects</td><td>Semua Go services</td></tr>
    <tr><td><code>jwtaccess</code></td><td>JWT auth middleware, role extraction, token blacklist</td><td>Services yang butuh auth</td></tr>
</table>

<p><strong>Observability</strong></p>
<ul>
    <li><strong>OpenTelemetry</strong> tracing terintegrasi di semua services (Fiber middleware, gRPC interceptor, GORM adapter)</li>
    <li><strong>Structured logging</strong> via <code>go-lib/pkg/logger</code> (auto-inject <code>trace_id</code>/<code>span_id</code>)</li>
    <li>Exporter dikonfigurasi via <code>OTEL_EXPORTER_OTLP_ENDPOINT</code></li>
</ul>

<p><strong>Event-Driven Architecture (Transaction Service)</strong></p>
<p>Transaction-service menggunakan pola yang paling kompleks:</p>
<ul>
    <li><strong>Event Bus</strong> &mdash; <code>event_usecase.go</code></li>
    <li><strong>Mediator Pattern</strong> &mdash; <code>mediator/</code></li>
    <li><strong>Worker Goroutines</strong> &mdash; <code>worker/</code></li>
    <li><strong>Scheduled Jobs</strong> &mdash; gocron (daily outstanding bill check)</li>
</ul>

<p><strong>Keamanan</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Layer</th><th>Mekanisme</th></tr>
    <tr><td><strong>Auth</strong></td><td>JWT Bearer Token (cookie-based di frontend)</td></tr>
    <tr><td><strong>Login Encryption</strong></td><td>Payload di-encrypt sebelum dikirim (AES/similar)</td></tr>
    <tr><td><strong>Token Blacklist</strong></td><td>Redis-backed token revocation</td></tr>
    <tr><td><strong>Role-Based Access</strong></td><td>15 role levels (Administrator &rarr; Siswa) didefinisikan di <code>jwtaccess/middleware.go</code></td></tr>
    <tr><td><strong>Route Guards</strong></td><td>Frontend middleware blocks prohibited routes per role</td></tr>
    <tr><td><strong>reCAPTCHA</strong></td><td>Google reCAPTCHA v2 di halaman login</td></tr>
</table>

<hr>

<h3>6. Kesimpulan &amp; Rekomendasi</h3>

<p>&#9989; <strong>Kekuatan Arsitektur</strong></p>
<ol>
    <li><strong>Clean Architecture</strong> yang konsisten di setiap microservice (domain/usecase/presentation/infrastructure)</li>
    <li><strong>gRPC untuk inter-service</strong> &mdash; efisien dan type-safe dengan proto definitions</li>
    <li><strong>Pemisahan concern yang jelas</strong> &mdash; Frontend murni thin client, business logic 100% di backend</li>
    <li><strong>Observability</strong> sudah terintegrasi (OpenTelemetry)</li>
    <li><strong>Shared libraries</strong> menghindari duplikasi kode</li>
    <li><strong>Monorepo frontend</strong> dengan Turborepo untuk code sharing</li>
</ol>

<p>&#9888; <strong>Area yang Perlu Perbaikan</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Area</th><th>Masalah</th><th>Rekomendasi</th></tr>
    <tr><td><strong>Dokumentasi API</strong></td><td>Tidak ada Swagger/OpenAPI</td><td>Implementasi <code>swag</code> (Go Swagger generator) atau <code>buf</code> untuk proto docs</td></tr>
    <tr><td><strong>Kontrak Data</strong></td><td>Frontend interfaces manual, tidak sync dengan backend</td><td>Pertimbangkan code generation dari proto/OpenAPI ke TypeScript</td></tr>
    <tr><td><strong>Testing</strong></td><td>Hanya ditemukan 1 test file (<code>settlement_usecase_test.go</code>)</td><td>Tingkatkan coverage, terutama untuk usecase layer</td></tr>
    <tr><td><strong>Error Handling</strong></td><td>Frontend banyak <code>any</code> type pada error handling</td><td>Definisikan error types yang konsisten</td></tr>
    <tr><td><strong>API Versioning</strong></td><td>Hanya versi path <code>/v1</code>, tidak ada mekanisme backward compatibility</td><td>Implementasikan API versioning strategy</td></tr>
</table>
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisBackendGolangSeeder extends Seeder
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

        $content2 = <<<HTML
<p>Analisis ini berfokus pada implementasi backend Golang di ALAZHARAPPS, mengevaluasi arsitektur, manajemen resource, dan tingkat kesiapan untuk skala produksi (production-readiness).</p>

<h3>1. Pola Arsitektur Kode: Clean Architecture</h3>
<p>Sistem ini menerapkan Clean Architecture yang sangat terstruktur dan konsisten di seluruh microservices (seperti account-service, transaction-service, student-service). Pendekatan ini memisahkan secara tegas antara infrastruktur teknis dan logika bisnis inti.</p>

<p><strong>Pemisahan Layer</strong><br>
Berdasarkan struktur folder, proyek ini membagi tanggung jawab sebagai berikut:</p>
<ul>
    <li><strong>Layer Infrastruktur (infrastructure/):</strong> Berisi implementasi teknis untuk koneksi ke layanan eksternal. Di sini terdapat konektor untuk PostgreSQL (postgres), Redis (redis), gRPC (grpc), HTTP server berbasis Fiber (rest), Firebase (firebase), dan gateway pengiriman pesan (whatsapp, email).</li>
    <li><strong>Layer Domain (domain/):</strong> Merupakan inti aplikasi yang tidak bergantung pada framework apapun.
        <ul>
            <li><strong>Entity (domain/entity/):</strong> Struktur data inti tabel database (misalnya User, BaseModel, Notification).</li>
            <li><strong>Aggregate (domain/aggregate/):</strong> Gabungan entitas yang memiliki relasi logika.</li>
            <li><strong>Repository Interfaces (domain/repository/):</strong> Contract atau Interface yang mendefinisikan operasi apa saja yang bisa dilakukan ke database (misalnya UserRepository). Implementasi nyata dari interface ini berada di layer infrastructure atau presentation.</li>
        </ul>
    </li>
    <li><strong>Layer Usecase/Service (usecase/):</strong> Tempat logika bisnis dan aturan aplikasi berada (misalnya billing_usecase.go, auth_usecase.go). Usecase ini memanggil fungsi-fungsi dari Repository Interface tanpa perlu tahu database apa yang digunakan.</li>
    <li><strong>Layer Presentation (presentation/):</strong> Menangani entry-point data dari luar ke sistem.
        <ul>
            <li><strong>Controller (presentation/controller/):</strong> Menangani request HTTP REST (menggunakan Fiber), memvalidasi input, memanggil Usecase, dan mengembalikan respons HTTP.</li>
            <li><strong>Handler (presentation/handler/):</strong> Menangani request gRPC antar service.</li>
            <li><strong>Event/Worker (presentation/event/ & presentation/worker/):</strong> Menangani event asynchronous atau antrean pesan.</li>
        </ul>
    </li>
    <li><strong>Layer CMD (cmd/):</strong> Fungsi main.go berada di sini. Bertugas sebagai Dependency Injection container manual (wiring) yang menggabungkan (inject) database, repository, usecase, dan router sebelum menjalankan server.</li>
</ul>

<h3>2. Konkurensi & Goroutines</h3>
<p>Aplikasi ini sangat memanfaatkan fitur konkurensi Go secara ekstensif, terutama untuk menjamin performa saat trafik tinggi dan memproses tugas latar belakang.</p>

<p><strong>Pemanfaatan Goroutine & Channel</strong></p>
<ul>
    <li><strong>Server & Worker Initialization:</strong> Di dalam <code>cmd/main.go</code>, berbagai server (REST, gRPC) dan background worker dijalankan secara konkuren menggunakan goroutine agar tidak saling memblokir:
<pre><code>go server.Start()
go grpc.Start()
go cron.Start()
go worker.Start()
go eventMediator.Start()</code></pre>
    </li>
    <li><strong>Event-Driven Mediator (presentation/event/event_mediator.go):</strong> Sistem transaksi menggunakan pola Mediator untuk mendistribusikan event. Terdapat sebuah loop <code>channel <-s.bus.Receive()</code> yang mendengarkan event masuk. Ketika event diterima, ia men-spawn goroutine baru untuk setiap handler yang terdaftar (<code>go handler.Handle(context.Background(), eventType)</code>).</li>
    <li><strong>Redis Stream Workers (presentation/worker/admission_worker.go):</strong> Pekerja latar belakang berjalan di dalam goroutine tak terbatas (infinite loop) yang secara terus-menerus menarik (polling) data dari Redis Streams untuk diproses secara asinkron.</li>
</ul>

<p><strong>Pencegahan Goroutine Leak</strong><br>
Untuk menghindari goroutine leak dan kebocoran memori, sistem menerapkan beberapa praktik terbaik:</p>
<ul>
    <li><strong>Context Cancellation:</strong> Menggunakan <code>context.Context</code> secara ketat. Di <code>cmd/main.go</code>, terdapat implementasi Graceful Shutdown menggunakan <code>signal.NotifyContext</code>. Saat server menerima sinyal terminasi (SIGINT/SIGTERM), context dibatalkan, dan semua proses yang bergantung padanya akan dihentikan secara aman (<code>server.Shutdown(shutdownCtx)</code>).</li>
    <li><strong>ErrGroup (golang.org/x/sync/errgroup):</strong> Pada proses yang kompleks seperti eksekusi beberapa query bersamaan (misal di event_usecase.go saat mencari diskon), aplikasi menggunakan <code>errgroup.WithContext</code>. Jika salah satu sub-goroutine gagal, context akan dibatalkan untuk menghentikan goroutine lainnya, mencegah goroutine menggantung (hanging).</li>
    <li><strong>Channel dengan Shutdown Signal:</strong> Pada worker latar belakang (admission_worker.go), terdapat select statement yang memonitor <code>shutdownChan</code>. Hal ini memastikan infinite loop dapat diputus saat aplikasi dihentikan.</li>
</ul>

<h3>3. Manajemen Koneksi Database (Connection Pooling)</h3>
<p>Aplikasi ini menggunakan GORM (<code>gorm.io/gorm</code>) sebagai ORM dengan driver PostgreSQL. Konfigurasi koneksinya dikelola sangat baik untuk menangani traffic spike.</p>

<p><strong>Konfigurasi Pooling (Di infrastructure/postgres/client.go)</strong><br>
Konfigurasi database diatur secara dinamis melalui file <code>.env</code> dan di-apply ke GORM melalui <code>sqlDB</code>:</p>
<pre><code>sqlDB.SetMaxOpenConns(cfg.Database.MaxOpenConn)
sqlDB.SetMaxIdleConns(cfg.Database.MaxIdleConn)
sqlDB.SetConnMaxLifetime(time.Duration(cfg.Database.MaxLifeTime) * time.Hour)
sqlDB.SetConnMaxIdleTime(time.Duration(cfg.Database.MaxIdleTime) * time.Minute)</code></pre>
<ul>
    <li><strong>SetMaxOpenConns:</strong> Membatasi jumlah maksimal koneksi terbuka yang mencegah PostgreSQL crash akibat terlalu banyak koneksi simultan.</li>
    <li><strong>SetMaxIdleConns:</strong> Menjaga jumlah koneksi siaga (idle) yang siap pakai sehingga menekan latensi pembuatan koneksi baru.</li>
    <li><strong>SetConnMaxLifetime / SetConnMaxIdleTime:</strong> Menutup koneksi lama untuk mencegah isu stale connection dan kebocoran resource di sisi database.</li>
</ul>

<p><strong>Pemisahan Read-Write (Replikasi)</strong><br>
Fitur canggih yang diterapkan adalah Read-Write Splitting menggunakan plugin <code>gorm.io/plugin/dbresolver</code>.</p>
<pre><code>readPool := dbresolver.Register(dbresolver.Config{
    Replicas: []gorm.Dialector{postgres.Open(buildDsn(cfg.DatabaseRead))},
    Policy:   dbresolver.RandomPolicy{},
})</code></pre>
<p>Ini berarti query pembacaan (SELECT) dapat dialihkan secara otomatis ke database replica (DB_READ), sementara proses penulisan (INSERT/UPDATE/DELETE) tetap di database primary. Ini sangat krusial untuk mencegah database utama tercekik saat trafik pembacaan melonjak.</p>

<h3>4. Penanganan Error & Logging</h3>
<p>Standar observabilitas (observability) di proyek ini sangat tinggi, terintegrasi dengan standar industri modern.</p>

<p><strong>Mekanisme Error Wrapping</strong><br>
Error sentinel (error yang didefinisikan secara statis) dideklarasikan di <code>domain/error.go</code> (contoh: <code>ErrUserNotFound = errors.New("user not found")</code>). Aplikasi cenderung mem-passing error langsung ke presentation layer di mana controller membungkusnya menjadi respons JSON berformat standar menggunakan utilitas dari <code>go-lib/rest/base_handler.go</code>.</p>

<p><strong>Ekosistem Logging & Observabilitas (Trace)</strong><br>
Proyek ini tidak hanya mencetak log teks biasa, tetapi menggunakan OpenTelemetry (OTel) dan Structured Logging (JSON).</p>
<ul>
    <li><strong>Distributed Tracing (OpenTelemetry):</strong> Diinisialisasi di <code>cmd/main.go</code> (<code>observability.InitTracer()</code>). Middleware OTel dipasang pada GoFiber (<code>otelfiber.Middleware()</code>) dan gRPC client (<code>otelgrpc.NewClientHandler()</code>). Ini memberikan kemampuan melacak sebuah request secara melintasi berbagai microservice (Distributed Tracing).</li>
    <li><strong>Structured GORM Logger:</strong> Query database dilog dalam format JSON lengkap dengan metrik lambat (slow queries > 200ms akan dicatat sebagai Warn).
<pre><code>gormLog := logger.NewGormLogger(
    logger.WithGormLevel(gormLevelFromEnv()),
    logger.WithSlowThreshold(200*time.Millisecond),
)</code></pre>
    Plugin tracing <code>tracing.NewPlugin</code> memastikan setiap query SQL memiliki relasi child span ke request utamanya.</li>
    <li><strong>Trace ID Injection:</strong> Logger dari pustaka bersama (<code>scm.alazhar.or.id/al-azhar-apps/go-lib/pkg/logger</code>) secara otomatis menyuntikkan trace_id dan span_id ke setiap baris log.</li>
</ul>

<p><strong>Cara Melacak Kegagalan (Log Triage)</strong></p>
<ul>
    <li><strong>Output Log:</strong> Log dikeluarkan dalam bentuk Standard Output (stdout) berformat JSON. Dalam lingkungan kontainer (Docker/Kubernetes), log ini biasanya akan ditangkap oleh log collector seperti FluentBit atau Promtail.</li>
    <li><strong>Pencarian Berbasis Trace ID:</strong> Karena log mendukung standar OpenTelemetry, tim dapat menggunakan alat APM seperti SigNoz, Jaeger, Elasticsearch, atau Grafana Loki.</li>
    <li><strong>Skenario Pelacakan:</strong> Jika seorang user melaporkan gagal mendaftar, tim dapat mencari trace_id yang terkait dengan sesi user tersebut di platform APM. Karena trace_id mengalir dari API Gateway → Account Service (HTTP) → School Service (gRPC) → Database, tim dapat melihat visualisasi grafis di titik (span) mana terjadi error, query SQL apa yang gagal, beserta pesan log JSON-nya.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => 'pendalaman-backend-golang'],
            [
                'category_id' => $category->id,
                'title' => 'Pendalaman Backend: Golang (Go)',
                'content' => $content2,
                'is_published' => true,
                'created_by' => $adminId,
                'order' => 2,
            ]
        );
    }
}

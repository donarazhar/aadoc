<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class AlazharAppsSetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pastikan kategori ada
        $category = Category::firstOrCreate(
            ['slug' => 'setup-panduan'],
            ['name' => 'Setup & Panduan', 'description' => 'Panduan instalasi dan setup lokal aplikasi']
        );

        // 2. Pastikan user pembuat ada (merujuk ke UserSeeder)
        $user = User::where('email', 'donarazhar@gmail.com')->first();
        $userId = $user ? $user->id : 1;

        // 3. Konten HTML
        $content = <<<'HTML'
<div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
    <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Jurnal Setup Lokal: Fintech Al Azhar Apps</h1>
    <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini adalah dokumentasi lengkap (langkah demi langkah) dari seluruh proses <em>troubleshooting</em> yang kita lakukan sejak awal mula <em>repository</em> ini dijalankan di komputer lokal Anda (Localhost). Format artikel ini disusun berdasarkan kronologi <strong>Masalah -> Penyebab -> Solusi</strong>.</p>
    
    <hr style="border: 0; height: 1px; background: #e2e8f0; margin: 2rem 0;">

    <h2 style="color: #1885c4; font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Tahap 1: Mengaktifkan Arsitektur Microservices (Docker Compose)</h2>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">1. Masalah: API Gateway NGINX Selalu Crash dan Mati (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">host not found in upstream</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Saat menjalankan <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">docker compose up</code>, container <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">api-gateway</code> (NGINX) selalu gagal <em>start</em> dan otomatis mati (<em>exited</em>).</li>
        <li><strong>Penyebab:</strong> NGINX diatur untuk menjadi <em>proxy</em> (<em>router</em>) ke seluruh <em>microservices</em> Golang (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">account-service</code>, <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">school-service</code>, dll). Sifat bawaan NGINX akan mengalami <em>fatal crash</em> jika <em>upstream</em> (service tujuan) mati atau tidak ditemukan saat NGINX baru dinyalakan. Karena service Golang mati saat <em>startup</em>, NGINX pun ikut mati.</li>
        <li><strong>Solusi:</strong> Kita harus memperbaiki masalah yang menyebabkan service Golang mati terlebih dahulu (lihat poin 2).</li>
    </ul>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">2. Masalah: Seluruh Service Golang Crash Loop (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">panic: runtime error</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Container <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">account-service</code>, <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">school-service</code>, dll mati seketika setelah dinyalakan. Log menunjukkan <em>panic</em> pada saat memanggil <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">postgres.New()</code>.</li>
        <li><strong>Penyebab:</strong> Sistem Golang ini menggunakan <em>library</em> <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">gorm.io/plugin/dbresolver</code> untuk fitur <em>Database Read/Write Replication</em>. <em>Source code</em> di dalam <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">config.go</code> mewajibkan adanya konfigurasi <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">DB_READ</code>. Di file <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">.env</code> lokal, variabel <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">DB_READ</code> ini belum dibuat, sehingga <em>pointer</em> database membaca <em>nil</em> (kosong) dan terjadi <em>panic</em>.</li>
        <li><strong>Solusi:</strong> Membuka folder konfigurasi (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">/config/.env</code>) di SEMUA service dan menambahkan:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>DB_WRITE=host=alazhar_postgres user=admin password=admin dbname=salam port=5432 sslmode=disable TimeZone=Asia/Jakarta
DB_READ=host=alazhar_postgres user=admin password=admin dbname=salam port=5432 sslmode=disable TimeZone=Asia/Jakarta</code></pre>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">3. Masalah: Account Service Mati karena Error Firebase (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">missing 'type' field in credentials</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Setelah database berhasil terkoneksi, <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">account-service</code> tetap mati saat mencoba menginisialisasi sistem Firebase <em>Push Notification</em>.</li>
        <li><strong>Penyebab:</strong> Pengembang menggunakan fungsi <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">log.Fatalf</code> (Fatal) jika kredensial Firebase gagal dibaca. Karena di komputer lokal kita belum mengonfigurasi <em>file JSON</em> Firebase, service pun dihentikan paksa oleh sistem.</li>
        <li><strong>Solusi:</strong> Masuk ke dalam kode sumber (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">account-service/cmd/main.go</code>), mengubah pemanggilan <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">log.Fatalf(...)</code> menjadi <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">log.Printf(...)</code>. Dengan demikian, kegagalan Firebase hanya dicatat sebagai peringatan (<em>warning</em>) dan tidak membunuh berjalannya program.</li>
    </ul>

    <div style="background: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; border-radius: 0.25rem; margin-top: 1.5rem;">
        <em>Setelah ketiga masalah ini diatasi, Anda menjalankan <code style="background: #fff; padding: 0.1rem 0.3rem; border-radius: 0.25rem;">docker compose up -d --build account-service</code> dan akhirnya NGINX beserta seluruh backend menyala stabil!</em>
    </div>

    <hr style="border: 0; height: 1px; background: #e2e8f0; margin: 2rem 0;">

    <h2 style="color: #1885c4; font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Tahap 2: Menangani Backend Error (Query Database SQL)</h2>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">4. Masalah: Query Error <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">column "deleted_at" does not exist</code></h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Saat <em>frontend</em> mencoba mengakses API Backend, log backend memunculkan <em>error</em> SQL merah.</li>
        <li><strong>Penyebab:</strong> Golang GORM menggunakan mekanisme <em>Soft Delete</em> secara bawaan. Artinya, tabel yang diakses di PostgreSQL WAJIB memiliki kolom <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">deleted_at</code>. Sayangnya, tabel <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">account.user_has_roles</code> di <em>file dump database</em> lama tidak memiliki kolom ini.</li>
        <li><strong>Solusi:</strong> Mengeksekusi instruksi SQL di PostgreSQL untuk menambahkan kolom tersebut:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>ALTER TABLE account.user_has_roles ADD COLUMN deleted_at timestamp without time zone DEFAULT NULL;</code></pre>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">5. Masalah: Query Error <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">column users.access_installment_menu does not exist</code></h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Saat melakukan klik Login, NGINX merespons dengan Error 500 dan di log tertulis kolom tersebut tidak ditemukan.</li>
        <li><strong>Penyebab:</strong> Pengembang aplikasi menambahkan fitur otorisasi cicilan di struktur kode (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">struct User</code>), namun belum di-<em>migrate</em> ke <em>database dump</em> Anda.</li>
        <li><strong>Solusi:</strong> Menyuntikkan secara manual kolom <em>boolean</em> tersebut ke tabel pengguna:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>ALTER TABLE account.users ADD COLUMN access_installment_menu boolean DEFAULT false;</code></pre>

    <hr style="border: 0; height: 1px; background: #e2e8f0; margin: 2rem 0;">

    <h2 style="color: #1885c4; font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Tahap 3: Membuka Gerbang Otentikasi (Login & Security)</h2>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">6. Masalah: Login Selalu Gagal (<code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; color: #dc2626;">401 Unauthorized</code>)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> NGINX merespons <em>request POST login</em> dengan <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">401 Unauthorized</code>, padahal database mendeteksi adanya user.</li>
        <li><strong>Penyebab 1 (Hardcode Role):</strong> Pengembang menyelipkan kode <em>if</em> di dalam <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">auth_usecase.go</code> yang memblokir login web jika <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">RoleID</code> adalah <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">6</code> (Superadmin).</li>
        <li><strong>Solusi 1:</strong> Menghapus/mengomentari blokir tersebut di <em>source code</em>:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>// if user.UserHasRole.RoleID == 6 {
//     return nil, "", "", errors.New("invalid credentials")
// }</code></pre>

    <ul style="margin-left: 1.5rem; margin-top: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Penyebab 2 (Invalid Hash):</strong> Enkripsi sandi (<em>bcrypt hash</em>) akun <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">donarazhar@gmail.com</code> di tabel PostgreSQL bukanlah "12345678".</li>
        <li><strong>Solusi 2:</strong> Mengganti <em>password hash</em> akun tersebut di database:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>UPDATE account.users SET password = '$2b$12$BMwHMvsnQkWLTDb459VY.e6UC3tTg3hb5oUa70Xo3jRLmfTSZ52pW' WHERE email = 'donarazhar@gmail.com';</code></pre>

    <hr style="border: 0; height: 1px; background: #e2e8f0; margin: 2rem 0;">

    <h2 style="color: #1885c4; font-size: 1.75rem; font-weight: 700; margin-bottom: 1rem;">Tahap 4: Mengatasi Bug Frontend React (Next.js)</h2>

    <h3 style="color: #0f172a; font-size: 1.25rem; font-weight: 600; margin-top: 1.5rem;">7. Masalah: Dashboard Terbuka, Namun Sidebar Menu Kosong (Hilang)</h3>
    <ul style="margin-left: 1.5rem; margin-bottom: 1rem;">
        <li><strong>Gejala:</strong> Login sukses, namun layar <em>sidebar</em> sama sekali tidak menampilkan menu apapun.</li>
        <li><strong>Penyebab:</strong> 
            <br>1. <strong>GORM Zero-Value Trap:</strong> ID untuk level Superadmin di database lama bernilai <strong><code>0</code></strong>. Dalam bahasa Go, angka 0 dianggap <em>zero-value</em> (kosong). GORM melewatkan fungsi pengambilan <em>preload</em> "Nama Jabatan". Akibatnya, <em>cookie</em> dicetak tanpa nama jabatan.
            <br>2. <strong>Restriksi React:</strong> <em>Source code frontend</em> sangat ketat. Ia hanya mau menampilkan menu lengkap jika nama jabatan mengandung teks persis <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">"administrator"</code>. Namun di database, namanya adalah <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">"Superadmin Level"</code>.
        </li>
        <li><strong>Solusi:</strong> Memanipulasi isi database agar selaras dengan bahasa Go dan selaras dengan <em>logic</em> React:</li>
    </ul>
    <pre style="background: #1e293b; color: #f8fafc; padding: 1rem; border-radius: 0.5rem; overflow-x: auto;"><code>-- Mengubah ID 0 menjadi 1 agar Golang tidak menganggapnya kosong
UPDATE account.role_levels SET id = 1 WHERE id = 0;
UPDATE account.user_has_roles SET role_level_id = 1 WHERE role_level_id = 0;

-- Mengubah nama agar cocok dengan pengecekan "administrator" di React
UPDATE account.role_levels SET label = 'Administrator' WHERE id = 1;</code></pre>
    <p style="margin-top: 1rem; font-size: 1.125rem;">Setelah pengguna melakukan <strong>Logout dan Login ulang</strong> untuk memancing <em>cookie</em> baru, <em>sidebar</em> sukses ter-render secara utuh.</p>

    <div style="background: #f0fdf4; border-left: 4px solid #22c55e; padding: 1rem; border-radius: 0.25rem; margin-top: 2rem;">
        <strong>Dokumentasi Selesai.</strong> Sistem telah beroperasi dalam keadaan optimal.
    </div>
</div>
HTML;

        // 4. Masukkan ke tabel documents
        $title = 'Jurnal Setup Lokal: Fintech Al Azhar Apps';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'title' => $title,
                'category_id' => $category->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 1
            ]
        );
    }
}

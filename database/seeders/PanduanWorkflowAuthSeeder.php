<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowAuthSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Skenario Workflow Lintas Sistem')],
            ['name' => 'Skenario Workflow Lintas Sistem']
        );

        $content = <<<HTML
<p>Artikel ini membedah alur logika di balik layar untuk proses <strong>Otentikasi, Registrasi, dan Pemulihan Akun</strong> pada aplikasi Mobile ALAZHARAPPS. Alur ini dikendalikan sepenuhnya oleh <code>account-service</code> di sisi backend, yang berintegrasi dengan pihak ketiga (Fonnte/Qontak) untuk pengiriman pesan WhatsApp.</p>

<h3>Diagram Urutan: Registrasi & Login Mobile</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant OTM as Pengguna (Mobile)
    participant ACC as Account Service (Backend)
    participant WA as WhatsApp Gateway (Fonnte)
    participant DB as Database (PostgreSQL)

    %% Fase Pengecekan
    OTM->>ACC: Input Nomor HP (WhatsApp)
    ACC->>DB: Cek eksistensi nomor HP
    
    alt Jika Nomor Belum Terdaftar (Registrasi Baru)
        DB-->>ACC: Data tidak ditemukan
        ACC-->>OTM: Prompt: "Nomor Belum Terdaftar, Lanjut Daftar?"
        OTM->>ACC: Input Nama Lengkap & Email
        ACC->>DB: Generate & Simpan OTP Sementara
        ACC->>WA: Trigger pengiriman OTP
        WA-->>OTM: Pesan WA: "Kode Rahasia OTP Anda: 1234"
        OTM->>ACC: Input 4 Digit OTP
        ACC->>DB: Validasi OTP
        DB-->>ACC: OTP Valid
        ACC-->>OTM: Prompt: Buat 6 Digit PIN
        OTM->>ACC: Buat & Konfirmasi 6 Digit PIN
        ACC->>DB: Hash PIN (Bcrypt) & Simpan Akun Baru
        DB-->>ACC: Akun Created
        ACC-->>OTM: Registrasi Berhasil! Diarahkan ke Login
    else Jika Nomor Sudah Terdaftar (Login)
        DB-->>ACC: Data ditemukan
        ACC-->>OTM: Tampilkan Layar Input PIN
        OTM->>ACC: Input 6 Digit PIN (Atau Biometrik)
        ACC->>DB: Verifikasi Hash PIN
        
        alt PIN Benar
            ACC->>ACC: Generate JWT Access Token
            ACC-->>OTM: Login Sukses (Simpan Token & Masuk Beranda)
        else PIN Salah / Lupa PIN
            ACC-->>OTM: Error: "PIN Salah"
            OTM->>ACC: Klik "Lupa PIN"
            ACC->>WA: Kirim OTP Reset via WhatsApp
            WA-->>OTM: Pesan WA: "Kode Reset PIN: 5678"
            OTM->>ACC: Verifikasi OTP & Buat PIN Baru
        end
    end
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Sistem otentikasi ALAZHARAPPS dirancang tanpa kata sandi (<em>passwordless</em>) berbasis teks biasa, melainkan menggunakan kombinasi <strong>Nomor WhatsApp (sebagai identitas utama)</strong> dan <strong>6-Digit PIN (sebagai kunci brankas)</strong>, meniru standar keamanan aplikasi perbankan digital (Fintech).</p>

<h4>1. Deteksi Cerdas (Smart Detection)</h4>
<p>Layar pertama yang dihadapi pengguna hanya meminta satu input: <strong>Nomor Handphone</strong>. Saat pengguna menekan "Selanjutnya", aplikasi mobile memanggil <em>endpoint</em> pengecekan (<code>/account/check</code>). Sistem backend secara otomatis mendeteksi apakah nomor ini harus diarahkan ke alur Registrasi (jika baru) atau alur Login (jika lama).</p>

<h4>2. Alur Registrasi & Pengamanan OTP</h4>
<ul>
    <li><strong>Verifikasi Identitas:</strong> Untuk mencegah pembuatan akun palsu, pengguna wajib memasukkan kode OTP (<em>One Time Password</em>). Backend ALAZHARAPPS akan memanggil API Gateway WhatsApp (Fonnte/Qontak) untuk menembakkan pesan berisi kode 4 digit ke nomor pengguna.</li>
    <li><strong>Pembuatan PIN:</strong> Setelah OTP terkonfirmasi, pengguna diwajibkan membuat 6 digit PIN. PIN ini tidak disimpan dalam bentuk teks (<em>plain text</em>), melainkan diacak (<em>hashing</em>) menggunakan algoritma kriptografi <code>Bcrypt</code> sebelum masuk ke dalam PostgreSQL.</li>
</ul>

<h4>3. Alur Login & Token JWT</h4>
<ul>
    <li>Jika pengguna sudah terdaftar, mereka hanya perlu memasukkan PIN 6 digit.</li>
    <li><strong>Dukungan Biometrik:</strong> Pada <em>login</em> selanjutnya, pengguna dapat mengaktifkan login Biometrik (Sidik Jari / Face ID). Secara teknis, aplikasi genggam akan menggunakan sensor perangkat keras ponsel untuk memvalidasi sidik jari. Jika cocok, ponsel secara lokal "mengingat" dan menembakkan kredensial (atau token sesi) ke server tanpa perlu mengetik PIN lagi.</li>
    <li><strong>JWT (JSON Web Token):</strong> Jika PIN cocok, <em>account-service</em> akan menerbitkan JWT (Token Akses). Token ini memuat <strong>Level Peran (Role Level)</strong> pengguna (Misalnya: <code>RoleLevelOrangTua = 12</code>). Mulai saat ini, setiap kali pengguna membuka menu Tagihan atau Rapor, aplikasi akan melampirkan Token ini di <em>Header HTTP</em> sebagai tiket masuk yang sah.</li>
</ul>

<h4>4. Alur Pemulihan (Reset PIN)</h4>
<p>Mekanisme pemulihan dibuat mandiri (<em>Self-Service</em>) agar tidak membebani Tata Usaha sekolah. Jika pengguna menekan "Lupa PIN", sistem akan mengulang siklus pengiriman OTP ke WhatsApp. Setelah tervalidasi, pengguna diizinkan menimpa (<em>override</em>) PIN lama mereka di database dengan PIN yang baru.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Otentikasi, Registrasi, dan Lupa PIN (Mobile)')],
            [
                'title' => 'Skenario Otentikasi, Registrasi, dan Lupa PIN (Mobile)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

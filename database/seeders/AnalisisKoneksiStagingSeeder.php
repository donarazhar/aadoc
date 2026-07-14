<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisKoneksiStagingSeeder extends Seeder
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
<p>Dokumen ini memetakan arsitektur koneksi dan integrasi pihak ketiga pada lingkungan pengujian (Staging) ALAZHARAPPS.</p>

<h3>1. Topologi Jaringan Staging</h3>
<p>Lingkungan *Staging* (biasanya diakses melalui <code>dev-api.alazhar.or.id</code> atau <code>staging.alazhar.or.id</code>) dikonfigurasi menyerupai lingkungan *Production*, namun menggunakan replika data berskala kecil.</p>
<ul>
    <li><strong>Gateway API:</strong> Semua *traffic* dari aplikasi *Frontend* masuk melalui satu titik *Reverse Proxy* (seperti Nginx atau Traefik) yang akan mendistribusikan *request* ke layanan yang tepat berdasarkan *path* (contoh: <code>/api/v1/users</code> diteruskan ke <code>account-service:8080</code>).</li>
    <li><strong>Komunikasi Internal:</strong> Layanan-layanan di belakang *firewall* (misalnya <code>student-service</code> ingin mengecek data tagihan di <code>transaction-service</code>) tidak menggunakan internet publik, melainkan terhubung langsung lewat alamat IP lokal kontainer (menggunakan protokol gRPC pada port <code>9090</code>).</li>
</ul>

<h3>2. Kredensial Pihak Ketiga (Third-Party Integrations)</h3>
<p>Pada lingkungan *Staging*, seluruh interaksi ke sistem eksternal wajib diarahkan ke mode *Sandbox* atau *Testing* untuk mencegah terjadinya mutasi data finansial yang sebenarnya:</p>
<ol>
    <li><strong>Payment Gateway (Midtrans/Xendit):</strong> Menggunakan kunci API (API Key) versi *Sandbox*. Kartu kredit atau *Virtual Account* yang digunakan untuk menguji pembayaran sumbangan sekolah adalah data fiktif.</li>
    <li><strong>OTP &amp; Notifikasi (Fonnte/Qontak/Sengrid):</strong> Pengiriman WhatsApp atau Email pada lingkungan staging biasanya dibatasi hanya ke daftar nomor staf IT yang terdaftar (Whitelist) untuk mencegah siswa atau orang tua asli menerima tagihan *dummy*.</li>
    <li><strong>Penyimpanan Berkas (AWS S3 / MinIO):</strong> Berkas yang diunggah (seperti foto profil atau tugas) tidak disimpan di *bucket* *Production*, melainkan di *bucket* *Staging* khusus yang diatur agar otomatis terhapus (auto-purge) setiap 30 hari guna menghemat biaya.</li>
</ol>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('7. Informasi Koneksi & Kredensial Staging')],
            [
                'title' => '7. Informasi Koneksi & Kredensial Staging',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisAutomatedTestingSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Quality Assurance & SDLC')],
            [
                'name' => 'Quality Assurance & SDLC',
                'description' => 'Standar pengujian mutu dan siklus pengembangan',
                'order' => 4,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini menjabarkan strategi Penjaminan Mutu (Quality Assurance) otomatis yang diimplementasikan pada ALAZHARAPPS untuk memastikan sistem pendidikan dan finansial tidak pernah mengalami kegagalan fatal saat rilis versi baru.</p>

<h3>1. Lapisan Pertama: Unit Testing (Golang)</h3>
<p>Pengujian Unit (Unit Test) adalah baris pertahanan pertama. Tim *Backend* diwajibkan menulis file pengujian berakhiran <code>_test.go</code> di setiap folder lapisan <em>Usecase</em>.</p>
<ul>
    <li><strong>Isolasi dengan Mocks:</strong> Saat menguji fungsi "Lunas Pembayaran SPP", aplikasi tidak boleh menembak *database* asli. Pengembang menggunakan pustaka seperti <code>gomock</code> atau <code>testify/mock</code> untuk mensimulasikan respons dari repositori *database* (Mocking).</li>
    <li><strong>Skenario Keberhasilan &amp; Kegagalan (Table-Driven Tests):</strong> Golang sangat erat dengan budaya pengujian berbasis tabel. Pengembang menyusun daftar skenario (contoh: "Saldo Cukup", "Siswa Tidak Ditemukan", "Tagihan Sudah Lunas"), lalu fungsi dijalankan dan divalidasi apakah responsnya sesuai dengan harapan (*Assertions*).</li>
</ul>

<h3>2. Lapisan Kedua: Integration Testing</h3>
<p>Meskipun setiap blok kode (*Unit*) berfungsi baik, mereka bisa saja hancur saat digabungkan. Pengujian integrasi memastikan koneksi dari API sampai ke Database lokal (biasanya dijalankan di dalam kontainer Docker temporer saat *pipeline* berjalan) berfungsi normal tanpa galat *syntax* SQL.</p>

<h3>3. Automasi Berkelanjutan (CI/CD Gates)</h3>
<p>Seperti yang telah dibahas pada dokumen *CI/CD Pipeline*, pengujian ini tidak diandalkan pada daya ingat pengembang (dijalankan manual di laptop lokal).</p>
<p><strong>[WARNING] Gerbang Tolak Otomatis (Fail-Safe):</strong> Saat kode didorong (*git push*) ke GitLab, <em>GitLab Runner</em> akan mengeksekusi perintah <code>go test ./... -cover</code>. Jika terdeteksi ada skenario yang gagal, atau jika persentase kode yang tertutupi oleh tes (*Code Coverage*) berada di bawah standar perusahaan (misalnya 70%), proses *Build* dan *Deploy* ke server *Staging* atau *Production* akan langsung ditolak (Dibatalkan Otomatis).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('3. Strategi Pengujian Otomatis (Automated Testing)')],
            [
                'title' => '3. Strategi Pengujian Otomatis (Automated Testing)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisQueryKritisSeeder extends Seeder
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
<p>Dokumen ini mengkaji bagaimana lapisan akses data (Data Access Layer) dikelola di dalam ALAZHARAPPS, mengidentifikasi tingkat efisiensi kueri ke basis data.</p>

<h3>1. Pendekatan Akses Data (ORM vs Raw Query)</h3>
<p>Kode sumber Golang menunjukkan penggunaan <strong>GORM (Go Object Relational Mapper)</strong> sebagai perantara utama antara aplikasi dan basis data PostgreSQL. Namun, pengembang juga menunjukkan fleksibilitas dengan mengimplementasikan kueri SQL murni (Raw SQL) untuk fungsi-fungsi tertentu.</p>
<ul>
    <li><strong>CRUD Dasar:</strong> Operasi standar seperti membuat pengguna, memperbarui data siswa, atau mengambil detail berdasarkan ID sepenuhnya mengandalkan metode bawaan GORM (<code>db.Create()</code>, <code>db.Where(...).First()</code>). Ini mempercepat pengembangan dan menjaga kode tetap rapi.</li>
    <li><strong>Query Kompleks (Raw SQL):</strong> Pada modul pelaporan (<code>report-service</code>) dan rekapitulasi nilai (<code>etl</code>), kueri GORM dihindari demi performa. Pengembang menggunakan <code>db.Raw("SELECT ... JOIN ... GROUP BY ...").Scan(&amp;results)</code>. Ini adalah langkah optimasi yang sangat tepat, karena ORM seringkali menghasilkan kueri yang lambat dan memakan banyak memori ketika menangani jutaan baris (Big Data) atau operasi agregasi.</li>
</ul>

<h3>2. Manajamen Transaksi (Database Transactions)</h3>
<p>Dalam sistem yang menangani pembayaran atau perubahan massal (seperti <code>transaction-service</code> dan <code>school-service-new</code>), menjaga keutuhan data adalah syarat mutlak.</p>
<ul>
    <li>Kode aplikasi menerapkan fungsi transaksi lokal GORM secara eksplisit: <code>tx := db.Begin()</code>, diikuti operasi data, dan diakhiri dengan <code>tx.Commit()</code> atau <code>tx.Rollback()</code> jika terjadi galat (error).</li>
    <li><strong>Area Kritis:</strong> Pada logika pembayaran (Payment Gateway callback), transaksi database ini menjamin bahwa saldo pengguna, status tagihan (invoice), dan jurnal akuntansi selalu diperbarui bersamaan. Jika salah satu gagal (misal server tiba-tiba mati di tengah jalan), maka semua perubahan dibatalkan, mencegah masalah uang melayang (Inconsistent State).</li>
</ul>

<h3>3. Kerentanan Query (N+1 Problem)</h3>
<p>Salah satu kelemahan terbesar ORM adalah masalah *N+1 Query*, di mana aplikasi menembak kueri ke database berulang kali di dalam sebuah iterasi (loop).</p>
<p><strong>[TIP] Temuan &amp; Rekomendasi:</strong> Tim ALAZHARAPPS telah memitigasi sebagian masalah ini dengan menggunakan fitur <code>Preload()</code> pada GORM untuk melakukan *Eager Loading* relasi. Walaupun begitu, disarankan untuk tetap menggunakan fitur *monitoring* database secara berkala (seperti PostgreSQL <code>pg_stat_statements</code>) untuk mendeteksi apabila ada kueri tersembunyi yang berjalan di dalam perulangan (*loop*) <em>usecase</em>.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('5. Analisis Query Kritis & Logika Database')],
            [
                'title' => '5. Analisis Query Kritis & Logika Database',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'created_by' => $adminId,
            ]
        );
    }
}

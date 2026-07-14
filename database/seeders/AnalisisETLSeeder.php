<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisETLSeeder extends Seeder
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
<p>Dokumen ini mengupas repositori khusus bernama <code>etl</code> (Extract, Transform, Load) dalam sistem ALAZHARAPPS, yang berfungsi sebagai "Pekerja Keras" untuk memindahkan dan menyinkronkan data massal (*Bulk Data*).</p>

<h3>1. Apa itu Modul ETL?</h3>
<p>Aplikasi pendidikan modern jarang berdiri sendiri. ALAZHARAPPS tidak hanya harus menyimpan datanya sendiri, tetapi seringkali harus menyinkronkan data murid ke sistem Kementerian Pendidikan (seperti Dapodik) atau memigrasikan jutaan baris data absensi dari sistem (legacy) sekolah yang lama. Jika tugas seberat ini diproses oleh <code>student-service</code>, *server* bisa mogok melayani antarmuka web.</p>
<p>Oleh karena itu, tim pengembang memisahkan tugas ini ke dalam repositori <code>etl</code>. Skrip di dalam repositori ini dirancang khusus untuk berjalan di latar belakang (Background Worker) dan didesain tahan banting dalam memproses jutaan baris data secara *streaming*.</p>

<h3>2. Proses Inti ETL (Extract, Transform, Load)</h3>
<ul>
    <li><strong>Extract (Tarik):</strong> Layanan ini terhubung ke *database* sumber (bisa berupa basis data MySQL lawas, API Dapodik, atau berkas CSV raksasa berukuran GB). Ia menarik (querying) data secara bergelombang (batch) — misal 10.000 baris per tarikan, agar RAM server tidak meluap (OOM).</li>
    <li><strong>Transform (Olah/Pembersihan):</strong> Data sumber biasanya "kotor". Misalnya, format tanggal lahir di sistem lama adalah <code>DD/MM/YYYY</code>, sementara ALAZHARAPPS butuh <code>YYYY-MM-DD</code>. Atau data jenis kelamin ditulis "Laki-laki", yang harus diubah menjadi <code>M</code>. Tahapan *Transform* menyapu bersih, memvalidasi, dan menyeragamkan data mentah tersebut menggunakan fungsi-fungsi Golang (*string manipulation*).</li>
    <li><strong>Load (Muat):</strong> Setelah data bersih dan sesuai dengan skema (struct) GORM aplikasi modern, modul ETL melakukan <em>Bulk Insert</em> atau <em>Upsert (Update if Exist)</em> ke basis data target (seperti PostgreSQL milik <code>student-service</code>).</li>
</ul>

<h3>3. Orkestrasi dan Penjadwalan (Scheduling)</h3>
<p>Kapan modul ETL ini berjalan?</p>
<ul>
    <li><strong>Sistem Terjadwal (Cronjob):</strong> Beberapa proses sinkronisasi (seperti menarik rekap absen mesin *fingerprint* ke dalam aplikasi rapor) berjalan otomatis tengah malam (pukul 01.00) saat *traffic* aplikasi sedang lengang.</li>
    <li><strong>Ekseskusi Manual (On-Demand):</strong> Kadang-kadang, admin yayasan perlu mengunggah file Excel pembagian kelas siswa. Saat tombol "Import" ditekan di aplikasi, *Frontend* mengirim tugas asinkron ke modul ETL untuk memproses file Excel tersebut. Admin bisa menutup jendela peramban, dan akan menerima notifikasi jika unggahan selesai.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('16. Sinkronisasi Data Lintas Sistem (ETL & Dapodik)')],
            [
                'title' => '16. Sinkronisasi Data Lintas Sistem (ETL & Dapodik)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

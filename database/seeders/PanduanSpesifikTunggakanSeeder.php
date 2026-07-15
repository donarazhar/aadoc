<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSpesifikTunggakanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Modul Operasional')],
            ['name' => 'Panduan Spesifik Modul Operasional']
        );

        $content = <<<HTML
<p>Dokumen ini adalah Panduan Spesifik (<em>Deep-Dive</em>) mengenai tata cara dan alur kerja (*Workflow*) sistem dalam melakukan <strong>Penanganan Tunggakan Kronis (Chronic Arrears)</strong> di ALAZHARAPPS.</p>

<h3>Konteks Bisnis (Tunggakan Finansial)</h3>
<p>Tunggakan SPP atau tagihan lainnya adalah ancaman terbesar bagi <em>Cashflow</em> yayasan. Oleh karena itu, ALAZHARAPPS dilengkapi dengan mesin "Debt Collector Digital" (Penagih Hutang Otomatis) yang bertingkat, mulai dari peringatan halus hingga pemberian sanksi di dalam sistem aplikasi akademik.</p>

<h3>Alur Kerja (SOP) Penanganan Tunggakan Kronis</h3>

<ol>
    <li>
        <strong>Eskalasi Peringatan Otomatis (Auto-Reminder)</strong>
        <ul>
            <li><strong>Skenario:</strong> SPP jatuh tempo tanggal 10. Jika sampai tanggal 11 belum lunas, mesin akan bergerak.</li>
            <li><strong>Tahap 1 (Notifikasi Halus):</strong> <em>Cron Job Scheduler</em> (Robot server yang berjalan tiap tengah malam) akan mengecek tabel <em>database</em>. Jika menemukan tagihan berstatus "Belum Lunas" dan melewati tanggal Jatuh Tempo, ia akan menembakkan <strong>Push Notification</strong> ke layar HP Orang Tua (Misal: <em>"Ayah/Bunda, tagihan SPP bulan ini belum dilunasi."</em>). UI di Aplikasi Mobile juga akan memunculkan <strong>Notification Badge</strong> (Titik Merah) di ikon tagihan.</li>
            <li><strong>Tahap 2 (Notifikasi Keras):</strong> Jika tunggakan berlanjut hingga H+14, sistem bisa diprogram untuk menembakkan notifikasi peringatan yang lebih intens (dikirim berulang setiap 3 hari sekali). Admin juga bisa mengekspor laporan <strong>Arrears (Tunggakan)</strong> di menu Laporan untuk mulai menelepon orang tua.</li>
        </ul>
    </li>
    <li>
        <strong>Sanksi Sistemik (Block Access / Restriction)</strong>
        <p>Jika tunggakan menumpuk hingga berbulan-bulan (Tunggakan Kronis) dan orang tua tidak merespons panggilan sekolah, Admin bisa mengeksekusi sanksi sistemik langsung dari Backoffice.</p>
        <ul>
            <li><strong>Jejak UI (Blokir E-Rapot):</strong> Admin masuk ke Sidebar <code>Jurnal & E-Rapot</code> &rarr; <code>E-Rapot</code> atau <code>Ijazah</code>.</li>
            <li><strong>Aksi UX & Sistem:</strong> Sistem E-Rapot memiliki pengaturan *Interceptor* (Penghalang). Jika tagihan siswa masih berstatus "Tunggakan", maka di Aplikasi Mobile, fitur <strong>"Lihat/Unduh Rapor"</strong> milik orang tua tersebut akan <strong>Dinonaktifkan (Disabled)</strong> atau terkunci secara otomatis. UX akan memunculkan pesan *Pop-up*: <em>"Maaf, rapor anak Anda terkunci karena masih memiliki administrasi yang belum diselesaikan."</em></li>
            <li><strong>Pembatasan Ujian (CBT):</strong> Demikian pula pada modul Ujian. Siswa yang menunggak secara kronis tidak akan bisa masuk ke dalam <em>Safe Exam Browser</em> untuk mengikuti UTS/UAS sampai tagihannya dilunasi (Status berubah Lunas/Hijau via DOKU).</li>
        </ul>
    </li>
</ol>

<blockquote>
<p><strong>Efisiensi Psikologis UX:</strong><br>
Pendekatan "mengunci fasilitas digital" (seperti mengunci E-Rapot atau melarang akses Ujian CBT) di Aplikasi Mobile sangat efektif secara psikologis untuk memaksa penyelesaian tunggakan tanpa staf Tata Usaha harus selalu berdebat secara fisik dengan orang tua.</p>
</blockquote>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Alur Penanganan Tunggakan')],
            [
                'title' => 'Panduan Spesifik: Alur Penanganan Tunggakan Kronis',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

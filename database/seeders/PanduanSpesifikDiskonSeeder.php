<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSpesifikDiskonSeeder extends Seeder
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
<p>Dokumen ini adalah Panduan Spesifik (<em>Deep-Dive</em>) mengenai tata cara dan alur kerja (*Workflow*) fitur <strong>Pengajuan Diskon (Potongan Biaya)</strong> di sistem ALAZHARAPPS.</p>

<h3>Konteks Bisnis</h3>
<p>Dalam operasional sekolah, tidak semua siswa membayar penuh (<em>Full Payment</em>). Ada kondisi khusus di mana siswa berhak mendapat keringanan (Diskon Saudara Kandung, Anak Pegawai, Prestasi, atau Yatim Piatu). Sistem dirancang agar pemberian diskon tidak bisa dilakukan sembarangan oleh Kasir, melainkan harus melalui proses Validasi (<em>Approval</em>) bertingkat demi menghindari kecurangan (*Fraud*).</p>

<h3>Alur Kerja (SOP) Pengajuan Diskon</h3>

<ol>
    <li>
        <strong>Inisiasi oleh Tata Usaha (TU)</strong>
        <ul>
            <li><strong>Skenario:</strong> Orang tua siswa datang ke TU membawa berkas persyaratan (Kartu Keluarga untuk bukti Saudara Kandung, atau Piagam Lomba untuk bukti Prestasi).</li>
            <li><strong>Jejak UI:</strong> TU membuka Web Backoffice &rarr; Sidebar <code>Administrasi</code> &rarr; <code>Biaya</code> &rarr; <code>Pengajuan Diskon</code>.</li>
            <li><strong>Aksi UX:</strong> TU menekan tombol <strong>Tambah Pengajuan</strong>. TU memilih nama siswa, memilih <em>Jenis Diskon</em> (Misal: Saudara Kandung = 10%), lalu sistem akan meminta TU mengunggah (*upload*) dokumen pendukung berupa file PDF/Foto.</li>
            <li><strong>Status:</strong> Tagihan siswa saat ini masih utuh (Belum terpotong), dan status pengajuan menjadi <strong>Menunggu Persetujuan (Pending)</strong>.</li>
        </ul>
    </li>
    <li>
        <strong>Validasi (Approval) oleh Kepala Sekolah / Pimpinan</strong>
        <ul>
            <li><strong>Skenario:</strong> Kepala Sekolah masuk ke sistem untuk memverifikasi keabsahan dokumen.</li>
            <li><strong>Jejak UI:</strong> Sama seperti di atas, namun Kepala Sekolah melihat tabel daftar antrean pengajuan diskon.</li>
            <li><strong>Aksi UX:</strong> Kepala Sekolah mengklik ikon <strong>Mata (View)</strong> untuk memeriksa foto Kartu Keluarga. Jika datanya valid, Kepala Sekolah menekan ikon <strong>Ceklis Hijau (Approve)</strong>.</li>
            <li><strong>Reaksi Sistem (Otomatis):</strong> Begitu tombol *Approve* ditekan, <em>Backend System</em> akan bekerja. Sistem otomatis mengurangi <em>Grand Total</em> tagihan siswa (Misal: dari Rp10.000.000 menjadi Rp9.000.000). </li>
        </ul>
    </li>
    <li>
        <strong>Notifikasi ke Aplikasi Mobile Orang Tua</strong>
        <ul>
            <li><strong>Reaksi UX Orang Tua:</strong> Sesaat setelah di-<em>approve</em>, tagihan di Aplikasi Mobile HP orang tua akan berkedip dan nominalnya berubah otomatis. Jika orang tua menekan detail tagihan, akan muncul keterangan rincian: "Potongan Saudara Kandung: -Rp1.000.000". Orang tua kemudian bisa melunasinya via DOKU <em>Virtual Account</em>.</li>
        </ul>
    </li>
</ol>

<blockquote>
<p><strong>Catatan Keamanan (Audit Trail):</strong> Semua proses siapa yang mengajukan, dan siapa Kepala Sekolah yang menyetujui, terekam secara abadi di dalam <strong>Log Activity</strong> beserta stempel waktu (*Timestamp*)-nya. Hal ini mencegah adanya staf yang bermain mata ("Diskon Bodong").</p>
</blockquote>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Alur Pengajuan Diskon')],
            [
                'title' => 'Panduan Spesifik: Alur Pengajuan Diskon (Potongan)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

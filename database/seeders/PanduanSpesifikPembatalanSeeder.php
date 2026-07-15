<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanSpesifikPembatalanSeeder extends Seeder
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
<p>Dokumen ini adalah Panduan Spesifik (<em>Deep-Dive</em>) mengenai tata cara dan alur kerja (*Workflow*) fitur <strong>Pembatalan Pendaftaran & Mutasi Keluar (Dropout / Pengunduran Diri)</strong> di sistem ALAZHARAPPS.</p>

<h3>Konteks Bisnis (Pembatalan Siswa)</h3>
<p>Ada kalanya calon siswa yang sudah membayar lunas Uang Pangkal tiba-tiba mengundurkan diri (karena pindah kota, diterima di sekolah negeri, dll). Proses membatalkan siswa tidak semudah sekadar menghapus namanya dari *database*, karena ini menyangkut uang yang sudah terekam di sistem (*Refund*) dan kuota bangku kosong yang harus dibuka kembali untuk siswa lain.</p>

<h3>Alur Kerja (SOP) Pembatalan & Pengunduran Diri</h3>

<ol>
    <li>
        <strong>Pembatalan Calon Siswa Baru (Refund Uang Pangkal)</strong>
        <ul>
            <li><strong>Skenario:</strong> Siswa X sudah lunas Uang Pangkal, tapi batal masuk.</li>
            <li><strong>Jejak UI:</strong> Admin masuk ke Sidebar <code>Administrasi</code> &rarr; <code>PMB</code> &rarr; <code>Data Calon Murid</code>.</li>
            <li><strong>Aksi UX & Sistem:</strong> Admin menekan tombol <strong>Batalkan Siswa</strong>. UX akan memunculkan *Pop-up Warning* berwarna merah untuk memastikan tindakan ini. Ketika dieksekusi:
                <ol type="a">
                    <li>Status anak tersebut diubah dari "Calon Murid" menjadi "Dibatalkan" (<em>Soft Delete</em>, data tidak dihapus permanen untuk keperluan audit).</li>
                    <li>Sistem Keuangan akan memberikan tanda (<em>Flagging</em>) pada tagihan lunasnya untuk diteruskan ke menu <em>Refund / Pengembalian Dana</em> (yang akan dieksekusi manual oleh Yayasan).</li>
                    <li><strong>Efek Samping (Side-effect):</strong> Kuota penerimaan di gelombang PMB tersebut akan otomatis bertambah +1 secara *real-time*, sehingga pendaftar *waiting list* bisa langsung masuk.</li>
                </ol>
            </li>
        </ul>
    </li>
    <li>
        <strong>Mutasi Keluar / Drop Out (Siswa Aktif)</strong>
        <ul>
            <li><strong>Skenario:</strong> Siswa Y pindah sekolah di tengah semester.</li>
            <li><strong>Jejak UI:</strong> Admin masuk ke Sidebar <code>Sekolah</code> &rarr; <code>Data Murid</code>.</li>
            <li><strong>Aksi UX & Sistem:</strong> Admin menekan menu Edit lalu mengganti Status Siswa menjadi <strong>Mutasi Keluar</strong>, diwajibkan mengisi kolom teks <code>Alasan Mutasi</code>. Reaksi sistem:
                <ol type="a">
                    <li>Siswa Y akan dihapus hubungannya dari <strong>Rombel (Kelas)</strong> dan tidak akan muncul lagi di E-Rapot milik Guru.</li>
                    <li><em>Cron Job</em> tagihan SPP bulanan untuk siswa Y akan dihentikan seketika itu juga (<strong>Terminated</strong>).</li>
                    <li>Aplikasi Mobile milik orang tua akan langsung ter-<em>log-out</em> (Akses dicabut) atau masuk ke mode *Read-Only* (Hanya bisa melihat riwayat, tidak bisa melakukan aksi).</li>
                </ol>
            </li>
        </ul>
    </li>
</ol>

<blockquote>
<p><strong>Kenapa tidak menggunakan fitur "Hapus" (Delete) biasa?</strong><br>
Sistem berskala *Enterprise* tidak pernah menggunakan penghapusan permanen (*Hard Delete*) pada data transaksi dan manusia. Semua penghapusan bersifat merubah status (Aktif menjadi Non-Aktif / *Soft Delete*). Jika data dihapus fisik, seluruh laporan keuangan tahunan dan riwayat nilai E-Rapot di masa lalu akan berantakan (*Data Integrity Failure*).</p>
</blockquote>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Spesifik Alur Pembatalan Siswa')],
            [
                'title' => 'Panduan Spesifik: Alur Pembatalan & Mutasi Keluar',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

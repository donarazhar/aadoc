<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanFiturMenuMobileSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Panduan Pengguna (User Manual)')],
            [
                'name' => 'Panduan Pengguna (User Manual)'
            ]
        );

        $content = <<<HTML
<p>Dokumen ini merangkum secara komprehensif seluruh daftar fitur dan fungsi menu yang tersedia pada aplikasi <strong>Mobile ALAZHARAPPS</strong> (Android &amp; iOS) yang digunakan oleh Orang Tua dan Siswa.</p>

<h3>1. Beranda (Home / Dashboard)</h3>
<p>Halaman pertama setelah pengguna berhasil <em>login</em>. Dirancang sebagai pusat informasi cepat.</p>
<ul>
    <li><strong>Informasi Siswa:</strong> Menampilkan foto, Nama Lengkap, Nomor Induk (NISN), Jenjang, dan Kelas siswa yang aktif. Jika orang tua memiliki 2 anak, terdapat fitur <em>"Switch Child"</em> (Tukar Profil) di pojok layar.</li>
    <li><strong>Ringkasan Tagihan (Widget Keuangan):</strong> Menampilkan angka nominal total tunggakan yang belum dibayar secara langsung tanpa perlu masuk ke menu Keuangan.</li>
    <li><strong>Pengumuman Sekolah (Broadcast/News):</strong> Berisi buletin digital (seperti informasi libur sekolah, kegiatan ekstrakurikuler, atau surat edaran yayasan).</li>
    <li><strong>Jadwal Pelajaran Hari Ini:</strong> Menampilkan daftar mata pelajaran khusus untuk hari berjalan agar siswa bisa menyiapkan buku/modul.</li>
</ul>

<h3>2. Menu Keuangan (Billing &amp; Payment)</h3>
<p>Pusat transparansi finansial untuk orang tua, terhubung *real-time* ke sistem *Virtual Account* (Midtrans/Xendit).</p>
<ul>
    <li><strong>Tab Tagihan Aktif:</strong> Daftar tagihan (SPP, Buku, Seragam, Uang Kegiatan) yang belum dilunasi. Terkategorisasi berdasarkan bulan dan urgensi (jatuh tempo).</li>
    <li><strong>Integrasi Pembayaran:</strong> Tombol untuk menghasilkan kode Virtual Account atau membuka aplikasi dompet digital (GoPay/OVO) langsung dari layar.</li>
    <li><strong>Tab Riwayat Pembayaran:</strong> Arsip seluruh tagihan yang sudah dilunasi.</li>
    <li><strong>Unduh Kwitansi Digital:</strong> Fitur untuk menyimpan atau mencetak bukti pembayaran sah berekstensi PDF langsung ke memori <em>smartphone</em>.</li>
</ul>

<h3>3. Menu Akademik &amp; e-Learning (LMS)</h3>
<p>Ruang belajar virtual interaktif pengganti kelas fisik.</p>
<ul>
    <li><strong>Ruang Mata Pelajaran:</strong> Menampilkan daftar lengkap mata pelajaran. Saat diklik, akan terbuka modul PDF atau pemutar video YouTube yang diunggah oleh guru.</li>
    <li><strong>Penugasan (Assignments):</strong> Daftar PR atau tugas. Terdapat *timer* hitung mundur (Countdown) untuk pengingat batas pengumpulan tugas (Deadline).</li>
    <li><strong>Upload Tugas:</strong> Siswa dapat memfoto buku catatan, atau mengunggah *file* langsung dari memori HP ke sistem.</li>
    <li><strong>Rekap Nilai (Raport Sementara):</strong> Menampilkan nilai kuis harian, UTS, atau UAS yang telah diverifikasi guru.</li>
    <li><strong>Rekap Kehadiran (Absensi):</strong> Persentase tingkat kehadiran siswa (Hadir/Sakit/Izin/Alpha).</li>
</ul>

<h3>4. Menu Ujian (Computer Based Test)</h3>
<p>Menu khusus yang diaktifkan pada musim ujian sekolah.</p>
<ul>
    <li><strong>Daftar Ujian Tersedia:</strong> Menampilkan ujian yang hanya bisa ditekan pada jam yang telah ditentukan (misalnya Ujian Matematika, aktif jam 08.00).</li>
    <li><strong>Integrasi Safe Exam Browser (SEB):</strong> Pintu gerbang peluncuran layar ujian anti-curang. Jika fitur ini menyala, HP siswa akan terkunci di layar soal (tidak bisa *screenshot* atau ganti aplikasi).</li>
</ul>

<h3>5. Menu Profil &amp; Pengaturan</h3>
<ul>
    <li><strong>Data Diri:</strong> Menampilkan rekapan data lengkap keluarga (Alamat, Nomor Telepon). Jika ingin melakukan perubahan, diarahkan untuk lapor ke Tata Usaha.</li>
    <li><strong>Ganti Kata Sandi (Change Password):</strong> Fitur mandiri untuk mengubah kata sandi akun tanpa campur tangan admin.</li>
    <li><strong>Bantuan &amp; Layanan Pelanggan (Helpdesk):</strong> Tautan langsung menuju WhatsApp resmi sekolah atau halaman Tanya Jawab (FAQ) jika orang tua mengalami kendala teknis.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('7. [Mobile] Fitur dan Fungsi Menu Lengkap')],
            [
                'title' => '7. [Mobile] Fitur dan Fungsi Menu Lengkap',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

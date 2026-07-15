<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanMenuBackofficeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Pengguna (User Manual)')],
            ['name' => 'Buku Panduan Pengguna (User Manual)']
        );

        $content = <<<HTML
<p>Artikel ini memberikan analisa mendalam mengenai struktur Menu (<em>Sidebar</em>) pada halaman Backoffice khusus untuk <strong>Admin Sekolah</strong>. Susunan menu ini dirancang mengikuti alur operasional sekolah yang sesungguhnya (dari pendaftaran awal hingga kelulusan).</p>

<h3>Diagram Hierarki Menu Backoffice</h3>
<pre><code class="language-mermaid">
mindmap
  root((Menu Admin Sekolah))
    Dashboard & Transaksi
      Summary (Ringkasan)
      Murid (Grafik Siswa)
      Transaksi PMB
    Laporan
      Keuangan Murid
    Sekolah (Master Data)
      Data Murid & Profil
      Rombel & Kurikulum
      Pegawai
      Kenaikan Kelas & Kelulusan
    Administrasi (Operasional)
      PMB
      Data Calon Murid
      Biaya
      Kalender
    Manajemen User & Jurnal
      User Sekolah & Log
      E-Rapot & Ijazah
</code></pre>

<h3>1. Kelompok Menu "Dashboard" & "Transaksi"</h3>
<p>Ini adalah halaman penyambut saat Admin Sekolah pertama kali masuk (<em>login</em>).</p>
<ul>
    <li><strong>Summary & Murid:</strong> Menampilkan analitik visual (grafik) mengenai arus kas sekolah (Penerimaan vs Tunggakan) serta demografi jumlah murid aktif yang dirender dari <code>report-service</code> secara kilat.</li>
    <li><strong>Transaksi PMB (Penerimaan Murid Baru):</strong> Modul akses cepat untuk mengeksekusi konfirmasi pembayaran khusus pendaftaran murid baru tanpa perlu masuk jauh ke dalam menu pengaturan biaya.</li>
</ul>

<h3>2. Kelompok Menu "Laporan"</h3>
<ul>
    <li><strong>Keuangan Murid:</strong> Sebuah pusat unduh (<em>Export Center</em>) di mana Admin dapat menarik file Excel/CSV berisi laporan pembayaran SPP atau tagihan lainnya. Menu ini membebaskan Admin dari tugas rekapitulasi manual di akhir bulan.</li>
</ul>

<h3>3. Kelompok Menu "Sekolah" (Pusat Master Data)</h3>
<p>Kelompok menu ini adalah pondasi struktural dari unit sekolah tersebut.</p>
<ul>
    <li><strong>Profile Sekolah, Kurikulum, & Program:</strong> Pengaturan statis mengenai identitas sekolah (seperti jam buka, akreditasi) dan kurikulum yang dianut.</li>
    <li><strong>Data Murid & Pegawai:</strong> Mengelola *database* seluruh manusia yang berada di dalam lingkungan sekolah (Siswa Aktif, Guru, dan Staf).</li>
    <li><strong>Rombel (Rombongan Belajar):</strong> Tempat Admin memetakan anak-anak dari "Data Murid" ke dalam kelas spesifik, serta menunjuk seorang Guru sebagai Wali Kelas. Relasi ini sangat krusial karena akan memengaruhi siapa yang berhak mengisi E-Rapot nantinya.</li>
    <li><strong>Akademik (Kenaikan Kelas & Kelulusan):</strong> Menu ini ditekan <strong>sekali setahun</strong> pada saat tahun ajaran berakhir. Admin mengeksekusi mutasi massal untuk menaikkan kelas siswa (misalnya dari Kelas 1A ke 2A) atau meluluskan mereka.</li>
    <li><strong>Sarana Prasarana, Ekstrakurikuler, Prestasi:</strong> Data pelengkap yang akan muncul di Rapor Digital siswa.</li>
</ul>

<h3>4. Kelompok Menu "Administrasi" (Mesin Penggerak Utama)</h3>
<p>Ini adalah kelompok menu yang paling sibuk dan sering digunakan setiap harinya oleh staf Tata Usaha dan Keuangan.</p>
<ul>
    <li><strong>PMB (Penerimaan Murid Baru):</strong>
        <ul>
            <li><strong>Gelombang Pendaftaran:</strong> Membuka "Keran" pendaftaran (Misal: Gelombang 1 buka di Januari).</li>
            <li><strong>Animo:</strong> Daftar orang tua yang sekadar membuat akun atau sekadar melirik (belum membeli formulir).</li>
            <li><strong>Jadwal Ujian & Peserta Ujian:</strong> Mengelola tes seleksi masuk.</li>
            <li><strong>Kelulusan Peserta:</strong> Memutuskan siapa yang diterima menjadi <strong>Calon Murid</strong>.</li>
        </ul>
    </li>
    <li><strong>Data Calon Murid:</strong> Anak-anak yang sudah lulus seleksi PMB namun belum resmi menjadi murid aktif (biasanya karena belum melunasi Uang Pangkal).</li>
    <li><strong>Biaya (Financial Engine):</strong>
        <ul>
            <li><strong>Uang Sekolah (SPP):</strong> Mengatur <em>generate</em> tagihan rutin bulanan otomatis.</li>
            <li><strong>Uang Pangkal:</strong> Mengatur tagihan satu kali (<em>One-time fee</em>) di awal masuk sekolah.</li>
            <li><strong>Uang Daftar Ulang (Tahunan):</strong> Seperti yang tertera di form, ini adalah tagihan rutin tahunan. Setiap kali siswa naik kelas (pergantian Tahun Ajaran Baru), Admin menekan menu ini untuk menerbitkan tagihan pendaftaran ulang. Form ini juga mengatur Jatuh Tempo agar sistem bisa menembakkan notifikasi peringatan.</li>
            <li><strong>Pengajuan Diskon:</strong> Pusat <em>Approval</em> di mana Admin bisa memasukkan diskon Saudara Kandung atau Anak Pegawai, yang kemudian memotong tagihan di sistem secara <em>real-time</em>.</li>
        </ul>
    </li>
</ul>

<h3>5. Kelompok Menu "Manajemen User" & "Jurnal & E-Rapot"</h3>
<ul>
    <li><strong>Manajemen User (User Sekolah & Log Activity):</strong> Menu ini mengatur otorisasi (RBAC - <em>Role Based Access Control</em>). Admin dapat memberikan akses spesifik ke staf baru. <strong>Log Activity</strong> (Jejak Audit) sangat penting untuk keamanan, di mana sistem merekam siapa (User ID) yang menghapus atau mengubah nominal tagihan demi mencegah <em>Fraud</em> (Kecurangan).</li>
    <li><strong>Jurnal & E-Rapot (E-Rapot & Ijazah):</strong> Gerbang akses menuju <code>report-service</code>. Di sini Admin bisa memantau perkembangan input nilai dari puluhan guru, mengunci rapor (<em>Lock</em>), dan men-<em>generate</em> PDF Ijazah untuk diunduh oleh orang tua di akhir tahun ajaran.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Analisa Mendalam Struktur Menu Sidebar Backoffice')],
            [
                'title' => 'Analisa Mendalam Struktur Menu Sidebar Backoffice',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

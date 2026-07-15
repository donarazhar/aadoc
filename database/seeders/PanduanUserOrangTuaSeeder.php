<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUserOrangTuaSeeder extends Seeder
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
<p>Artikel ini adalah panduan dasar operasional (SOP) khusus bagi <strong>Orang Tua Murid</strong> (Role Level 12) dalam menggunakan Aplikasi Mobile ALAZHARAPPS. Semua interaksi Orang Tua dengan sekolah dirancang agar dapat dilakukan dari genggaman tangan.</p>

<h3>Diagram Perjalanan Pengguna (User Journey)</h3>
<pre><code class="language-mermaid">
journey
    title Perjalanan Orang Tua Murid di ALAZHARAPPS
    section 1. Onboarding (Awal)
      Unduh Aplikasi: 5: Orang Tua
      Login via No WA (OTP): 4: Orang Tua, Sistem
      Buat PIN Keamanan: 5: Orang Tua
    section 2. Pendaftaran (PMB)
      Isi Formulir Anak: 4: Orang Tua
      Bayar Uang Pangkal: 5: Orang Tua, Bank
      Status Anak = Aktif: 5: Sistem
    section 3. Rutinitas Harian
      Terima Notif Presensi Anak: 5: Orang Tua, Sekolah
      Cek Jadwal & Nilai: 4: Orang Tua
      Bayar SPP Bulanan: 3: Orang Tua
</code></pre>

<h3>1. Skenario Onboarding & Login (Masuk Aplikasi)</h3>
<p>ALAZHARAPPS mengusung konsep <em>Passwordless</em> yang sangat memudahkan orang tua yang sering lupa kata sandi.</p>
<ul>
    <li><strong>Langkah 1:</strong> Buka aplikasi ALAZHARAPPS yang telah diunduh dari PlayStore/AppStore.</li>
    <li><strong>Langkah 2:</strong> Masukkan Nomor WhatsApp yang aktif.</li>
    <li><strong>Langkah 3:</strong> Sistem akan mengirimkan kode OTP (4-6 digit) ke WhatsApp tersebut. Masukkan kode OTP ke dalam aplikasi.</li>
    <li><strong>Langkah 4:</strong> Pada login pertama kali, aplikasi akan meminta Orang Tua untuk membuat <strong>PIN Keamanan (6 Digit)</strong>. PIN ini akan digunakan untuk konfirmasi saat akan melakukan pembayaran tagihan.</li>
</ul>

<h3>2. Skenario Penerimaan Murid Baru (PMB)</h3>
<p>Jika Orang Tua ingin mendaftarkan anak baru (baik anak pertama maupun anak kedua):</p>
<ul>
    <li><strong>Langkah 1:</strong> Di halaman beranda, tekan tombol <strong>Pendaftaran Murid Baru</strong>.</li>
    <li><strong>Langkah 2:</strong> Pilih Unit Sekolah (TKA/SD/SMP/SMA) dan Tahun Ajaran.</li>
    <li><strong>Langkah 3:</strong> Isi biodata anak secara lengkap (termasuk NIK dan Data Medis). <em>Catatan: Jika anak adalah saudara kandung dari murid yang sudah ada, sistem akan mendeteksi NIK Orang Tua untuk menghubungkan data keluarga.</em></li>
    <li><strong>Langkah 4:</strong> Sistem akan menerbitkan Tagihan Pendaftaran/Uang Pangkal. Tekan tombol <strong>Bayar</strong> untuk mendapatkan nomor <em>Virtual Account</em> atau kode QRIS. Setelah dibayar, status pendaftaran berubah menjadi Lulus/Aktif.</li>
</ul>

<h3>3. Skenario Pemantauan Rutin (Monitoring Akademik & Keuangan)</h3>
<p>Ini adalah fitur yang paling sering digunakan setiap harinya:</p>
<ul>
    <li><strong>Notifikasi Kehadiran (Presensi):</strong> Setiap pagi, ketika wali kelas menekan tombol simpan absensi atau anak melakukan <em>tap</em> kartu, sebuah <em>Push Notification</em> (lonceng) akan muncul di HP Orang Tua yang menginformasikan bahwa anak telah tiba di sekolah.</li>
    <li><strong>Cek Nilai & Jadwal Ujian:</strong> Melalui menu Akademik, Orang Tua dapat melihat nilai harian (hasil ujian CBT) yang diisi oleh guru secara seketika tanpa harus menunggu pembagian Rapor di akhir semester.</li>
    <li><strong>Pembayaran SPP:</strong> Setiap awal bulan, Tagihan SPP akan muncul di aplikasi. Orang tua cukup menekan tombol <strong>Bayar Sekarang</strong>, memilih metode (Gopay/OVO/Bank), dan saldo tagihan otomatis lunas dalam hitungan detik (tanpa perlu mengirim foto bukti transfer ke guru).</li>
</ul>

<h3>4. Skenario Transisi Akhir Tahun (Kenaikan Kelas)</h3>
<ul>
    <li><strong>Rapor Digital:</strong> Di akhir tahun ajaran, Orang Tua dapat mengunduh dokumen Rapor Resmi (berformat PDF yang terkunci) langsung dari aplikasi.</li>
    <li><strong>Daftar Ulang:</strong> Sistem akan secara otomatis memunculkan tagihan Daftar Ulang untuk tahun ajaran baru. Jika daftar ulang dibayar, akun anak akan secara otomatis "Naik Kelas" di dalam sistem.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Dasar Penggunaan Aplikasi Mobile (Orang Tua)')],
            [
                'title' => 'Panduan Dasar Penggunaan Aplikasi Mobile (Orang Tua)',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

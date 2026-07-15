<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanProsesBisnisALAZHARSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Buku Panduan Proses Bisnis')],
            ['name' => 'Buku Panduan Proses Bisnis']
        );

        $content = <<<HTML
<p>Dokumen ini memetakan alur kerja (<em>Business Process</em>) dari ujung ke ujung ekosistem <strong>ALAZHARAPPS</strong>, yang kini disempurnakan dengan <strong>Peta Navigasi UI/UX</strong> (Panduan *Klik*). Dokumen ini berfungsi sebagai SOP Utama bagi Admin Tata Usaha dan Bendahara.</p>

<h3>1. Proses Hulu: Penerimaan Murid Baru (PMB)</h3>
<p>Siklus mengubah masyarakat umum menjadi siswa resmi sekolah.</p>
<ul>
    <li><strong>Tahap 1: Pembukaan Pendaftaran (Setup Gelombang)</strong>
        <ul>
            <li><strong>Jejak UI (Admin):</strong> Masuk *Backoffice* &rarr; Sidebar Kiri &rarr; <code>Administrasi</code> &rarr; <code>PMB</code> &rarr; <code>Gelombang Pendaftaran</code>.</li>
            <li><strong>Aksi UX:</strong> Klik tombol biru <strong>"Tambah"</strong>. Isi rentang tanggal (<em>Date Picker</em>) dan nominal Harga Formulir, lalu tekan <strong>"Simpan"</strong>.</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Pantau Animo & Calon Murid</strong>
        <ul>
            <li><strong>Jejak UI (Admin):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>PMB</code> &rarr; <code>Animo</code> (Bagi yang belum bayar formulir) ATAU <code>Data Calon Murid</code> (Bagi yang sudah bayar formulir).</li>
            <li><strong>Aksi UX:</strong> Halaman berupa *Data Grid* tabel. Admin memantau pergerakan data *real-time*. Jika orang tua komplain gagal bayar via DOKU, Admin bisa beralih ke Sidebar <code>Transaksi</code> &rarr; <code>PMB</code> untuk melakukan aksi klik <strong>Ikon Uang (Force Paid)</strong> dan mengunggah bukti transfer manual.</li>
        </ul>
    </li>
    <li><strong>Tahap 3: Pelaksanaan Ujian (Entrance Test)</strong>
        <ul>
            <li><strong>Jejak UI (Admin):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>PMB</code> &rarr; <code>Jadwal Ujian</code> (Buat jadwalnya) lalu <code>Peserta Ujian</code> (Masukkan anak ke jadwal tersebut).</li>
        </ul>
    </li>
    <li><strong>Tahap 4: Yudisium Kelulusan Masuk</strong>
        <ul>
            <li><strong>Jejak UI (Admin):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>PMB</code> &rarr; <code>Kelulusan Peserta</code>.</li>
            <li><strong>Aksi UX:</strong> Pilih nama siswa dari tabel, tekan tombol hijau <strong>"Luluskan"</strong>. Sistem memindahkan data anak ini menjadi calon murid siap bayar uang pangkal.</li>
        </ul>
    </li>
</ul>

<h3>2. Proses Inti: Mesin Keuangan (Tagihan & Pembayaran)</h3>
<p>Siklus perputaran uang (<em>Cashflow</em>) yang terotomatisasi penuh.</p>
<ul>
    <li><strong>Tahap 1: Setup Uang Pangkal & SPP</strong>
        <ul>
            <li><strong>Jejak UI (Bendahara):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>Biaya</code> &rarr; <code>Uang Sekolah</code> ATAU <code>Uang Pangkal</code>.</li>
            <li><strong>Aksi UX:</strong> Pilih Tahun Ajaran dan Kelas. Tekan tombol dinamis <strong>"+ Tambah Komponen Biaya"</strong> berulang kali untuk memecah tagihan (Gedung, Seragam, dll). Perhatikan spanduk (<em>Banner</em>) <strong>Total Biaya</strong> di bagian bawah yang berhitung otomatis.</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Pengajuan Diskon (Bila Ada)</strong>
        <ul>
            <li><strong>Jejak UI (Kepala Sekolah):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>Biaya</code> &rarr; <code>Pengajuan Diskon</code>.</li>
            <li><strong>Aksi UX:</strong> Tekan ikon <strong>"Ceklis Hijau" (Approve)</strong> di kolom aksi. UX sistem akan seketika mengubah nominal <em>Grand Total</em> tagihan di *database* anak tersebut.</li>
        </ul>
    </li>
    <li><strong>Tahap 3: Pembayaran & Webhook (Tanpa Sentuhan Admin)</strong>
        <ul>
            <li><strong>Jejak UI (Orang Tua):</strong> Buka Aplikasi Mobile Android/iOS &rarr; Menu Utama &rarr; <code>Transaksi / Keuangan</code>.</li>
            <li><strong>Aksi UX:</strong> Orang tua melihat tagihan merah, memilih <strong>Mandiri VA (DOKU)</strong>, menyalin nomor, dan transfer dari <em>M-Banking</em>.</li>
            <li><strong>Reaksi UX Sistem:</strong> Dalam hitungan detik (*Webhook*), Aplikasi HP akan berubah menjadi centang hijau. Di Backoffice, tagihan pindah dari tabel <em>Unpaid</em> ke <em>History</em>.</li>
        </ul>
    </li>
</ul>

<h3>3. Proses Hilir: Mutasi Tahunan (Akhir Tahun Ajaran)</h3>
<p>Siklus bulan Juni/Juli untuk menaikkan kelas siswa lama.</p>
<ul>
    <li><strong>Tahap 1: Kenaikan Kelas Massal</strong>
        <ul>
            <li><strong>Jejak UI (Admin):</strong> Sidebar &rarr; <code>Sekolah</code> &rarr; <code>Akademik</code> &rarr; <code>Kenaikan Kelas & Kelulusan</code>.</li>
            <li><strong>Aksi UX:</strong> Pilih Kelas Asal, pilih Kelas Tujuan. Gunakan <em>Checkbox</em> masal untuk mencentang 30 nama siswa sekaligus, lalu klik <strong>"Proses Naik Kelas"</strong>.</li>
        </ul>
    </li>
    <li><strong>Tahap 2: Eksekusi Tagihan Daftar Ulang Tahunan</strong>
        <ul>
            <li><strong>Jejak UI (Bendahara):</strong> Sidebar &rarr; <code>Administrasi</code> &rarr; <code>Biaya</code> &rarr; <code>Uang Daftar Ulang</code>.</li>
            <li><strong>Aksi UX:</strong> Isi <strong>"Tanggal Jatuh Tempo"</strong> pada form (*Sangat Krusial!*). Setelah disimpan, sistem *Cron Job* akan menagihkan biaya ini dan mengirim <em>Push Notification</em> ke HP orang tua jika telat membayar.</li>
        </ul>
    </li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan SOP Proses Bisnis ALAZHARAPPS')],
            [
                'title' => 'Panduan SOP Proses Bisnis (UI/UX Lengkap) - ALAZHARAPPS',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

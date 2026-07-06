<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuAkademikKenaikanKelasArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Akademik (Kenaikan Kelas & Kelulusan)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Kenaikan Kelas &amp; Kelulusan</strong> yang diposisikan di bawah menu "Sekolah &gt; Akademik" mengemban fungsi manajerial yang sangat krusial di setiap pergantian tahun ajaran. Antarmuka ini dirancang khusus untuk mewadahi perpindahan status akademis siswa secara massal (<i>bulk action</i>), dari satu tingkat ke tingkat di atasnya, maupun memproses kelulusan mereka.</p>

<h3>Struktur dan Navigasi Halaman</h3>
<p>Mengingat eksekusi kenaikan kelas berimplikasi pada modifikasi ribuan baris data, halaman ini dirancang dengan lapis proteksi UX (*User Experience*) dan filter data yang sangat ketat.</p>

<h4>1. Segmentasi Status (Tab Switcher)</h4>
<p>Area teratas halaman didominasi oleh sebuah <i>tab switcher</i> (tombol ganti mode) berukuran besar yang memisahkan layar ke dalam dua dimensi status:</p>
<ul>
    <li><strong>Belum Diproses:</strong> <i>Tab</i> aktif (ditandai warna biru) yang menampilkan himpunan siswa di kelas lamanya dan sedang menunggu eksekusi kenaikan.</li>
    <li><strong>Sudah Diproses:</strong> <i>Tab</i> riwayat (<i>history</i>) yang memuat siswa yang sukses dinaikkan kelasnya. Fitur ini memberikan ketenangan batin (<i>peace of mind</i>) dan kendali bagi admin untuk mengaudit kembali pekerjaannya.</li>
</ul>

<h4>2. Banner Panduan (Inline System Feedback)</h4>
<p>Sistem menyematkan <i>banner</i> notifikasi berwarna biru muda (berisi teks panduan seperti "<i>Tekan tombol Batalkan jika ingin mengembalikan murid...</i>"). Bentuk <i>Microcopy</i> ini berperan layaknya asisten virtual, membimbing admin pada langkah apa yang bisa/harus diambil tanpa perlu menekan tombol <i>Help</i>.</p>

<h4>3. Panel Proteksi dan Filter Pintar</h4>
<p>Sebelum bisa menaikkan status kelas, admin diwajibkan untuk mengisolasi himpunan data (<i>data slicing</i>) pada rombel tertentu:</p>
<ul>
    <li><strong>Peringatan Pra-Tindakan (Pre-action Warning):</strong> Jika admin terburu-buru, sistem akan memberikan *feedback* teks merah bertuliskan "<i>Silahkan pilih Kelas, Program, dan Rombel terlebih dahulu</i>". Ini adalah tameng UX brilian (<i>Error Prevention</i>) untuk menihilkan insiden salah rombel.</li>
    <li><strong>Form Filter Rantai:</strong> Menggunakan tiga <i>dropdown</i> (<code>Kelas</code>, <code>Program</code>, <code>Rombel</code>) beserta tombol "Terapkan" guna memuat daftar murid yang akurat ke dalam tabel di bawahnya.</li>
</ul>

<h4>4. Area Tabel &amp; Tindakan Massal (Bulk Action)</h4>
<p>Ini adalah pusat operasional tempat penentuan kelas tereksekusi:</p>
<ul>
    <li><strong>Eksekusi Massal (Bulk Select):</strong> Kehadiran fitur <i>Checkbox</i> "Pilih Semua" adalah nyawa utama dari efisiensi halaman ini. Fitur ini memangkas repetisi tugas admin, memampukan pemrosesan satu kelas utuh hanya dalam hitungan detik.</li>
    <li><strong>Tombol Aksi Mengambang:</strong> Terdapat deretan tombol dinamis seperti "Naik Kelas" (biru berikon <i>check</i>) serta <i>Search Bar</i> untuk intervensi individual jika ada murid yang tinggal kelas atau butuh penanganan tersendiri.</li>
    <li><strong>Ilustrasi Empty State:</strong> Tabel tidak dibiarkan berbentuk kotak-kotak putih kosong jika data belum dimuat, melainkan diisi dengan ilustrasi dokumen dan kaca pembesar. Praktik ini menghapus ambiguitas (apakah sistem eror atau memang data kosong?).</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Secara arsitektural, halaman "Kenaikan Kelas &amp; Kelulusan" adalah mahakarya perpaduan antara <strong>User Control</strong> (kendali pengguna) dan <strong>Error Prevention</strong> (pencegahan kesalahan). Kewajiban untuk menerapkan filter data spesifik sebelum tabel bisa dieksekusi, dipadukan dengan fungsionalitas pengubah massal (<i>bulk checkbox</i>) dan pembagian status <i>tab</i> (Belum/Sudah Diproses), sukses menciptakan alur kerja yang sangat aman (*fool-proof*), efisien, dan melegakan (<i>stress-free</i>) bagi para admin akademik di puncak kesibukan akhir tahun.</p>
',
                'is_published' => true,
                'order' => 11
            ]
        );
    }
}

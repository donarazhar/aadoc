<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class AnalisaModulBackofficeArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori Backoffice Salam Al Azhar ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Backoffice Al Azhar Apps')],
            ['name' => 'Backoffice Al Azhar Apps', 'description' => 'Artikel tentang sistem backoffice Al Azhar Apps', 'order' => 1]
        );

        // Buat artikel Analisa Modul Backoffice
        $title = 'Analisa Modul Backoffice Al Azhar Apps (Versi Revisi)';
        Document::updateOrCreate(
            ['slug' => Str::slug('Analisa Modul Backoffice')], // Tetap gunakan slug lama agar mereplace
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p><strong>1. Analisa Menyeluruh Modul Backoffice</strong></p>
<p>Dari seluruh halaman (screenshot) yang ada, sistem ini terbagi menjadi beberapa modul utama. Perlu dicatat di awal bahwa aplikasi ini dibangun dengan <strong>arsitektur multi-sekolah dalam satu Yayasan</strong> — sesuai tagline "<em>One Platform, All Solutions</em>" dan adanya filter "Cari Nama Sekolah" di berbagai laporan. Artinya, satu Yayasan bisa membina banyak sekolah (TK, SD, dst.) dalam satu platform yang sama, dan data antar-sekolah tersebut saling terhubung — bukan aplikasi yang berdiri sendiri per sekolah.</p>
<hr>

<h3>A. Modul Dashboard &amp; Laporan (Eksekutif &amp; Analitik)</h3>
<ul>
    <li><strong>Dashboard Summary &amp; Keuangan</strong>: Menampilkan ringkasan penerimaan dana, piutang, diskon, serta grafik pencapaian uang sekolah dan uang pangkal.</li>
    <li><strong>Dashboard Murid</strong>: Berisi <strong>dua jenis statistik yang berbeda tujuan</strong>:
        <ul>
            <li><strong>Funnel PMB</strong> — corong pendaftaran murid <em>baru</em>: Animo (minat) &rarr; Tercatat &rarr; menjadi Calon Murid.</li>
            <li><strong>Siklus Murid Aktif</strong> — statistik murid <em>lama</em> yang sudah terdaftar: Total Aktif &rarr; Daftar Ulang &rarr; Lulus &rarr; Pindah/Keluar.</li>
        </ul>
        Keduanya sering tertampil berdampingan di dashboard, namun mewakili tahap yang berbeda dalam siklus hidup murid (murid baru vs murid yang sudah berjalan).
    </li>
</ul>
<hr>

<h3>B. Modul Penerimaan Murid Baru (PMB)</h3>
<ul>
    <li><strong>Master Gelombang PMB</strong>: Pengaturan gelombang pendaftaran (tanggal buka/tutup, jatuh tempo) per jenjang dan tahun ajaran.</li>
    <li><strong>Animo &amp; Pendaftaran</strong>: Pendaftaran awal (animo) yang merekam data dasar sebelum melengkapi formulir seutuhnya. Proses ini mensyaratkan <strong>pembayaran Uang Formulir</strong> sebagai gerbang pertama sebelum calon murid bisa lanjut ke tahap ujian.</li>
    <li><strong>Ujian &amp; Kelulusan PMB</strong>: Penjadwalan ujian, pendataan peserta ujian, input nilai, dan penentuan kelulusan calon murid. Setelah dinyatakan lulus, calon murid harus melunasi <strong>Uang Pangkal (DSP)</strong> sebagai gerbang kedua sebelum resmi menjadi murid aktif.</li>
    <li><strong>Data Calon Murid Lintas Sekolah</strong> <em>(temuan tambahan)</em>: Modul ini mencatat kolom <strong>Sekolah Asal</strong> dan <strong>Sekolah Tujuan</strong>, yang mengindikasikan sistem juga melacak <strong>perpindahan/kontinuitas murid antar-sekolah dalam satu Yayasan</strong> — misalnya murid yang lulus dari jenjang TK secara otomatis terdaftar sebagai calon murid di jenjang SD milik yayasan yang sama. Ini adalah jalur PMB internal yang berbeda dari pendaftaran murid baru dari luar.</li>
</ul>
<hr>

<h3>C. Modul Akademik &amp; Master Data Sekolah</h3>
<ul>
    <li><strong>Master Sekolah &amp; Profil</strong>: Menyimpan identitas resmi sekolah (NPSN, SK, Akreditasi, Lokasi) dan struktur kepegawaian pimpinan.</li>
    <li><strong>Rombongan Belajar (Rombel) &amp; Kelas</strong>: Pemetaan murid ke dalam kelas. Satu Rombel dibentuk dari kombinasi <strong>Tahun Ajaran, Tingkat Kelas, Ruangan, Program</strong>, dan satu <strong>Wali Kelas</strong> (dari data Pegawai).</li>
    <li><strong>Kurikulum &amp; Program</strong>: Pengaturan jadwal belajar, mata pelajaran, serta program pendidikan (Reguler, Bilingual, dsb).</li>
    <li><strong>Kenaikan Kelas &amp; Kelulusan</strong>: Proses di akhir tahun ajaran ini memiliki <strong>dua cabang</strong>: murid tingkat menengah dipindahkan (naik) ke rombel tingkat lebih tinggi di tahun ajaran baru, sedangkan murid tingkat akhir diproses menjadi status <strong>Lulus</strong>, yang datanya kemudian tersambung ke modul cetak Ijazah.</li>
    <li><strong>Kalender Akademik</strong> <em>(temuan tambahan)</em>: Terdapat menu Kalender di bagian Administrasi, kemungkinan untuk mengatur agenda dan hari libur akademik sekolah.</li>
</ul>
<hr>

<h3>D. Modul Keuangan &amp; Pembayaran</h3>
<ul>
    <li><strong>Komponen Biaya</strong>: Pengaturan Biaya SPP (Uang Sekolah), Uang Pangkal, dan Biaya Daftar Ulang — masing-masing punya master data terpisah per Tahun Ajaran, Tingkat Kelas, dan Program.</li>
    <li><strong>Tagihan Murid</strong>: Sistem memisahkan tagihan berdasarkan status keanggotaan siswa:
        <ul>
            <li><strong>Calon Murid</strong> ditagih Uang Formulir dan Uang Pangkal (DSP) selama proses PMB.</li>
            <li><strong>Murid aktif</strong> ditagih SPP bulanan dan Uang Daftar Ulang setiap awal tahun ajaran.</li>
        </ul>
        Setiap tagihan dilengkapi <strong>Virtual Account (VA)</strong> dan <strong>No. Reference</strong> untuk pelacakan status lunas atau piutang secara otomatis.
    </li>
    <li><strong>Sistem Diskon/Potongan</strong>: Pengajuan diskon biaya pendidikan untuk murid aktif, dengan 6 kategori: Prestasi Kejuaraan, Prestasi Rapot, Hafalan Al-Quran, Saudara Kandung, Anak Pegawai, dan Lulusan Yayasan (YPI). Setiap pengajuan mensyaratkan minimal satu dokumen bukti pendukung, dan nominalnya langsung mengurangi tagihan yang bersangkutan.</li>
    <li><strong>Fitur Angsuran</strong> <em>(temuan tambahan, belum terekspos detail)</em>: Terdapat menu "Angsuran" di bagian Master Data, kemungkinan untuk mendukung skema cicilan pembayaran Uang Pangkal atau Daftar Ulang, meski detail formnya belum terlihat dari screenshot yang tersedia.</li>
</ul>
<hr>

<h3>E. Modul Pelengkap &amp; Kepegawaian</h3>
<ul>
    <li><strong>Personnel / Kepegawaian</strong>: Data lengkap staf/guru (NIK, NIP, pangkat, jabatan, riwayat pendidikan, data keluarga).</li>
    <li><strong>Sarana Prasarana &amp; Ekstrakurikuler</strong>: Pendataan fasilitas sekolah (ukuran ruangan, kapasitas) dan kegiatan tambahan murid, termasuk biaya ekskul dan data pelatih.</li>
    <li><strong>Prestasi Murid</strong>: Pencatatan jejak prestasi murid di berbagai tingkatan (sekolah, kabupaten, nasional, dst). Modul ini berbeda tujuan dari kategori "Prestasi" di menu Diskon — yang satu adalah <strong>portofolio riwayat lomba</strong>, sedangkan yang lain adalah <strong>klaim potongan biaya</strong> berdasarkan prestasi tersebut. Kedua modul beririsan datanya, namun fungsinya terpisah.</li>
    <li><strong>Jurnal &amp; Cetak Dokumen</strong>: Sidebar menamai grup ini "Jurnal &amp; E-Rapot", yang mengindikasikan adanya modul <strong>Jurnal Mengajar</strong> (kemungkinan pencatatan aktivitas belajar harian guru) yang belum terekspos detail dari screenshot. Sub-modul yang sudah terlihat: generate/download <strong>E-Rapot</strong> dan <strong>Ijazah</strong>, difilter berdasarkan Kelas, Rombel, dan Tahun Ajaran.</li>
    <li><strong>Manajemen User</strong>: Pengaturan akun pengguna, role (peran), status, dan otorisasi akses LMS. Terdapat juga <strong>Log Activity</strong> — fitur audit trail yang mencatat setiap aktivitas user (siapa mengubah data apa, dan kapan) untuk kebutuhan keamanan dan akuntabilitas sistem.</li>
</ul>
<hr>

<h3>Kesimpulan</h3>
<p>Al Azhar Apps merupakan <strong>platform SIS (Sistem Informasi Sekolah) multi-tenant</strong> yang dirancang untuk satu Yayasan yang membina beberapa sekolah sekaligus. Lima modul utamanya — Dashboard/Laporan, PMB, Akademik, Keuangan, dan Pelengkap/Kepegawaian — saling terhubung melalui satu alur besar: <strong>calon murid masuk lewat funnel PMB (dengan dua gerbang pembayaran: formulir dan uang pangkal) &rarr; resmi menjadi murid dan ditempatkan ke Rombel &rarr; mengikuti siklus akademik tahunan (naik kelas atau lulus) &rarr; selama aktif, dikenai tagihan berkala (SPP, daftar ulang) yang bisa dipotong lewat sistem diskon dan dilacak otomatis via Virtual Account</strong>.</p>
<p>Yang membuat sistem ini berbeda dari SIS generik adalah dua hal: <strong>jalur kontinuitas murid antar-sekolah dalam satu Yayasan</strong> (misalnya otomatis dari TK ke SD) dan <strong>pemisahan tegas antara tagihan Calon Murid vs Murid aktif</strong>, yang mencerminkan business logic khas institusi pendidikan berjenjang di bawah satu payung yayasan.</p>
',
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

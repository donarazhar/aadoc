<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeTransaksiPmbArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori UI/UX Backoffice ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        // Buat artikel UI/UX Transaksi PMB
        $title = 'Transaksi Penerimaan Murid Baru (PMB)';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Halaman <strong>Penerimaan Murid Baru (Transaksi PMB)</strong> merupakan antarmuka krusial dalam siklus operasional pendaftaran siswa baru di sistem Al Azhar Apps. Halaman ini dirancang dengan pendekatan <i>tabbed navigation</i> (navigasi berbasis tab) untuk memecah alur kerja administrasi PMB menjadi tiga fase utama yang terstruktur, memastikan tim panitia dapat melacak status setiap pendaftar secara presisi.</p>

<h3>Komponen Navigasi dan Pencarian</h3>
<p>Di bagian atas antarmuka, terdapat elemen fungsional yang mendukung efisiensi operasional harian:</p>
<ul>
    <li><strong>Tab Fase PMB:</strong> Terdiri dari tiga tab utama yaitu <i>Animo</i>, <i>Melengkapi Formulir</i>, dan <i>PMB</i> yang merepresentasikan perjalanan (<i>funnel</i>) calon murid.</li>
    <li><strong>Kolom Pencarian (Search):</strong> Memungkinkan pencarian data secara instan berdasarkan nama, nomor registrasi, atau nomor handphone tanpa memuat ulang halaman.</li>
    <li><strong>Tombol Filter:</strong> Menyediakan opsi penyaringan data lanjutan (seperti filter berdasarkan gelombang, jenjang, asal sekolah, atau status) untuk mempersempit tabel daftar pendaftar.</li>
</ul>

<h3>1. Tab "Animo" (Fase Inisiasi &amp; Pembayaran Formulir)</h3>
<p>Tab <strong>Animo</strong> berfungsi sebagai kolam penampungan awal bagi seluruh prospek yang baru saja membuat akun dan meregistrasikan minat mereka.</p>
<ul>
    <li><strong>Tujuan Utama:</strong> Memantau komitmen awal calon siswa melalui pelunasan biaya pendaftaran (Uang Formulir).</li>
    <li><strong>Karakteristik Tabel:</strong> 
        <ul>
            <li><code>Uang Formulir</code>: Menampilkan nominal tagihan formulir pendaftaran.</li>
            <li><code>Status Pembayaran</code>: Menggunakan komponen label warna yang mencolok (contoh: tag merah muda untuk "Belum Bayar Formulir") untuk memudahkan identifikasi status finansial secara visual.</li>
            <li><code>Mengundurkan Diri?</code>: Disediakan <i>dropdown action</i> cepat berwarna hijau bagi admin untuk menandai prospek yang membatalkan pendaftaran, sehingga kebersihan data funnel PMB tetap terjaga.</li>
        </ul>
    </li>
</ul>

<h3>2. Tab "Melengkapi Formulir" (Fase Pemberkasan)</h3>
<p>Setelah calon murid melunasi biaya formulir (sehingga animo terverifikasi), data mereka akan otomatis bermigrasi ke tab <strong>Melengkapi Formulir</strong>.</p>
<ul>
    <li><strong>Tujuan Utama:</strong> Memantau progres pengisian kelengkapan berkas fisik maupun digital, detail biodata calon murid, dan data orang tua/wali.</li>
    <li><strong>Karakteristik Tabel:</strong> 
        <ul>
            <li>Tampilan tabel disesuaikan dengan menghilangkan kolom tagihan formulir dan menggantinya dengan kolom <code>Aksi</code>.</li>
            <li>Kolom <code>Aksi</code> memberikan keleluasaan bagi admin untuk menginspeksi kelengkapan dokumen, melakukan validasi/approval data, atau mengirimkan notifikasi pengingat (<i>reminder</i>) kepada orang tua yang dokumen pendaftarannya belum tuntas.</li>
        </ul>
    </li>
</ul>

<h3>3. Tab "PMB" (Fase Kewajiban Akhir &amp; Daftar Ulang)</h3>
<p>Tab <strong>PMB</strong> merupakan fase pamungkas di mana calon murid yang berkasnya sudah divalidasi dan telah lolos tahapan seleksi diproses untuk menjadi murid resmi.</p>
<ul>
    <li><strong>Tujuan Utama:</strong> Memantau penyelesaian kewajiban finansial akhir, yakni pelunasan Uang Pangkal atau keseluruhan biaya Daftar Ulang (dicantumkan sebagai <i>Uang PMB</i>).</li>
    <li><strong>Karakteristik Tabel:</strong> 
        <ul>
            <li><code>Uang PMB</code>: Menampilkan rekapitulasi besaran biaya pendidikan yang harus dilunasi sebagai syarat daftar ulang.</li>
            <li>Fase ini menjadi <i>gate</i> terakhir sebelum data calon murid secara sistem dinyatakan valid, direlasikan ke dalam master data <strong>Murid</strong>, dan ditempatkan secara definitif ke dalam <strong>Rombongan Belajar (Rombel)</strong>.</li>
        </ul>
    </li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Pendekatan antarmuka dengan tiga tab ini sukses menciptakan <strong>Pipeline Pendaftaran yang transparan layaknya sistem Kanban</strong>. Petugas administrasi PMB tidak perlu berpindah-pindah modul atau halaman untuk mengelola pendaftar dengan status yang berbeda. Selain itu, penggunaan <i>empty state</i> yang rapi (ilustrasi "Data tidak ada") memberikan *feedback* visual yang menenangkan saat antrean di suatu tahapan telah berhasil diselesaikan (<i>zero-inbox approach</i>).</p>
',
                'is_published' => true,
                'order' => 3
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulMasterDataMenuAngsuranArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Master Data Menu Angsuran';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Bergeser meninggalkan blok operasional administrasi, kita kini menukik ke lapisan dasar arsitektur sistem: modul <strong>Master Data</strong>. Menu <strong>Angsuran</strong> (dengan tajuk antarmuka "Tambah Masa Angsuran") adalah representasi ideal dari prinsip aplikasi yang <i>scalable</i> (tangguh &amp; fleksibel). Alih-alih mematok mati (<i>hardcode</i>) opsi cicilan di dalam sistem, <i>developer</i> menyediakan ruang bagi yayasan untuk mendefinisikan sendiri durasi cicilan tersebut dari tahun ke tahun.</p>

<h3>Struktur Antarmuka (UI) Konfigurasi Dasar</h3>
<p>Formulir yang bernaung di level Master Data wajib dirancang dengan tingkat restriksi (<i>strictness</i>) maksimal, karena data di sini akan menjadi fondasi (tulang punggung) bagi menu-menu transaksional di atasnya. UI halaman ini dikemas dengan sangat ketat dan disiplin:</p>
<ul>
    <li><strong>Grid Minimalis (2x2 Layout):</strong> Keempat *field* input diwadahi secara rapi dalam grid dua kolom berukuran paruh-lebar (<i>half-width</i>), meminimalkan pergerakan mata pengguna (*eye-tracking*) saat mengisi <i>form</i> dari kiri-kanan lalu ke bawah.</li>
    <li><strong>Pendekatan Dropdown-Sentris (100% Dropdown UI):</strong> Fitur paling menonjol dari form ini adalah ketiadaan <i>text-box</i> reguler. Keempat <i>field</i> yang ada (<code>Tahun Ajaran</code>, <code>Status</code>, <code>Gelombang</code>, dan <code>Masa Angsuran</code>) diwajibkan menggunakan komponen <i>Dropdown</i>. Dalam hukum desain basis data (<i>database design rule</i>), membiarkan staf mengetik bebas di menu Master Data adalah malapetaka (misal: "6 Bulan", "Enam Bulan", atau "6 Bln"). Pendekatan murni *dropdown* ini mengunci sistem dari ancaman inkonsistensi data (*data anomaly prevention*).</li>
    <li><strong>Keterikatan Kontekstual:</strong> Desain ini secara implisit mengakomodasi kelenturan strategi bisnis. Admin dipaksa menyetel "Masa Angsuran" berdasarkan relasinya dengan "Tahun Ajaran" dan "Gelombang". Ini memungkinkan sekolah menerapkan kebijakan berbeda (misal: pendaftar Gelombang 1 boleh mencicil 10x, namun Gelombang 3 hanya boleh 3x karena sudah mepet waktu masuk sekolah).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Di dalam peta jalan aliran informasi aplikasi, menu <strong>Master Data &gt; Angsuran</strong> menduduki posisi sebagai <strong>"Hulu Regulasi Cicilan"</strong> (<i>The Installment Policy Generator</i>).</p>
<ul>
    <li><strong>Hulu Referensi (Data Consumer):</strong> Untuk bisa berfungsi, halaman ini lebih dulu mengonsumsi <i>master data</i> lain, yakni menyedot referensi <strong>Tahun Ajaran</strong> dari modul Akademik dan daftar <strong>Gelombang Pendaftaran</strong> dari modul Administrasi PMB.</li>
    <li><strong>Hilir Suplai (Data Supplier):</strong> Data yang di-<i>submit</i> di halaman ini (misal: 6 Bulan untuk Gelombang 1) akan diekspor dan seketika muncul sebagai menu pilihan (*dropdown options*) di halaman <strong>Administrasi &gt; Biaya &gt; Pengajuan Angsuran</strong> (halaman operasional yang menangani siswa secara individual). Singkatnya: Jika Master Data ini kosong, staf garis depan tidak akan bisa memproses cicilan apa pun.</li>
    <li><strong>Pengendalian Terpusat (Centralized Control):</strong> Berkat kehadiran menu ini, manajemen sekolah (Kepala Sekolah/Yayasan) memiliki kendali setir seutuhnya atas kebijakan kredit sekolah secara mandiri, tanpa harus bergantung pada *programmer* untuk mengubah opsi aplikasi setiap ganti tahun ajaran.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Formulir "Tambah Masa Angsuran" ini bersinar terang berkat kesederhanaan dan kedisiplinannya. Keputusan *UI Designer* untuk membatasi ruang gerak pengguna dengan menggunakan 100% <i>dropdown field</i> adalah langkah defensif yang brilian guna menjamin integritas <i>database</i> (<i>foolproof design</i>). Secara <i>workflow</i>, menu ini sukses membuktikan bahwa aplikasi <i>Al Azhar Apps</i> dirancang dengan prinsip <i>future-proof</i>—sepenuhnya siap mengakomodasi fluktuasi kebijakan finansial yayasan di masa depan.</p>
',
                'is_published' => true,
                'order' => 27
            ]
        );
    }
}

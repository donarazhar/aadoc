<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuBiayaUangPangkalArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Biaya > Uang Pangkal';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Uang Pangkal</strong> (atau yang kerap direferensikan sebagai DSP - Dana Sumbangan Pendidikan) berada di bawah struktur "Administrasi &gt; Biaya". Halaman ini merupakan pusat pengaturan (<i>master configuration</i>) untuk pos tagihan paling fundamental dan masif di awal masa studi seorang siswa. Desain antarmukanya memamerkan keahlian <i>engineering</i> visual lewat penggunaan tabel bersarang (<i>nested table</i>) demi membedah rincian biaya yang berlapis-lapis.</p>

<h3>Struktur Antarmuka (UI) Rincian Biaya</h3>
<p>Berbeda dengan SPP bulanan yang nominalnya tunggal (<i>flat</i>), tagihan Uang Pangkal secara hakikat adalah gabungan (*bundling*) dari berbagai pos pembiayaan. UI ini mengurai benang kusut kerumitan tersebut dengan fitur <strong>Expandable Rows</strong> (Baris yang dapat dibongkar-muat).</p>
<ul>
    <li><strong>Tabel Induk (Master Data Grid):</strong> Saat halaman dimuat, pengguna disuguhi antarmuka tabel reguler yang rapi, berisi matriks parameter (<code>Tahun Ajaran</code>, <code>Nama Sekolah</code>, <code>Jenjang</code>, <code>Program</code>, <code>Tingkat</code>). Tampilan muka ini menjamin administrator memiliki <i>bird-eye view</i> (pandangan makro) atas kerangka tarif seluruh institusi tanpa terdistraksi angka-angka spesifik.</li>
    <li><strong>Fitur Akordeon (Nested Table):</strong> Keajaiban UX terjadi di kolom <code>Aksi</code>, yang diwakili oleh ikon <i>chevron</i> (panah). Ketika baris diklik, ia akan merekah ke bawah layaknya akordeon, menampilkan sub-tabel <code>Komponen Biaya</code> dan <code>Nominal</code>.
        <ul>
            <li>Sebagai representasi, tagihan untuk tingkat "Toddler" tidak dipukul rata, melainkan dipecah transparan menjadi pos-pos terpisah: <i>Uang Kesehatan, Uang Observasi, Uang Pangkal Murni,</i> dan <i>Uang Psikotest</i>.</li>
            <li><strong>Nilai Tambah Desain:</strong> Pendekatan <i>Progressive Disclosure</i> (pengungkapan informasi secara bertahap) ini menjamin layar tetap leluasa (<i>clean</i>). Angka-angka rincian hanya muncul ketika pengguna secara aktif memintanya, memusnahkan risiko <i>Information Overload</i> (mabuk data).</li>
        </ul>
    </li>
    <li><strong>Peralatan Navigasi:</strong> Sejalan dengan cetak biru modul lainnya, ketersediaan <i>Search Bar</i> dan tombol <code>Filter</code> memastikan kecepatan navigasi data tetap menjadi prioritas utama.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Di dalam ekosistem ERP Sekolah, halaman pengaturan <strong>Uang Pangkal</strong> ini memanggul tanggung jawab sebagai <strong>"Kamus Rincian Tagihan Awal"</strong> (<i>Initial Billing Matrix Dictionary</i>).</p>
<ul>
    <li><strong>Hulu Data (Sumber Referensi):</strong> Sistem menyedot kerangka data akademis (Cabang, Tahun, Jenjang, Program) langsung dari modul <strong>Akademik</strong> dan <strong>Sekolah</strong> untuk mendirikan kerangka penetapan tarif.</li>
    <li><strong>Hilir Data (Integrasi Transaksi):</strong> Ketetapan harga yang terpatri di halaman ini adalah hulu dari pendapatan terbesar sekolah saat masa PMB. Ketika seorang calon murid (di menu <strong>Data Calon Murid</strong>) memasukki fase "Menunggu Pembayaran", mesin keuangan sistem akan melongok ke matriks halaman ini. Ia akan merangkai seluruh pos komponen biaya tersebut menjadi selembar <i>Invoice</i> elektronik komprehensif, yang lantas ditembakkan ke modul <strong>Transaksi &gt; PMB</strong>.</li>
    <li><strong>Transparansi Eksternal:</strong> Rincian komponen inilah yang pada akhirnya akan muncul di layar ponsel (<i>mobile apps</i>) Wali Murid. Oleh karenanya, struktur yang disetel admin di halaman ini berkorelasi mutlak dengan tingkat akuntabilitas dan transparansi institusi di mata orang tua murid.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Penerapan pola antarmuka <i>Nested Table / Accordion</i> pada halaman "Tagihan Uang Pangkal" merupakan penyelesaian elegan atas problem kompleksitas data finansial. Desain ini mumpuni dalam merangkum aneka ragam komponen biaya (seragam, tes, gedung) di balik selubung satu identitas kelas, namun tetap menyediakannya utuh dalam jangkauan satu klik. Dari kacamata *workflow*, menu ini adalah generator penagihan paling vital yang memastikan arus kas awal tahun ajaran (<i>cashflow</i>) sekolah tercatat presisi hingga ke sen terakhir.</p>
',
                'is_published' => true,
                'order' => 23
            ]
        );
    }
}

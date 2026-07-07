<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuBiayaUangSekolahArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Biaya > Uang Sekolah';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Uang Sekolah</strong> (yang secara historis jamak disebut SPP) berada di dalam yurisdiksi "Administrasi &gt; Biaya". Halaman ini merupakan episentrum (<i>configuration hub</i>) untuk menetapkan tarif finansial operasional akademik bulanan/tahunan. Lewat antarmuka "Tambah Biaya SPP", sistem mendemonstrasikan desain yang sangat lugas (<i>straightforward</i>) namun mumpuni untuk menangani logika penetapan harga yang kompleks (<i>multidimensional pricing logic</i>).</p>

<h3>Struktur Antarmuka (UI) Form Penentuan Biaya</h3>
<p>Mengingat halaman ini berurusan dengan penetapan nominal uang yang amat sensitif, perancang UI (<i>UI Designer</i>) mengadopsi pendekatan minimalis (*minimalist approach*) untuk menjamin konsentrasi penuh dari admin keuangan.</p>
<ul>
    <li><strong>Tata Letak Terstruktur (Symmetrical Grid):</strong> Seluruh *field* dibungkus ke dalam *White Card* tunggal dengan formasi <i>grid</i> 2-kolom yang simetris. Format ini mengelompokkan variabel-variabel prasyarat secara horizontal sebelum bermuara ke isian nominal.</li>
    <li><strong>Ketergantungan Multidimensi (Multidimensional Parameters):</strong> Sistem tidak menggunakan skema "satu tarif untuk semua" (<i>flat rate</i>). Antarmuka dengan cerdas memaksa admin mendefinisikan 4 parameter kontekstual terlebih dahulu via komponen <i>Dropdown</i>:
        <ul>
            <li><code>Nama Sekolah</code> (mewakili unit/cabang yayasan)</li>
            <li><code>Tahun Ajaran</code> (mengakomodasi inflasi atau penyesuaian tarif antar tahun)</li>
            <li><code>Tingkat Kelas</code> (contoh: beban biaya kelas 1 berbeda dengan kelas 6)</li>
            <li><code>Program</code> (mewakili peminatan seperti Reguler, Bilingual, atau Tahfidz)</li>
        </ul>
        Mewajibkan penggunaan <i>Dropdown</i> pada empat pilar data ini (ketimbang teks bebas) sukses meredam potensi <i>human error</i> hingga mendekati nol (<i>typo prevention</i>).
    </li>
    <li><strong>Fokus Nominal (The Core Input):</strong> Di baris pamungkas, bertengger sebuah <i>field</i> paruh-lebar (<i>half-width</i>) bernama <code>Uang Sekolah</code>. Kolom ini adalah "gong" atau klimaks dari formulir, di mana admin akhirnya mengisikan angka nominal absolut berdasarkan empat kriteria yang telah disetel di atasnya.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Bila ditinjau dari arsitektur bisnis (<i>business workflow</i>) sistem ERP, halaman pengaturan <strong>Biaya Uang Sekolah</strong> bertindak sebagai <strong>"Fondasi Otomatisasi Penagihan"</strong> (<i>Billing Automation Foundation</i>).</p>
<ul>
    <li><strong>Hulu Referensi (Reference Data Fetching):</strong> Halaman ini murni bertindak sebagai konsumen (<i>consumer</i>) dari <i>master data</i>. Ia menarik daftar unit sekolah, tahun kalender, dan struktur program dari modul <strong>Akademik</strong> dan <strong>Sekolah</strong>.</li>
    <li><strong>Hilir Eksekusi (Automation Trigger):</strong> Nominal yang disimpan dari halaman ini tidak berakhir membeku di *database*. Data tarif (*Tariff Dictionary*) ini adalah bahan bakar utama bagi mesin penagihan. Begitu profil seorang anak "Sah/Lulus" dari <i>pipeline</i> PMB (modul <strong>Administrasi</strong>) dan beralih menjadi murid aktif (modul <strong>Data Murid</strong>), mesin tagihan (<i>Auto-Billing Engine</i>) akan menyilang-cocokkan profil anak tersebut dengan kamus tarif ini. Hasilnya: sistem dapat otomatis menerbitkan <i>invoice</i> bulanan ke aplikasi Wali Murid (<i>mobile apps</i>) atau modul <strong>Transaksi</strong> secara masif tanpa perlu campur tangan manual kasir.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Antarmuka halaman "Tambah Biaya SPP" membuktikan tesis bahwa antarmuka <i>backend</i> untuk penyusunan algoritma finansial tidak harus terlihat ruwet layaknya <i>spreadsheet</i>. Melalui pembagian sekat yang jelas antara 4 variabel penentu logika (lewat *dropdown*) dan 1 variabel nominal absolut (lewat *text input*), sistem berhasil menuntun administrator untuk mensimulasikan matriks tagihan SPP sekolah tanpa takut salah kamar, salah kelas, maupun salah angkatan.</p>
',
                'is_published' => true,
                'order' => 22
            ]
        );
    }
}

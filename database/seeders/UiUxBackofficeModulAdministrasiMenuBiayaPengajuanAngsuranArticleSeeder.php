<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuBiayaPengajuanAngsuranArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Biaya > Pengajuan Angsuran';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Pengajuan Angsuran</strong> yang menjadi penutup pada blok "Administrasi &gt; Biaya" merupakan fasilitas strategis untuk memberikan kelonggaran finansial (<i>financial relief</i>) kepada orang tua murid. Halaman "Tambah Murid Angsuran Uang Pangkal" ini mempertontonkan filosofi desain minimalis ekstrem, di mana antarmuka sangat ringkas karena sistem mendelegasikan kerumitan kalkulasi sepenuhnya ke mesin belakang (*backend automation*).</p>

<h3>Struktur Antarmuka (UI) Form Angsuran</h3>
<p>Merestrukturisasi tagihan besar (seperti Uang Pangkal) menjadi cicilan adalah proses yang rawan salah hitung. Untuk meminimalisasi risiko tersebut, UI dirancang untuk hanya meminta parameter yang paling absolut:</p>
<ul>
    <li><strong>Pencarian Cerdas (Smart Search Input):</strong> Baris pertama formulir merentang penuh (100% <i>width</i>) untuk mengakomodasi <i>field</i> <code>Nama Murid</code>. Keunggulannya terletak pada kapabilitas <i>dual-search</i>: admin bebas mengetikkan Nama Lengkap ataupun NIS (Nomor Induk Siswa). Dukungan <i>dropdown</i> cerdas ini memastikan presisi 100%, menghindarkan admin dari malapetaka salah memilih siswa yang kebetulan bernama mirip.</li>
    <li><strong>Auto-Fill &amp; Validasi Visual:</strong> Tepat di baris kedua, tersaji kolom <code>Jenjang</code> dan <code>Tujuan Sekolah</code>. Dalam *best-practice* UX, kedua *field* ini didesain sebagai kolom <i>read-only</i> yang akan terisi otomatis (<i>auto-populate</i>) begitu identitas anak di atasnya dipilih. Ini bertindak sebagai mekanisme <i>Error Prevention</i> visual, mengonfirmasi kepada admin bahwa ia sedang memproses data anak yang tepat di cabang sekolah yang benar.</li>
    <li><strong>Parameter Kebijakan (The Core Variable):</strong> Variabel pemungkas di halaman ini hanyalah <i>dropdown</i> <code>Masa Angsuran</code> (misal: opsi 3 kali, 6 kali, atau 12 bulan). Sangat krusial untuk dicatat bahwa <strong>tidak ada kolom untuk mengetikkan nominal rupiah</strong>. Angka cicilan tabu untuk diketik manual oleh manusia; ia harus dikomputasi oleh algoritma sistem demi menjamin akurasi neraca akuntansi (<i>accounting accuracy</i>).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Dalam konstelasi arsitektur pembayaran (<i>Billing Architecture</i>), menu <strong>Pengajuan Angsuran</strong> memanggul peran sebagai <strong>"Restrukturisator Tagihan"</strong> (<i>Invoice Restructuring Engine</i>).</p>
<ul>
    <li><strong>Hulu Data (Cross-Module Dependency):</strong> Halaman ini adalah murni konsumen data. Ia menyedot identitas murid dari <strong>Modul PMB / Data Murid</strong>, serta menarik opsi durasi termin cicilan langsung dari menu <strong>Master Data &gt; Angsuran</strong> (terlihat di navigasi <i>sidebar</i> bagian bawah).</li>
    <li><strong>Hilir Data (Invoice Splitting Execution):</strong> Momentum ajaib (*system magic*) terjadi seketika tombol "Simpan" ditekan. Mesin ERP akan mencari tagihan *Grand Total* Uang Pangkal anak tersebut, lalu memutilasi (<i>splitting</i>) tagihan raksasa itu menjadi beberapa <i>invoice</i> anakan (<i>child invoices</i>) dengan proporsi nilai yang rata, sesuai dengan termin "Masa Angsuran" yang dipilih.</li>
    <li><strong>Injeksi ke Transaksi:</strong> Deretan <i>invoice</i> cicilan yang baru saja di-<i>generate</i> ini kemudian akan disuntikkan (*injected*) ke dalam <i>pipeline</i> modul <strong>Transaksi</strong>, lengkap dengan tangga jatuh temponya masing-masing (misal: Cicilan 1 ditagih Agustus, Cicilan 2 ditagih September, dst). Seluruh rentetan rincian ini akan langsung tercermin secara *real-time* di layar aplikasi *mobile* orang tua murid.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Halaman "Pengajuan Angsuran" adalah monumen keberhasilan desain dalam menyederhanakan fungsi bisnis yang pelik (restrukturisasi piutang). Hanya bermodalkan fitur pencari nama dan satu <i>dropdown</i> termin cicilan, desainer sistem sukses melucuti seluruh beban kalkulasi matematis dari pundak staf keuangan. Dari kacamata operasional, menu ini menjembatani dengan sempurna antara kebijakan empati sekolah terhadap wali murid dengan ketertiban pencatatan piutang (<i>account receivable</i>) pada sistem akuntansi yayasan.</p>
',
                'is_published' => true,
                'order' => 26
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuBiayaUangDaftarUlangArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Biaya > Uang Daftar Ulang';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Uang Daftar Ulang</strong> yang bernaung di bawah klaster "Administrasi &gt; Biaya" merupakan <i>formulation hub</i> (pusat formulasi) untuk menetapkan tagihan rutin tahunan. Biaya ini umumnya dibebankan kepada siswa aktif (<i>existing students</i>) pada momentum pergantian tahun ajaran. Antarmuka "Tambah Biaya Daftar Ulang" ini secara gamblang mendemonstrasikan keunggulan UX berupa penerapan <strong>Dynamic Form Fields</strong> (kolom formulir dinamis) dan komputasi penjumlahan <i>real-time</i>.</p>

<h3>Struktur Antarmuka (UI) Form Penentuan Biaya</h3>
<p>Dalam praktiknya di lapangan, tagihan Daftar Ulang jarang sekali berupa satu pos pembayaran tunggal; ia lumrahnya diracik dari paket bundel (*bundling*) yang berisi biaya buku, ekstrakurikuler tahunan, kegiatan OSIS, dan lain-lain. Desain UI ini mewadahi kerumitan tersebut dengan sangat elegan:</p>
<ul>
    <li><strong>Parameter Konteks (Top Section):</strong> Paruh atas formulir memanfaatkan format <i>grid</i> 2-kolom standar untuk mendefinisikan prasyarat wajib: <code>Tahun Ajaran</code>, <code>Tingkat Kelas</code>, dan <code>Program</code>. Penambahan <i>field</i> kalender <code>Tanggal Jatuh Tempo</code> berfungsi mematok tenggat waktu (<i>deadline</i>) pembayaran universal untuk angkatan tersebut.</li>
    <li><strong>Injeksi Komponen Dinamis (Dynamic Repeater):</strong> Di sinilah letak kejeniusan arsitektur desainnya. Alih-alih menyediakan 10 baris <i>input</i> kosong yang membuat halaman terlihat panjang dan kumuh, UI hanya menampilkan satu baris awal berupa <code>Komponen Biaya</code> (<i>dropdown</i>) dan <code>Nominal</code> (teks). Apabila panitia keuangan butuh menambahkan *item* tagihan ekstra (misal: Buku Paket), mereka cukup menekan tombol biru <code>+ Tambah Komponen Biaya</code>. Berkat dukungan <i>scripting</i> sisi klien, baris input baru akan digandakan (<i>cloned</i>) ke bawah tanpa *loading* halaman sama sekali.</li>
    <li><strong>Kalkulator Waktu Nyata (Real-time Summary Box):</strong> Persis di bawah jejeran <i>input</i> komponen, tersemat sebuah kotak <i>highlight</i> berwarna biru muda bertuliskan <strong>Total Biaya Daftar Ulang</strong>. Secara otomatis (*auto-calculate*), sistem akan mengakumulasikan nominal yang sedang diketik oleh admin di atasnya dan menampilkannya seketika (<i>real-time</i>). Fitur UX ini secara harfiah memusnahkan kebutuhan staf untuk menggunakan alat hitung manual, menyapu bersih risiko salah rekap (<i>calculation error</i>).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Jika diletakkan dalam konstelasi arsitektur <i>workflow</i> ERP, menu <strong>Uang Daftar Ulang</strong> ini bertindak layaknya <strong>"Kamus Tagihan Transisi"</strong> (<i>Transitional Billing Dictionary</i>).</p>
<ul>
    <li><strong>Hulu Data (Reference Fetching):</strong> Layaknya menu konfigurasi lain, ia menelan data hierarki dari modul Akademik (Kelas &amp; Program) serta memanggil tabel master *Komponen Biaya* untuk mengisi opsi-opsi *dropdown* yang ada.</li>
    <li><strong>Hilir Data (Mass Invoice Generation):</strong> Matriks tagihan yang disimpan di sini ibarat fondasi yang disiapkan untuk akhir tahun ajaran. Pemicunya (<i>trigger</i>) baru akan bereaksi ketika kepala sekolah mengeksekusi menu <strong>Akademik &gt; Kenaikan Kelas &amp; Kelulusan</strong>. Begitu siswa di-<i>upgrade</i> ke tingkat kelas berikutnya, mesin otomatisasi (<i>cron job / system event</i>) akan melirik kamus biaya di halaman ini. Hasilnya: sistem memproduksi dan mendistribusikan ratusan <i>Invoice</i> Daftar Ulang secara serentak ke dasbor <strong>Transaksi</strong> masing-masing orang tua murid, menagih hak sekolah tepat waktu tanpa intervensi manual sama sekali.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Antarmuka halaman "Tambah Biaya Daftar Ulang" adalah representasi paripurna mengenai cara desain meringankan beban kognitif operator (<i>reducing cognitive load</i>). Lewat perpaduan <i>Dynamic Form Repeater</i> (tombol + Tambah) dan kalkulator tertanam (<i>Auto-Sum Summary</i>), desainer menjamin bahwa tim keuangan sekolah sanggup meracik paket tagihan serumit dan sepanjang apa pun dengan akurasi matematis 100%. Secara fungsional, menu ini adalah urat nadi yang menjamin tidak terjadinya kemacetan arus kas (<i>cashflow</i>) di masa transisi kalender pendidikan.</p>
',
                'is_published' => true,
                'order' => 24
            ]
        );
    }
}

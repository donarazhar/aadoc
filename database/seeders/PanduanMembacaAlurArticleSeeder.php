<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class PanduanMembacaAlurArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori Backoffice Al Azhar Apps ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Backoffice Al Azhar Apps')],
            ['name' => 'Backoffice Al Azhar Apps', 'description' => 'Artikel tentang sistem backoffice Al Azhar Apps', 'order' => 1]
        );

        $title = 'Workflow Aplikasi Al Azhar Apps — Versi Final (Gabungan & Terkoreksi)';
        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Membaca Alur (Flow) Utama Diagram')], // Tetap gunakan slug lama agar me-replace dokumen yang sudah ada
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Berikut alur yang sudah disesuaikan dengan tampilan UI yang sebenarnya, dijelaskan selangkah demi selangkah dengan bahasa sederhana.</p>
<hr>

<h3>A. Alur PMB (Penerimaan Murid Baru)</h3>
<p>Bayangkan ini seperti <strong>funnel/corong</strong> — dari banyak pendaftar, hanya yang lolos &amp; bayar yang akhirnya jadi murid resmi.</p>

<p><strong>1. Sekolah menyiapkan "pintu masuk" (Gelombang Pendaftaran)</strong><br>
Admin membuat <code>GELOMBANG_PMB</code> — semacam periode pendaftaran (misal "Gelombang 1 Tahun Ajaran 2026/2027"). Ini terhubung ke <code>SEKOLAH</code> dan <code>TAHUN_AJARAN</code> mana yang dituju, plus target jumlah siswa dan tanggal buka-tutup.</p>

<p><strong>2. Calon murid daftar (status: Animo)</strong><br>
Orang tua mendaftarkan anaknya &rarr; masuk ke tabel <code>CALON_MURID</code> dengan status awal <strong>Animo</strong>. Mereka pilih jenjang &amp; <code>PROGRAM</code> (misal Reguler/Bilingual).</p>

<p><strong>3. Bayar Uang Formulir dulu (gerbang pertama)</strong> &#11088; <em>ini yang sebelumnya terlewat</em><br>
Sebelum lanjut ke ujian, calon murid harus bayar <strong>Uang Formulir</strong>. Statusnya bergerak:<br>
<code>Belum Bayar Formulir &rarr; Melengkapi Formulir</code><br>
Kalau belum bayar, mereka "macet" di tahap ini dan tidak bisa lanjut ujian.</p>

<p><strong>4. Ikut ujian seleksi</strong><br>
Setelah formulir lunas, admin memasukkan mereka ke <code>JADWAL_UJIAN</code> (buat jadwal, ruangan, tipe ujian) &rarr; mereka jadi <code>PESERTA_UJIAN</code>.</p>

<p><strong>5. Hasil ujian &amp; bayar Uang Pangkal (gerbang kedua)</strong> &#11088; <em>ini juga bagian yang dikoreksi</em><br>
Nilai diinput &rarr; kalau lulus, statusnya:<br>
<code>Waiting List &rarr; Menunggu Pembayaran DSP (Uang Pangkal) &rarr; Terdaftar</code><br>
Jadi ada <strong>2 kali bayar</strong> sebelum resmi jadi murid: Uang Formulir (di awal) dan Uang Pangkal/DSP (setelah lulus ujian).</p>

<p><strong>6. Resmi jadi Murid</strong><br>
Setelah status "Terdaftar" dan lunas semua, sistem membuat record baru di tabel <code>MURID</code> dan langsung ditempatkan ke sebuah <code>ROMBEL</code>.</p>

<blockquote><strong>Intinya:</strong> Calon murid harus lolos 2 filter — bayar formulir, lalu bayar uang pangkal — baru resmi jadi "Murid" yang tercatat di sistem akademik.</blockquote>
<hr>

<h3>B. Alur Akademik (Pengelolaan Kelas)</h3>

<p><strong>1. Siapkan "ruang" dan "kelas" (Rombel)</strong><br>
Sebelum tahun ajaran mulai, admin membuat <code>ROMBEL</code> (misal "TK B - Rombel A"). Satu Rombel butuh <strong>5 informasi</strong>, bukan cuma 3:<br>
- <code>TAHUN_AJARAN</code> — Rombel ini untuk tahun ajaran berapa<br>
- <code>TINGKAT_KELAS</code> — misal TK A, TK B<br>
- <code>RUANGAN</code> — fisik ruang kelasnya di mana &#11088; <em>tambahan</em><br>
- <code>PROGRAM</code> — Reguler/Bilingual dsb &#11088; <em>tambahan</em><br>
- <code>PEGAWAI</code> — siapa Wali Kelasnya</p>

<p><strong>2. Isi Rombel dengan murid</strong><br>
Murid (baik yang baru lulus PMB, atau murid lama naik kelas) dimasukkan ke dalam Rombel tersebut sesuai program &amp; tingkat kelasnya.</p>

<p><strong>3. Di akhir tahun ajaran — dua kemungkinan jalan</strong><br>
Fitur "Kenaikan Kelas &amp; Kelulusan" punya <strong>dua cabang</strong>, bukan cuma satu:</p>
<ul>
<li><strong>Cabang Naik Kelas</strong> (untuk murid yang belum tingkat akhir):<br>
Sistem update <code>rombel_id</code> murid ke Rombel di tingkat lebih tinggi, untuk <code>TAHUN_AJARAN</code> berikutnya.</li>
<li><strong>Cabang Lulus</strong> &#11088; <em>tambahan yang sebelumnya belum masuk</em> (untuk murid tingkat akhir):<br>
Murid tidak "naik kelas" lagi, tapi statusnya jadi <strong>Lulus</strong> &rarr; nanti datanya muncul di modul <code>IJAZAH</code> untuk dicetak.</li>
</ul>

<p>Ada juga tombol <strong>Batalkan</strong> — kalau admin salah proses, murid bisa dikembalikan dari status "Sudah Diproses" ke "Belum Diproses" sebelum ditekan <strong>Submit</strong> (final).</p>

<blockquote><strong>Intinya:</strong> Rombel itu seperti "kotak" yang butuh 5 komponen (tahun ajaran, tingkat, ruangan, program, wali kelas). Dan di akhir tahun, murid punya 2 nasib: pindah ke rombel yang lebih tinggi, atau lulus dan keluar dari sistem akademik (tapi tetap punya data historis untuk ijazah).</blockquote>
<hr>

<h3>C. Alur Keuangan &amp; Diskon</h3>

<p>Ini bagian yang paling penting dikoreksi: <strong>jangan campur tagihan Calon Murid dengan tagihan Murid aktif</strong> — keduanya beda level.</p>

<p><strong>1. Dua sumber tagihan yang berbeda</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
<thead>
<tr><th>Siapa yang ditagih</th><th>Jenis Tagihan</th><th>Kapan</th></tr>
</thead>
<tbody>
<tr><td><code>CALON_MURID</code> (belum resmi murid)</td><td>Uang Formulir, Uang Pangkal (DSP)</td><td>Selama proses PMB</td></tr>
<tr><td><code>MURID</code> (sudah resmi &amp; aktif)</td><td>SPP bulanan (Uang Sekolah), Uang Daftar Ulang</td><td>Setiap bulan / setiap awal tahun ajaran</td></tr>
</tbody>
</table>

<p>Jadi alurnya: Calon Murid dulu ditagih formulir &amp; pangkal &rarr; begitu resmi jadi Murid &rarr; baru ditagih SPP bulanan dan (di tahun berikutnya) Uang Daftar Ulang.</p>

<p><strong>2. Pengajuan Diskon (khusus untuk Murid aktif)</strong><br>
Kalau seorang murid punya kriteria tertentu, admin ajukan diskon lewat 6 kategori:<br>
- Prestasi Kejuaraan<br>
- Prestasi Rapot<br>
- Hafalan Al-Quran<br>
- Saudara Kandung<br>
- Anak Pegawai<br>
- Lulusan YPIA</p>

<p>Setiap pengajuan butuh minimal 1 dokumen bukti (sertifikat, KK, dll), dan tersimpan di tabel <code>DISKON</code> yang terhubung langsung ke <code>MURID</code>.</p>

<p><strong>3. Kalkulasi tagihan akhir</strong><br>
Saat tagihan (SPP/Daftar Ulang) mau ditampilkan ke orang tua:</p>
<pre>Tagihan Akhir = Nominal Dasar - Potongan Diskon (jika ada)</pre>
<p>Setiap tagihan dilengkapi <strong>Virtual Account (VA)</strong> dan <strong>No. Reference</strong>, supaya sistem otomatis tahu status: <strong>Lunas</strong> atau <strong>Piutang/Tunggakan</strong> — ini yang muncul di Dashboard Summary ("Total Piutang &amp; Tunggakan").</p>

<blockquote><strong>Intinya:</strong> Ada 2 "kasir" berbeda dalam sistem — kasir untuk Calon Murid (formulir + pangkal) dan kasir untuk Murid aktif (SPP + daftar ulang). Diskon hanya berlaku untuk kasir Murid aktif, dan semua pembayaran dilacak otomatis lewat VA.</blockquote>
<hr>

<h3>Peta Besar: Bagaimana Ketiga Alur Ini Saling Terhubung</h3>

<pre>
[PMB] Calon Murid daftar
   &rarr; bayar Formulir
   &rarr; ikut Ujian
   &rarr; Lulus + bayar Uang Pangkal
   &rarr; jadi MURID resmi
        &darr;
[Akademik] Murid ditempatkan di ROMBEL
   &rarr; belajar 1 tahun ajaran
   &rarr; akhir tahun: Naik Kelas (pindah rombel) ATAU Lulus (jadi Ijazah)
        &darr;
[Keuangan] Selama jadi Murid aktif:
   &rarr; ditagih SPP bulanan + Daftar Ulang tahunan
   &rarr; bisa dapat Diskon (potong tagihan)
   &rarr; bayar via VA &rarr; status Lunas/Piutang terpantau di Dashboard
</pre>

<p>Dengan koreksi ini, workflow sudah <strong>90% tepat</strong> — hanya perlu memperjelas bahwa ada 2 gerbang pembayaran di PMB, 2 relasi tambahan di Rombel, dan pemisahan tagihan Calon Murid vs Murid aktif di modul Keuangan.</p>
',
                'is_published' => true,
                'order' => 3
            ]
        );
    }
}

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
<p>Bayangkan ini seperti <strong>funnel/corong</strong> — dari banyak pendaftar, hanya yang lolos &amp; bayar yang akhirnya jadi murid resmi. Ada dua kemungkinan jalur pembayaran: <strong>Tanpa Cicilan (Reguler)</strong> dan <strong>Dengan Cicilan</strong>. Kedua jalur ini sama persis di awal, dan baru bercabang setelah calon murid dinyatakan lulus ujian.</p>

<h4>A.1 Tahap Persiapan (dilakukan Backoffice/Sekolah)</h4>
<p><strong>1. Setting komponen biaya &amp; Gelombang Pendaftaran</strong><br>
Sebelum pendaftaran dibuka, tim Backoffice sekolah menyiapkan dua hal di sistem:</p>
<ul>
<li>Komponen <strong>Uang Pangkal</strong> dan <strong>Uang Sekolah (SPP)</strong> beserta rinciannya.</li>
<li><code>GELOMBANG_PMB</code> — periode pendaftaran (tanggal buka/tutup) per jenjang dan <code>TAHUN_AJARAN</code>.</li>
</ul>

<h4>A.2 Tahap Pendaftaran Awal (dilakukan Orang Tua/Murid — OTM)</h4>
<p><strong>2. Calon murid daftar (status: Animo)</strong><br>
Orang tua melakukan pendaftaran awal melalui aplikasi &rarr; data masuk ke tabel <code>CALON_MURID</code> dengan status awal <strong>Animo</strong>.</p>

<p><strong>3. Bayar Uang Formulir (gerbang pertama)</strong><br>
Sebelum lanjut ke tahap berikutnya, calon murid wajib membayar <strong>Uang Formulir</strong> melalui menu Tagihan di aplikasi (metode QRIS atau lainnya). Kalau belum bayar, status akan "macet" di sini dan tidak bisa lanjut.</p>

<p><strong>4. Lengkapi Identitas</strong><br>
Setelah formulir lunas, OTM melengkapi data <strong>Asal Sekolah</strong> dan <strong>Profil Murid</strong> secara menyeluruh, lalu mengajukan data tersebut untuk diverifikasi sekolah.</p>

<h4 style="color:#1885C4;">A.3 Tahap Ujian Masuk</h4>
<p><strong>5. Sekolah mengirimkan Kartu Ujian</strong><br>
Setelah data disetujui, Backoffice mengirimkan <strong>Kartu Ujian</strong> ke akun OTM.</p>

<p><strong>6. OTM mendapatkan kartu &amp; anak mengikuti ujian</strong><br>
OTM mengunduh Kartu Peserta Ujian dari aplikasi (wajib ditunjukkan saat ujian berlangsung), lalu anak mengikuti tes sesuai jadwal.</p>

<h4>A.4 Tahap Penilaian &amp; Pengumuman Kelulusan (dilakukan Backoffice)</h4>
<p><strong>7. Input &amp; Upload Nilai</strong><br>
Tim Backoffice men-download template nilai, mengisi hasil ujian sesuai format, lalu mengunggah (upload) nilai tersebut ke sistem.</p>

<p><strong>8. Meluluskan &amp; Mengirim Notifikasi</strong><br>
Calon murid yang memenuhi syarat diluluskan (submit kelulusan) di sistem, lalu notifikasi kelulusan otomatis dikirim ke OTM.</p>

<blockquote>Di titik inilah alur mulai <strong>bercabang menjadi dua jalur</strong>, tergantung skema pembayaran Uang Pangkal yang dipilih OTM: <strong>Tanpa Cicilan</strong> atau <strong>Dengan Cicilan</strong>.</blockquote>

<h4 style="color:#22c55e;">A.5.a Jalur Tanpa Cicilan — Pembayaran Uang Pangkal (Gerbang Kedua)</h4>
<p><strong>9. Terima notifikasi &amp; syarat ketentuan UP</strong><br>
OTM menerima notifikasi lulus ujian sekaligus notifikasi syarat &amp; ketentuan Uang Pangkal (UP). OTM membuka menu tersebut untuk melihat komponen biaya UP, lalu menekan <strong>Setuju</strong> dan menerima file PDF rincian biaya.</p>

<p><strong>10. Bayar Uang Pangkal secara penuh</strong><br>
Tagihan UP muncul di menu Tagihan aplikasi. OTM membayar komponen UP secara <strong>lunas sekaligus</strong>.</p>

<p><strong>11. Status berubah menjadi Aktif</strong><br>
Setelah pembayaran terkonfirmasi, sistem membuat record baru di tabel <code>MURID</code> dengan status <strong>Aktif</strong>, dan siswa resmi terdaftar.</p>

<h4 style="color:#7c3aed;">A.5.b Jalur Dengan Cicilan — Pengajuan Angsuran Uang Pangkal</h4>
<p><strong>9. Terima notifikasi, baca syarat, lalu ajukan cicilan langsung ke sekolah</strong><br>
Sama seperti jalur reguler, OTM menerima notifikasi syarat &amp; ketentuan UP dan menekan Setuju. Namun jika OTM ingin mencicil, OTM harus <strong>datang langsung ke sekolah (Tata Usaha)</strong> untuk mengajukan permohonan skema angsuran — proses ini dilakukan secara luring/tatap muka, bukan melalui aplikasi.</p>

<p><strong>10. Persetujuan angsuran</strong><br>
Tim Backoffice sekolah memproses permohonan sesuai ketentuan jumlah angsuran yang ditetapkan Yayasan. <strong>Jika permohonan lebih dari 3 kali angsuran</strong>, permohonan diteruskan ke <strong>Direktorat Keuangan</strong> untuk mendapat persetujuan (approval) khusus sebelum skema cicilan berlaku.</p>

<p><strong>11. Pembayaran bertahap (minimal 50% di termin pertama)</strong><br>
Setelah disetujui, tagihan UP muncul di menu Tagihan sudah disesuaikan dengan jadwal cicilan. <blockquote style="border-left-color:#eab308; background:#fef9c3;"><strong>Ketentuan penting:</strong> status anak baru diproses <strong>Aktif</strong> apabila pembayaran termin pertama sudah mencapai minimal <strong>50% dari total Uang Pangkal</strong>.</blockquote></p>

<p><strong>12. Status Aktif &amp; penempatan Rombel</strong><br>
Setelah syarat 50% terpenuhi, siswa berstatus Aktif dan Tata Usaha menempatkan siswa ke <code>ROMBEL</code> yang sesuai — sama seperti jalur reguler, hanya pelunasan sisa UP dilakukan bertahap sesuai akad yang disetujui.</p>

<blockquote><strong>Intinya:</strong> Kedua jalur PMB sama-sama melewati 2 gerbang pembayaran — Uang Formulir (di awal) dan Uang Pangkal (setelah lulus ujian). Bedanya hanya pada <em>cara</em> membayar gerbang kedua: <strong>lunas sekaligus</strong> (jalur reguler, langsung via aplikasi) atau <strong>bertahap</strong> (jalur cicilan, butuh pengajuan tatap muka ke sekolah dan minimal 50% di termin pertama untuk aktivasi).</blockquote>
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
Murid (baik yang baru lulus PMB — dari jalur reguler maupun cicilan, atau murid lama naik kelas) dimasukkan ke dalam Rombel tersebut sesuai program &amp; tingkat kelasnya.</p>

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
<tr><td><code>CALON_MURID</code> (belum resmi murid)</td><td>Uang Formulir, Uang Pangkal (DSP) — lunas sekaligus atau bertahap (cicilan)</td><td>Selama proses PMB</td></tr>
<tr><td><code>MURID</code> (sudah resmi &amp; aktif)</td><td>SPP bulanan (Uang Sekolah), Uang Daftar Ulang</td><td>Setiap bulan / setiap awal tahun ajaran</td></tr>
</tbody>
</table>

<p>Jadi alurnya: Calon Murid dulu ditagih formulir &amp; pangkal (baik lunas maupun cicilan) &rarr; begitu resmi jadi Murid Aktif &rarr; baru ditagih SPP bulanan dan (di tahun berikutnya) Uang Daftar Ulang.</p>

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

<blockquote><strong>Intinya:</strong> Ada 2 "kasir" berbeda dalam sistem — kasir untuk Calon Murid (formulir + pangkal, lunas atau cicilan) dan kasir untuk Murid aktif (SPP + daftar ulang). Diskon hanya berlaku untuk kasir Murid aktif, dan semua pembayaran dilacak otomatis lewat VA.</blockquote>
<hr>

<h3>Peta Besar: Bagaimana Ketiga Alur Ini Saling Terhubung</h3>

<pre>
[PMB] Calon Murid daftar
   &rarr; bayar Formulir
   &rarr; ikut Ujian
   &rarr; Lulus, lalu pilih skema Uang Pangkal:
        (a) Lunas sekaligus via aplikasi, ATAU
        (b) Cicilan: ajukan ke sekolah &rarr; approval (+Direktorat Keuangan jika >3x) &rarr; bayar min. 50% termin pertama
   &rarr; jadi MURID resmi (Aktif) &amp; ditempatkan ke ROMBEL
        &darr;
[Akademik] Murid belajar 1 tahun ajaran
   &rarr; akhir tahun: Naik Kelas (pindah rombel) ATAU Lulus (jadi Ijazah)
        &darr;
[Keuangan] Selama jadi Murid aktif:
   &rarr; ditagih SPP bulanan + Daftar Ulang tahunan
   &rarr; bisa dapat Diskon (potong tagihan)
   &rarr; bayar via VA &rarr; status Lunas/Piutang terpantau di Dashboard
</pre>

<p>Dengan koreksi ini, workflow sudah mencakup detail penting yang sebelumnya belum terlihat: adanya <strong>2 skema pembayaran Uang Pangkal</strong> (lunas vs cicilan) yang menentukan kapan status calon murid resmi berubah menjadi Aktif, lengkap dengan mekanisme approval berjenjang untuk pengajuan cicilan lebih dari 3 kali angsuran.</p>
',
                'is_published' => true,
                'order' => 3
            ]
        );
    }
}
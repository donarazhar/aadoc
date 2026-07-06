<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulSekolahMenuSarprasArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Sekolah Menu Sarana Prasarana';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Sarana Prasarana (Sarpras)</strong> dalam cakupan modul "Sekolah" berperan sebagai buku inventaris digital untuk merekam berbagai aset fisik dan fasilitas ruangan yang dikelola oleh unit sekolah terkait. Tangkapan layar dari halaman "Tambah Sarana Prasarana" ini memamerkan antarmuka formulir yang berfokus pada spesifikasi dimensi teknis.</p>

<h3>Struktur Formulir Sarpras</h3>
<p>Halaman ini dikemas dengan sangat ringkas dan rapi, mengandalkan satu panel (*Card*) utama putih sebagai area pengisian (*data entry*), yang ditutup dengan panel aksi terpisah di bagian paling bawah layar.</p>

<h4>1. Tata Letak Grid Dua Kolom (Two-Column Layout)</h4>
<p>Demi menjaga agar formulir tidak memakan terlalu banyak ruang vertikal (menghindari perlunya <i>scrolling</i> panjang), kolom-kolom isian disusun memadat dalam format <i>grid</i> dua kolom:</p>
<ul>
    <li><strong>Kategori &amp; Nomenklatur:</strong> <i>Field</i> <code>Jenis Sarana Prasarana</code> memanfaatkan komponen <i>dropdown</i> untuk mengontrol konsistensi klasifikasi data secara global (misal: Ruang Kelas, Laboratorium, Lapangan, Toilet). Sedangkan untuk pengisian <code>Nama</code>, sistem memberikan kebebasan teks (*text input*) agar aset dapat diberi identitas unik (contoh: "Lab Komputer Lantai 2").</li>
    <li><strong>Spesifikasi Dimensi:</strong> Terdapat kolom input <code>Ukuran Panjang (Meter)</code> dan <code>Ukuran Lebar (Meter)</code>. Menyertakan informasi satuan ukur "(Meter)" langsung pada teks label adalah praktik <strong>Microcopy</strong> yang brilian dalam UI/UX. Strategi ini secara instan menghapus ambiguitas (menjawab keraguan *user*: <i>"Ini diisi dalam sentimeter atau meter?"</i>) dan membersihkan data dari format penulisan <i>string</i> campuran.</li>
    <li><strong>Daya Tampung:</strong> <i>Field</i> penutup di sebelah kiri bawah adalah <code>Kapasitas</code>. Kolom ini krusial untuk mencatat batas beban maksimal suatu ruangan (misal: kapasitas 30 siswa untuk satu ruang kelas), yang nantinya akan saling bersilangan (*cross-reference*) dengan logika pada menu pembagian rombongan belajar (Rombel).</li>
</ul>

<h4>2. Panel Aksi Independen (Action Bar)</h4>
<p>Selaras dengan pola desain (<i>design language</i>) di seluruh sistem <i>Backoffice</i>, area eksekusi dipisahkan pada satu blok khusus:</p>
<ul>
    <li>Tombol sekunder <strong>"Batalkan"</strong> disajikan dengan kontras rendah (garis tepi abu-abu) sebagai opsi jalan keluar yang tidak mengganggu.</li>
    <li>Tombol primer <strong>"Simpan"</strong> tampil dominan (warna biru pekat dengan ikon pelengkap) di ujung paling kanan bawah, menegaskan arah akhir penyelesaian tugas.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Meskipun jumlah kolom inputnya sedikit, antarmuka "Tambah Sarana Prasarana" ini berhasil mencapai tingkat efisiensi yang sangat tinggi berkat <strong>Kejelasan Konteks (Contextual Clarity)</strong>. Penggunaan label penjelas untuk satuan metrik (Meter) adalah perwujudan dari <i>Error Prevention</i> yang sangat ampuh. Dikombinasikan dengan tata letak visual 2-kolom yang bernapas lega, petugas tata usaha (*admin*) dipastikan mampu mendigitalkan puluhan aset fisik sekolah dengan tingkat kesalahan yang nyaris nol.</p>
',
                'is_published' => true,
                'order' => 13
            ]
        );
    }
}

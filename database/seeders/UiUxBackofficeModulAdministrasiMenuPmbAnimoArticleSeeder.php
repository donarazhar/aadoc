<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuPmbAnimoArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu PMB > Animo';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Animo</strong> yang bernaung di bawah payung "Administrasi &gt; PMB" bertindak sebagai jaring penangkap pertama (<i>frontline lead capture</i>) dalam siklus penerimaan murid baru. Antarmuka halaman "Tambah Animo PMB" ini didesain khusus agar para petugas <i>front office</i> atau tata usaha dapat melayani calon pendaftar dengan sangat cekatan tanpa rentan melakukan <i>human error</i>.</p>

<h3>Struktur Formulir Pendaftaran Awal (Animo)</h3>
<p>Tidak seperti borang pendaftaran paripurna yang memuat puluhan <i>field</i> yang melelahkan, formulir <strong>Calon Data Murid</strong> pada tahap Animo ini secara sengaja dipangkas hingga menyisakan kerangkanya saja. Tujuan UX-nya jelas: menangkap ketertarikan (<i>leads</i>) secepat kilat tanpa membuat orang tua/calon pendaftar menunggu lama di loket.</p>

<h4>1. Tata Letak Simetris (Two-Column Grid)</h4>
<p>Keseluruhan borang dikemas rapi di dalam satu panel putih berlatar bersih, dengan penataan kolom-kolom yang berbaris berdampingan (kiri-kanan) demi keseimbangan visual yang sempurna:</p>
<ul>
    <li><strong>Smart Defaults &amp; Penguncian Institusi:</strong> Meneruskan tradisi UX yang tangguh dari modul sebelumnya, <i>field</i> <code>Jenjang</code> (misal terisi: TKIA) dan <code>Tujuan Sekolah</code> (misal: TK Islam Al Azhar 6 Sentra Primer) dibekukan dari modifikasi (berwarna latar abu-abu/<i>read-only</i>). Sistem secara otomatis menarik identitas ini dari sesi admin yang <i>login</i>. Keputusan desain ini adalah *Error Prevention* absolut yang memastikan data animo tidak mungkin "nyasar" masuk ke sistem pendaftaran unit sekolah lain di bawah yayasan.</li>
    <li><strong>Parameter Konteks Pendaftaran:</strong> Komponen di paruh kiri, meliputi <code>Tahun Ajaran</code>, <code>Tingkat Kelas</code>, dan <code>Program</code> diwajibkan menggunakan komponen <i>Dropdown</i> alih-alih teks biasa. Penyeragaman (*standardization*) via *dropdown* ini vital agar *database* bersih dari <i>typo</i>, sehingga mudah dikalkulasi nanti.</li>
    <li><strong>Asal Muasal Calon (Lead Source):</strong> Tersedia kolom <code>Asal Sekolah</code> untuk memetakan demografi asal muasal ketertarikan, yang kelak menjadi tambang emas analitik bagi tim pemasaran (<i>marketing</i>) PMB.</li>
    <li><strong>Identitas Primer:</strong> Di baris pemungkas, formulir cukup menuntut dua data fundamental lewat input teks bebas (<i>free-text</i>): <code>Nama Calon Murid</code> dan <code>Tempat Lahir</code>.</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman "Tambah Animo PMB" merupakan perwujudan sejati dari prinsip <strong>Speed and Efficiency (Kecepatan dan Efisiensi)</strong> dalam ranah perancangan antarmuka. Dengan mengeliminasi <i>clutter</i> (elemen pengganggu) dan memberdayakan otomatisasi pada kolom institusi, admin dibekali sebuah "senjata" (*tool*) yang memungkinkan mereka mendaftarkan <i>leads</i> baru hanya dalam tempo beberapa detik. Desain yang bernapas lega ini menjadikan interaksi pendataan, baik bagi pegawai rekrutan baru maupun operator kawakan, terasa sangat natural dan bebas stres.</p>
',
                'is_published' => true,
                'order' => 16
            ]
        );
    }
}

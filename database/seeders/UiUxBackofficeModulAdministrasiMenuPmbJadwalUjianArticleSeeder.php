<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuPmbJadwalUjianArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu PMB > Jadwal Ujian';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Jadwal Ujian</strong> yang berada di bawah payung "Administrasi &gt; PMB" memegang peranan sangat penting dalam mengatur alur seleksi akademik calon murid baru. Melalui halaman "Tambah Jadwal Ujian" ini, kita dapat melihat bagaimana antarmuka (<i>interface</i>) dirancang untuk menuntun alur pikir pengguna (<i>user guidance</i>) lewat kombinasi isian bebas dan input yang dikunci oleh sistem.</p>

<h3>Struktur Formulir Penjadwalan Ujian</h3>
<p>Menyelaraskan dengan standar <i>design system</i> pada modul PMB lainnya, halaman ini memusatkan pengisian data pada satu panel (<i>Card</i>) berwarna putih solid. Panel ini mengakomodasi tata letak yang luwes, memadukan format lebar penuh (<i>full-width</i>) dan paruh lebar (<i>half-width</i>).</p>

<h4>1. Atribut Fundamental (Full-Width Input)</h4>
<p>Area formulir ini dibuka dan ditutup oleh kolom berukuran 100% untuk memfasilitasi <i>input</i> yang panjang atau butuh penekanan visual:</p>
<ul>
    <li><strong>Judul Agenda:</strong> <i>Field</i> <code>Nama Ujian</code> diletakkan di baris pertama dan merentang penuh. Penempatan ini sangat hierarkis secara logika, karena judul (misal: "Ujian Saringan Masuk Gelombang 1 - 2024") bertindak sebagai identitas utama dari entitas jadwal tersebut.</li>
    <li><strong>Konteks Lokasi &amp; Catatan Tambahan:</strong> Di bagian bawah, <i>field</i> <code>Ruangan</code> dan <code>Keterangan</code> turut menggunakan format lebar penuh. Ini menjamin nama ruang yang mungkin panjang tidak terpotong, dan admin memiliki bidang teks (<i>text area</i>) yang lega untuk mengetikkan instruksi khusus bagi pengawas ujian maupun peserta.</li>
</ul>

<h4>2. Variabel Terkontrol (Two-Column Grid)</h4>
<p>Di bagian jantung formulir, desain bertransisi menjadi format <i>grid</i> 2-kolom untuk mengelola parameter administratif secara presisi:</p>
<ul>
    <li><strong>Automasi &amp; Data Terkunci (Smart Defaults):</strong> Praktik <i>Error Prevention</i> kasta tinggi kembali diterapkan di sini. Perhatikan <i>field</i> <code>Jenjang</code> (misal: TKIA) dan <code>Tipe Ujian</code> (misal: Offline); keduanya sengaja dibekukan (<i>disabled / read-only</i>) dan diwarnai abu-abu. Konfigurasi ini menjamin staf PMB tingkat TK tidak akan tak sengaja menjadwalkan ujian untuk tingkat SMP, sekaligus mengunci tipe ujian sesuai regulasi baku sekolah. Pengguna sama sekali tidak dibebani untuk memilih ulang data instansinya sendiri.</li>
    <li><strong>Variabel Dependen:</strong> Tepat di sebelah kolom-kolom yang dikunci, tersaji <i>dropdown</i> aktif untuk menentukan <code>Tingkat Kelas</code> dan <code>Gelombang</code> PMB. Mewajibkan penggunaan <i>dropdown</i> alih-alih isian manual adalah jalan ninja untuk menjaga integritas data (menjamin relasi ID di <i>database</i> tidak meleset).</li>
</ul>

<h3>Kesimpulan Desain UI/UX</h3>
<p>Halaman "Tambah Jadwal Ujian PMB" ini merupakan studi kasus yang cemerlang mengenai penerapan prinsip <strong>Constraint (Pembatasan Kendali)</strong> dalam bidang UX. Dengan mencampur harmonis antara kolom <i>read-only</i> (Jenjang &amp; Tipe Ujian) dengan kolom pilihan wajib (Kelas &amp; Gelombang), antarmuka ini berhasil mengeleminasi hampir 100% risiko salah ketik (<i>typo</i>) atau disorientasi data. Alhasil, prosedur pembuatan jadwal ujian seleksi yang berisiko tinggi pun akhirnya terasa sama mudah dan nyamannya seperti mengisi formulir buku tamu biasa.</p>
',
                'is_published' => true,
                'order' => 17
            ]
        );
    }
}

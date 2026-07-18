<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUX_02_LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Seri Panduan UI/UX Backoffice')],
            ['name' => 'Seri Panduan UI/UX Backoffice']
        );

        $content = <<<HTML
<p>Artikel ini adalah <strong>Seri 2 dari 5</strong> panduan bedah UI/UX Backoffice ALAZHARAPPS. Fokus pada artikel ini adalah membedah kelompok menu <strong>Laporan</strong>, yang dikhususkan untuk menarik data (*Export*) massal dari <em>database</em>.</p>

<h3>Menu: Laporan &rarr; Keuangan Murid</h3>
<p>Halaman ini bukan ditujukan untuk melakukan *input* data baru, melainkan pusat komando untuk menyaring (*Filtering*) dan mengunduh (*Download*) data finansial yang ada. Halaman ini adalah favorit bagian akuntansi sekolah.</p>

<ul>
    <li><strong>UI Layout (Antarmuka Utama):</strong>
        <p>Halaman didominasi oleh sebuah panel form besar (*Filter Panel*) di bagian atas, dan sebuah tabel kosong (*Data Grid*) di bagian bawah yang baru akan terisi setelah tombol pencarian ditekan. Hal ini dirancang (secara UX) agar sistem tidak otomatis menarik jutaan data saat halaman pertama kali dibuka, yang bisa menyebabkan halaman menjadi lambat (*lag*).</p>
    </li>
    
    <li><strong>Kolom Isian (Form Filter):</strong>
        <p>Agar Admin dapat menarik laporan spesifik, disediakan kolom isian berlapis (<em>Cascading Dropdowns</em>):</p>
        <ul>
            <li><code>Tahun Ajaran (Dropdown):</code> Memilih tahun akademik yang ingin dilaporkan.</li>
            <li><code>Tingkat Kelas (Dropdown):</code> Opsional. Jika hanya ingin menarik laporan kelas 1.</li>
            <li><code>Rombongan Belajar (Dropdown):</code> Bergantung pada pilihan Tingkat Kelas (UX: <em>Dependent Dropdown</em>). Hanya akan aktif/bisa dipilih jika Tingkat Kelas sudah diisi. (Misal: 1A, 1B).</li>
            <li><code>Status Pembayaran (Dropdown):</code> Opsi: <em>Semua, Lunas, Belum Lunas</em>.</li>
            <li><code>Komponen Biaya (Dropdown):</code> Opsi: <em>SPP, Uang Pangkal, Seragam, Kegiatan, dll.</em></li>
            <li><code>Periode Waktu (Date Picker):</code> <em>Start Date</em> dan <em>End Date</em> untuk membatasi tanggal transaksi.</li>
        </ul>
    </li>

    <li><strong>UX Behavior (Tombol Aksi):</strong>
        <p>Setelah filter diisi, Admin akan berhadapan dengan dua tombol utama dengan fungsi visual yang kontras:</p>
        <ul>
            <li><strong>Tombol "Tampilkan Data" (Warna Biru/Utama):</strong> Akan mengirim kueri ke <code>report-service</code> dan menampilkan datanya di dalam tabel web (*DataTables*) di bawah form tersebut. Tabel ini dilengkapi fitur <em>Pagination</em> (halaman 1, 2, 3...) agar tidak memberatkan <em>browser</em>.</li>
            <li><strong>Tombol "Export Excel / CSV" (Warna Hijau):</strong> Tombol pamungkas. Saat ditekan, UX akan memunculkan indikator <em>Loading/Spinner</em>. Sistem di belakang layar memproses pembuatan *file spreadsheet* mentah. Setelah selesai, *file* akan otomatis terunduh (*download*) ke dalam komputer Admin.</li>
        </ul>
    </li>
</ul>

<hr>
<p><em>Baca kelanjutannya pada <strong>Seri 3: Analisa Menu Master Data Sekolah</strong>.</em></p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Seri 2: UI UX Laporan Keuangan')],
            [
                'title' => 'Seri 2: Anatomi UI/UX Laporan Keuangan',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

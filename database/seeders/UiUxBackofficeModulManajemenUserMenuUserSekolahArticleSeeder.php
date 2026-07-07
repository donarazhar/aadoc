<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulManajemenUserMenuUserSekolahArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Manajemen User Menu User Sekolah';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Memasuki teritori yang sangat krusial terkait sekuriti data, menu <strong>User Sekolah</strong> di dalam klaster "Manajemen User" adalah pintu gerbang otorisasi mutlak (<i>Absolute Authorization Gateway</i>). Halaman "Tambah User" ini mendemonstrasikan eksekusi antarmuka yang sangat peka terhadap konteks (<i>Context-Aware UI</i>), di mana struktur formulir pendaftaran akun akan bermutasi secara instan mengikuti peran (<i>Role</i>) yang sedang dipilih.</p>

<h3>Struktur Antarmuka (UI) Form Autentikasi</h3>
<p>Menciptakan kredensial <i>login</i> (akun) secara manual membawa risiko fatal terhadap pembengkakan data tak bertuan (<i>ghost accounts</i>). Untuk memitigasi hal ini, desainer UI mengimplementasikan arsitektur *binding* (penautan) yang ketat:</p>
<ul>
    <li><strong>Mutasi Berbasis Peran (Role-Based Form Adaptation):</strong> <i>Field</i> pertama dan terpenting adalah <code>Peran/Role</code>. Pilihan di <i>dropdown</i> inilah yang mengendalikan anatomi layar di bawahnya.
        <ul>
            <li><strong>Mode Pegawai/Sekolah:</strong> Bila diklik, sistem memunculkan <i>field</i> <code>Level</code> guna mendefinisikan batas hak akses aplikasi (misal: Super Admin, Kasir, Guru). Fitur pencarian pada <code>Nama User</code> pun meruncing spesifik untuk melacak data kepegawaian melalui Nomor Induk Pegawai (NIP) atau Nama GTK.</li>
            <li><strong>Mode Peserta Didik:</strong> Jika <i>role</i> diganti ke siswa, form menjadi lebih ramping. <i>Field</i> <code>Level</code> dihanguskan (karena level siswa bersifat absolut/statis), dan target pencarian pada <code>Nama User</code> otomatis beralih membedah <i>database</i> Nomor Induk Siswa (NIS).</li>
        </ul>
    </li>
    <li><strong>Sistem Penautan Identitas (Strict Data Binding):</strong> Sistem melarang keras administrator mengetik sembarang nama fiktif. <i>Field</i> <code>Nama User</code> didesain sebagai kotak pencarian *real-time* yang terhubung ke <i>database master</i>. Mekanisme ini menjamin bahwa setiap *Username* dan *Password* yang dilahirkan di halaman ini terikat sah secara digital (<i>digitally binded</i>) pada entitas fisik manusia yang riwayatnya sudah tercatat oleh sekolah.</li>
    <li><strong>Ekspansi Hak Akses (LMS Checkbox):</strong> Keberadaan <i>checkbox</i> sederhana bertuliskan <code>Dapat Mengakses LMS</code> membuktikan bahwa sistem aplikasi ini mendukung arsitektur <i>Single Sign-On (SSO)</i> parsial. Dengan satu sentuhan *centang*, kredensial yang dibuat ini langsung terotorisasi masuk ke ekosistem <i>Learning Management System</i> di luar portal utama.</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Di dalam <i>blueprint workflow</i> IT, menu <strong>User Sekolah</strong> berperan secara eksklusif sebagai <strong>"Identity &amp; Access Management (IAM) Hub"</strong>.</p>
<ul>
    <li><strong>Hulu Referensi (Data Consumer):</strong> Menu ini secara hierarkis tidak menciptakan manusia baru. Ia berdiri di hilir dari modul <strong>Sekolah &gt; Pegawai</strong> dan <strong>Sekolah &gt; Data Murid</strong>. Tugasnya hanyalah memanggil manusia-manusia yang sudah terdaftar di sana, lalu memakaikan "baju zirah digital" (hak *login*) kepada mereka.</li>
    <li><strong>Hilir Otorisasi (System-wide Director):</strong> Begitu tombol "Simpan" ditekan, data diinjeksi ke tabel fundamental <code>Users</code>. *Database* dari halaman inilah yang akan menjadi penentu nasib (*Director*) setiap kali seseorang mengakses layar depan aplikasi. Kredensial (<i>Role &amp; Level</i>) yang disetel di sinilah yang mengatur apakah orang tersebut akan mendarat di Dasbor Keuangan (untuk kasir), Dasbor Akademik (untuk guru), atau sekadar Dasbor Tagihan (untuk orang tua siswa).</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Menyatukan form pembuatan akun Pegawai dan Siswa ke dalam satu halaman dinamis (tanpa perlu membuka tab menu yang berbeda) adalah keputusan UX yang berani namun sangat efisien (*lean interface*). Mekanisme pertahanan sistem melalui <i>Smart Search Input</i> pada *field* Nama User memastikan kebersihan ekosistem aplikasi dari duplikasi akun. Secara komprehensif, menu ini mendemonstrasikan keandalan aplikasi *Al Azhar Apps* dalam memagari lalu-lintas hak akses pengguna dalam satu sentralisasi kontrol yang aman dan elegan.</p>
',
                'is_published' => true,
                'order' => 28
            ]
        );
    }
}

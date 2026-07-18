<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanUIUX_03_SekolahSeeder extends Seeder
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
<p>Artikel ini adalah <strong>Seri 3 dari 5</strong> panduan bedah UI/UX Backoffice ALAZHARAPPS. Membahas kelompok menu <strong>Sekolah</strong>, yang merupakan jantung "Master Data" bagi unit sekolah (Pusat pengaturan demografi dan SDM).</p>

<h3>1. Menu: Data Murid & Profile Sekolah</h3>
<ul>
    <li><strong>UI Layout (Data Murid):</strong> Tabel master panjang (<em>Data Grid</em>) dengan foto profil bulat (Avatar). Terdapat tombol aksi untuk <em>Edit Biodata</em>. Di dalam form Edit, kolom isian dibagi menjadi beberapa <em>Tab</em> UX: (Tab Data Pribadi, Tab Data Orang Tua, Tab Data Medis) agar form tidak memanjang tak terbatas ke bawah (*Endless Scrolling*).</li>
    <li><strong>UI Layout (Profile Sekolah):</strong> Form statis dengan kolom isian dasar: <code>Nama Sekolah</code>, <code>NPSN</code>, <code>Alamat (Textarea)</code>, <code>Logo Sekolah (Upload Image)</code>.</li>
</ul>

<h3>2. Menu: Kurikulum, Program, Sarpras, Ekstrakurikuler, Prestasi</h3>
<p>Kumpulan menu ini memiliki <em>User Experience (UX)</em> yang seragam dan standar, menggunakan pola CRUD (<em>Create, Read, Update, Delete</em>).</p>
<ul>
    <li>Setiap menu hanya berisi form sederhana (misal: Tambah Ekstrakurikuler &rarr; <code>Nama Ekskul</code>, <code>Deskripsi</code>, <code>Pembina</code>).</li>
    <li>Fungsi UX-nya adalah menyediakan sumber data (<em>Data Source</em>) untuk kolom <em>Dropdown</em> di menu yang lebih kompleks (seperti di form Rapor).</li>
</ul>

<h3>3. Menu: Rombel (Rombongan Belajar) & Pegawai</h3>
<p>Menu Rombel (Kelas) adalah titik relasi paling kuat di sistem ini.</p>
<ul>
    <li><strong>UI Tambah Rombel:</strong>
        <ul>
            <li><code>Nama Kelas (Input Text):</code> Contoh: "Kelas 1A" atau "Abu Bakar".</li>
            <li><code>Tingkat Kelas (Dropdown):</code> Untuk menentukan level (Misal: SD Kelas 1).</li>
            <li><code>Wali Kelas (Searchable Dropdown):</code> <strong>Krusial!</strong> Kolom ini menarik data dari menu <strong>Pegawai</strong>. UX form menggunakan kotak pencarian pintar (mengetikkan huruf "B", muncul nama "Budi").</li>
        </ul>
    </li>
    <li><strong>Manajemen Anggota Rombel (Mapping UI):</strong> Saat Rombel berhasil dibuat, UX akan berubah menjadi <strong>Dual Listbox</strong> (Dua kolom bersebelahan). Sebelah kiri adalah "Daftar Murid yang Belum Punya Kelas", sebelah kanan adalah "Anggota Rombel Ini". Admin cukup memindahkan (<em>Move Arrow / Drag & Drop</em>) nama siswa ke kanan untuk mendaftarkannya ke kelas tersebut.</li>
</ul>

<h3>4. Menu: Akademik (Kenaikan Kelas & Kelulusan)</h3>
<p>Ini adalah alat (<em>Tools</em>) pemrosesan massal tahunan.</p>
<ul>
    <li><strong>UI Layout (Kenaikan Kelas Massal):</strong>
        <p>Bentuk form dirancang sangat aman untuk mencegah salah klik (*Human Error*).</p>
        <ul>
            <li><strong>Langkah 1:</strong> Memilih <code>Kelas Asal (Dropdown)</code> dan <code>Tahun Ajaran Asal</code>. Sistem memunculkan tabel berisi nama-nama siswa.</li>
            <li><strong>Langkah 2:</strong> Memilih <code>Kelas Tujuan (Dropdown)</code> dan <code>Tahun Ajaran Baru</code>.</li>
            <li><strong>Langkah 3 (Checklist):</strong> Terdapat kotak centang (<em>Checkbox</em>) masal. Admin mencentang semua siswa, lalu menekan tombol <strong>"Proses Naik Kelas"</strong>.</li>
        </ul>
    </li>
    <li><strong>UX Kelulusan:</strong> Tombol kelulusan biasanya diamankan dengan kotak dialog (<em>Modal Confirmation</em>) berwarna merah yang meminta Admin mengetik ulang kata "LULUS" (<em>Hard Confirmation</em>) untuk memastikan siswa tersebut benar-benar dikeluarkan dari daftar Siswa Aktif dan dipindahkan ke Tabel Alumni.</li>
</ul>

<hr>
<p><em>Baca kelanjutannya pada <strong>Seri 4: Analisa Menu Administrasi Biaya & PMB</strong> (Paling Detail!).</em></p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Seri 3: UI UX Data Master Sekolah')],
            [
                'title' => 'Seri 3: Anatomi UI/UX Data Master Sekolah',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

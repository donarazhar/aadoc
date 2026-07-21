<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ArtikelSeeder extends Seeder
{
    public function run()
    {
        // Pastikan category dan user ada untuk menghindari error foreign key
        $category = Category::firstOrCreate(
            ['slug' => 'role-akses-menu'],
            ['name' => 'Role Akses Menu']
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        Document::create([
            'category_id' => $categoryId, // Dynamic category ID
            'title' => 'Panduan Akses Menu: Administrator',
            'slug' => Str::slug('Panduan Akses Menu: Administrator'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Administrator</h3><ul><li>Dashboard > Summary</li><li>Dashboard > Sekolah</li><li>Dashboard > Murid</li><li>Dashboard > Keuangan</li><li>Transaksi > PMB</li><li>Transaksi > Penerimaan</li><li>Laporan > Keuangan</li><li>Laporan > Keuangan > Keuangan Murid</li><li>Laporan > Keuangan > Keuangan Sekolah (Kode Biaya)</li><li>Laporan > Keuangan > Pencapaian Target Sekolah</li><li>Laporan > Keuangan > Cek Tagihan</li><li>Laporan > Keuangan > Transaksi Murid (Kode Biaya)</li><li>Laporan > Keuangan > Settlement</li><li>Laporan > Keuangan > Upload Excel Settlement</li><li>Laporan > Pegawai</li><li>Sekolah > Sekolah</li><li>Sekolah > Data Murid</li><li>Sekolah > Rombel</li><li>Sekolah > Pegawai</li><li>Sekolah > Pegawai > Pegawai</li><li>Sekolah > Akademik</li><li>Sekolah > Akademik > Kenaikan Kelas & Kelulusan</li><li>Administrasi > PMB</li><li>Administrasi > PMB > Animo</li><li>Administrasi > PMB > Jadwal Ujian</li><li>Administrasi > PMB > Gelombang Pendaftaran</li><li>Administrasi > PMB > Peserta Ujian</li><li>Administrasi > PMB > Kelulusan Peserta</li><li>Administrasi > Data Calon Murid</li><li>Administrasi > Biaya</li><li>Administrasi > Biaya > Uang Sekolah</li><li>Administrasi > Biaya > Uang Pangkal</li><li>Administrasi > Biaya > Uang Daftar Ulang</li><li>Administrasi > Biaya > Pengajuan Diskon</li><li>Administrasi > Biaya > Pengajuan Angsuran</li><li>Administrasi > Biaya > Hak Akses Menu Angsuran</li><li>Administrasi > Kalender</li><li>Manajemen User > User Back Office Pusat</li><li>Manajemen User > Log Activity</li><li>Master Data > Tahun Ajaran</li><li>Master Data > Kelas</li><li>Master Data > Program</li><li>Master Data > Mata Pelajaran</li><li>Master Data > Kurikulum</li><li>Master Data > Diskon</li><li>Master Data > Angsuran</li><li>Master Data > Sumber Informasi</li><li>Jurnal & E-Rapot > Ijazah</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Kepala Sekolah',
            'slug' => Str::slug('Panduan Akses Menu: Kepala Sekolah'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Kepala Sekolah</h3><ul><li>Dashboard > Summary</li><li>Dashboard > Summary</li><li>Dashboard > Murid</li><li>Transaksi > PMB</li><li>Sekolah > Data Murid</li><li>Sekolah > Profile Sekolah</li><li>Sekolah > Rombel</li><li>Sekolah > Kurikulum</li><li>Sekolah > Program</li><li>Sekolah > Pegawai</li><li>Sekolah > Pegawai > Pegawai</li><li>Sekolah > Akademik > Kenaikan Kelas & Kelulusan</li><li>Sekolah > PMB</li><li>Sekolah > Sarana Prasarana</li><li>Sekolah > Ekstrakulikuler</li><li>Sekolah > Prestasi</li><li>Administrasi > PMB</li><li>Administrasi > PMB > Animo</li><li>Administrasi > PMB > Jadwal Ujian</li><li>Administrasi > PMB > Gelombang Pendaftaran</li><li>Administrasi > PMB > Peserta Ujian</li><li>Administrasi > PMB > Kelulusan Peserta</li><li>Administrasi > Data Calon Murid</li><li>Administrasi > Biaya</li><li>Administrasi > Biaya > Uang Daftar Ulang</li><li>Administrasi > Biaya > Pengajuan Diskon</li><li>Administrasi > Biaya > Pengajuan Angsuran</li><li>Administrasi > Kalender</li><li>Manajemen User > Log Activity</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Admin Sekolah',
            'slug' => Str::slug('Panduan Akses Menu: Admin Sekolah'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Admin Sekolah</h3><ul><li>Dashboard > Summary</li><li>Dashboard > Murid</li><li>Transaksi > PMB</li><li>Laporan > Keuangan</li><li>Laporan > Keuangan > Keuangan Murid</li><li>Laporan > Keuangan > Transaksi Murid (Kode Biaya)</li><li>Sekolah > Data Murid</li><li>Sekolah > Profile Sekolah</li><li>Sekolah > Rombel</li><li>Sekolah > Kurikulum</li><li>Sekolah > Program</li><li>Sekolah > Pegawai</li><li>Sekolah > Pegawai > Pegawai</li><li>Sekolah > Akademik</li><li>Sekolah > Akademik > Kenaikan Kelas & Kelulusan</li><li>Sekolah > PMB</li><li>Sekolah > Sarana Prasarana</li><li>Sekolah > Ekstrakulikuler</li><li>Sekolah > Prestasi</li><li>Administrasi > PMB</li><li>Administrasi > PMB > Animo</li><li>Administrasi > PMB > Jadwal Ujian</li><li>Administrasi > PMB > Gelombang Pendaftaran</li><li>Administrasi > PMB > Peserta Ujian</li><li>Administrasi > PMB > Kelulusan Peserta</li><li>Administrasi > Data Calon Murid</li><li>Administrasi > Biaya</li><li>Administrasi > Biaya > Uang Sekolah</li><li>Administrasi > Biaya > Uang Pangkal</li><li>Administrasi > Biaya > Uang Daftar Ulang</li><li>Administrasi > Biaya > Pengajuan Diskon</li><li>Administrasi > Biaya > Pengajuan Angsuran</li><li>Administrasi > Kalender</li><li>Manajemen User > User Sekolah</li><li>Manajemen User > Log Activity</li><li>Master Data > Angsuran</li><li>Jurnal & E-Rapot > E-Rapot</li><li>Jurnal & E-Rapot > Ijazah</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Admin Direktorat Dikdasmen',
            'slug' => Str::slug('Panduan Akses Menu: Admin Direktorat Dikdasmen'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Admin Direktorat Dikdasmen</h3><ul><li>Dashboard > Summary</li><li>Dashboard > Sekolah</li><li>Dashboard > Murid</li><li>Dashboard > Keuangan</li><li>Sekolah > Sekolah</li><li>Sekolah > Data Murid</li><li>Administrasi > PMB</li><li>Administrasi > PMB > Gelombang Pendaftaran</li><li>Administrasi > Data Calon Murid</li><li>Administrasi > Biaya</li><li>Administrasi > Biaya > Pengajuan Diskon</li><li>Master Data > Kelas</li><li>Master Data > Program</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Admin Direktorat Keuangan',
            'slug' => Str::slug('Panduan Akses Menu: Admin Direktorat Keuangan'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Admin Direktorat Keuangan</h3><ul><li>Dashboard > Summary</li><li>Dashboard > Sekolah</li><li>Dashboard > Murid</li><li>Dashboard > Keuangan</li><li>Transaksi > PMB</li><li>Transaksi > Penerimaan</li><li>Laporan > Keuangan</li><li>Laporan > Keuangan > Keuangan Murid</li><li>Laporan > Keuangan > Keuangan Sekolah (Kode Biaya)</li><li>Laporan > Keuangan > Pencapaian Target Sekolah</li><li>Laporan > Keuangan > Cek Tagihan</li><li>Laporan > Keuangan > Transaksi Murid (Kode Biaya)</li><li>Laporan > Keuangan > Settlement</li><li>Laporan > Keuangan > Upload Excel Settlement</li><li>Sekolah > Sekolah</li><li>Sekolah > Data Murid</li><li>Administrasi > Data Calon Murid</li><li>Administrasi > Biaya</li><li>Administrasi > Biaya > Uang Sekolah</li><li>Administrasi > Biaya > Uang Pangkal</li><li>Administrasi > Biaya > Uang Daftar Ulang</li><li>Administrasi > Biaya > Uang Ekstrakulikuler</li><li>Administrasi > Biaya > Pengajuan Diskon</li><li>Administrasi > Biaya > Pengajuan Angsuran</li><li>Administrasi > Biaya > Hak Akses Menu Angsuran</li><li>Master Data > Angsuran</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Guru',
            'slug' => Str::slug('Panduan Akses Menu: Guru'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Guru</h3><ul><li>Dashboard > </li><li>Jurnal & E-Rapot > Jurnal</li><li>Jurnal & E-Rapot > Leger</li><li>Jurnal & E-Rapot > Leger > Leger Nilai</li><li>Jurnal & E-Rapot > Leger > Leger Adab</li><li>Jurnal & E-Rapot > Leger > Leger Tahfizh</li><li>Jurnal & E-Rapot > Submit Nilai</li><li>Jurnal & E-Rapot > E-Rapot</li><li>Jurnal & E-Rapot > Ijazah</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

        Document::create([
            'category_id' => $categoryId,
            'title' => 'Panduan Akses Menu: Admin Daycare',
            'slug' => Str::slug('Panduan Akses Menu: Admin Daycare'),
            'content' => '<h3>Daftar Akses Menu untuk Role: Admin Daycare</h3><ul><li>Sekolah > Data Murid</li></ul>',
            'is_published' => true,
            'created_by' => $userId,
            'order' => 0,
        ]);

    }
}

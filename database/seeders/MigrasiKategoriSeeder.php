<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class MigrasiKategoriSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'Arsitektur, Infrastruktur & Teknis' => [
                'Evolusi Arsitektur Sistem: Monolitik ke Microservices',
                'Topologi Infrastruktur Cloud-Native: Skalabilitas, Keamanan, & High Availability',
                'Roadmap Upgrading Al Azhar Apps: Resolusi Teknologi & Ekosistem Terpadu',
                'Analisis Arsitektur Global & Integrasi Sistem',
                'Bedah Arsitektur Ekosistem LMS',
                'Bedah Arsitektur Frontend & Manajemen State (NextJS & Redux)',
                'Arsitektur Mobile Apps (Siswa & Orang Tua)',
                'Pendalaman Backend: Golang (Go)',
                'Pendalaman Frontend: NextJS',
                'Keamanan & Autentikasi',
                'DevOps, Deployment, & Infrastruktur',
                'Struktur Proyek & Arsitektur Microservices',
                'Dokumentasi Teknologi & Dependensi',
                'Panduan Gaya Penulisan Kode (Coding Standards)',
                'Skema Database & Entitas Tabel Berdasarkan Migrasi',
                'Analisis Query Kritis & Logika Database',
                'Strategi Manajemen Data (Backup & Archiving)',
                'Informasi Koneksi & Kredensial Staging',
                'Panduan Setup Lingkungan & Build Aplikasi',
                'Analisis Otomatisasi Deployment (CI/CD Pipeline)',
                'Dokumentasi Konfigurasi Server & Variabel Lingkungan',
                'Dokumentasi API (Endpoint Summary)',
                'Komunikasi Asinkron antar Layanan (Inter-Service Mapping)',
                'Sinkronisasi Data Lintas Sistem (ETL & Dapodik)',
                'Panduan Troubleshooting & Pemulihan Bencana (Disaster Recovery)',
                'Strategi Pengujian Otomatis (Automated Testing)',
                'Observabilitas & Monitoring Sistem (Grafana/Sentry)',
                'Integrasi Pihak Ketiga & Validasi Webhook',
                'Kebijakan Version Control & Siklus SDLC',
                'Analisa Gambaran ERD',
                'Gambaran Nyata ERD (Entity Relationship Diagram)',
                'Release Notes'
            ],
            'Panduan Aplikasi Mobile' => [
                'Registrasi Akun Al Azhar Apps',
                'Instalasi Mobile App',
                'Login',
                'Verifikasi PIN',
                'Dasbor Beranda',
                'Bottom Menu Anak',
                'Fitur Menu Tagihan',
                'Fitur Menu PMB',
                'Bottom Menu Chat',
                'Botttom Menu Akun',
                'Panduan Dasar Penggunaan Aplikasi Mobile (Orang Tua)',
                '[Mobile] Alur Registrasi PPDB & Akun',
                '[Mobile] Panduan Cek Tagihan & Pembayaran SPP',
                '[Mobile] Cara Mengakses Kelas & Ujian LMS (Siswa)',
                '[Mobile] Fitur dan Fungsi Menu Lengkap'
            ],
            'Modul Dashboard & Analitik' => [
                'Modul Dashboard Menu Summary',
                'Modul Dashboard Menu Murid',
                'Analisa Mendalam Menu Dashboard Backoffice'
            ],
            'Modul Operasional Akademik' => [
                'Modul Sekolah Menu Data Murid',
                'Modul Sekolah Menu Profile Sekolah',
                'Modul Sekolah Menu Rombel',
                'Modul Sekolah Menu Kurikulum',
                'Modul Sekolah Menu Program',
                'Modul Sekolah Menu Pegawai',
                'Modul Sekolah Menu Akademik (Kenaikan Kelas & Kelulusan)',
                'Modul Sekolah Menu Sarana Prasarana',
                'Modul Sekolah Menu Ekstrakurikuler',
                'Modul Sekolah Menu Prestasi',
                'Modul Manajemen User Menu User Sekolah',
                'Modul Jurnal & E-Rapot Menu E-Rapot',
                'Modul Jurnal & E-Rapot Menu Ijazah',
                '[Web] Manajemen Data Siswa & Kelas (Admin)',
                '[Web] Manajemen LMS & Input Nilai Jurnal (Guru)'
            ],
            'Modul Keuangan & PMB' => [
                'Modul Administrasi Menu PMB > Animo',
                'Modul Administrasi Menu PMB > Gelombang',
                'Modul Administrasi Menu PMB > Jadwal Ujian',
                'Modul Administrasi Menu PMB > Peserta Ujian',
                'Modul Administrasi Menu PMB > Kelulusan Peserta',
                'Modul Administrasi Menu Data Calon Murid',
                'Modul Sekolah Menu PMB',
                'Modul Transaksi Menu PMB',
                'Modul Administrasi Menu Biaya > Uang Sekolah',
                'Modul Administrasi Menu Biaya > Uang Pangkal',
                'Modul Administrasi Menu Biaya > Uang Daftar Ulang',
                'Modul Administrasi Menu Biaya > Pengajuan Diskon',
                'Modul Administrasi Menu Biaya > Pengajuan Angsuran',
                'Modul Master Data Menu Angsuran',
                'Modul Laporan Menu Keuangan Murid & Transaksi Murid',
                '[Web] Alur Penerbitan Tagihan Finansial (Keuangan)'
            ],
            'Skenario & Workflow Proses Bisnis' => [
                'Skenario Penerimaan Murid Baru (PPDB End-to-End)',
                'Alur Lengkap PMB (Reguler & Cicilan)',
                'Skenario Otentikasi, Registrasi, dan Lupa PIN (Mobile)',
                'Skenario Keuangan, Penagihan & Webhook (Billing Cycle)',
                'Skenario Akademik dan Ujian (LMS & CBT)',
                'Skenario Presensi, Absensi Harian & Geofencing',
                'Skenario Engine Notifikasi Terpusat (Broadcast & Worker)',
                'Skenario Mutasi Akademik dan Kenaikan Kelas',
                'Skenario Sinkronisasi Data Lintas Platform (ETL Process)',
                'Skenario Pengajuan Diskon (Hybrid)',
                'Skenario Rekonsiliasi Pembayaran Manual (Settlement Upload)',
                'Skenario Pengolahan Rapor Digital dan Kelulusan',
                'Skenario Jurnal Harian Guru dan Materi Ajar',
                'Skenario Integrasi Payment Gateway (DOKU & Webhook)',
                'Alur Logika Bisnis Inti (Siklus Finansial & PPDB)',
                'Analisa Workflow Backoffice',
                'Panduan Dasar Penggunaan Backoffice (Berdasarkan Role)',
                'Panduan Proses Bisnis: Siklus Administratif & Finansial ALAZHARAPPS',
                'Panduan Proses Bisnis: Siklus Akademik & CBT LMSALAZHARAPPS'
            ],
            'Panduan Spesifik Edge Cases' => [
                'Panduan Spesifik: Alur Pengajuan Diskon (Potongan)',
                'Panduan Spesifik: Alur Pengajuan Angsuran (Cicilan)',
                'Panduan Spesifik: Alur Pembatalan & Mutasi Keluar',
                'Panduan Spesifik: Alur Penanganan Tunggakan Kronis'
            ],
            'Bedah Anatomi UI/UX' => [
                'Panduan Anatomi UI/UX (Web Backoffice & Mobile App)',
                'Analisa Mendalam Struktur Menu Sidebar Backoffice',
                'Seri 1: Anatomi UI/UX Dashboard dan Transaksi',
                'Seri 2: Anatomi UI/UX Laporan Keuangan',
                'Seri 3: Anatomi UI/UX Data Master Sekolah',
                'Seri 4: Anatomi UI/UX Administrasi Biaya (Daftar Ulang)',
                'Seri 5: Anatomi UI/UX Manajemen User dan E-Rapot',
                'Panduan SOP Proses Bisnis (UI/UX Lengkap)',
                'Akses Halaman Backoffice',
                '[Web] Fitur dan Fungsi Menu Lengkap Backoffice'
            ],
            'Basis Pengetahuan Moodle & Otorisasi' => [
                'LMS berbasis Moodle',
                'Dasar-Dasar Moodle',
                'Tutorial Cepat: Membuat Cohort dan Course',
                'Tutorial Cepat: Memasukkan Materi Pelajaran (Role Teacher)',
                'Peta Hierarki Peran (Roles)',
                'Matriks Otorisasi & Hak Akses Berjenjang (RBAC)',
                'One Platform, All Solutions',
                'Analisa Modul-Modul'
            ]
        ];

        foreach ($map as $catName => $titles) {
            // 1. Buat Kategori Baru jika belum ada
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName]
            );

            // 2. Update massal artikel-artikel agar masuk ke kategori ini
            Document::whereIn('title', $titles)->update([
                'category_id' => $category->id
            ]);
        }
    }
}

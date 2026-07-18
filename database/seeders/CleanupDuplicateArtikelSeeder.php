<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class CleanupDuplicateArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $obsoleteTitles = [
            // Klaster PMB & Keuangan
            'Alur Lengkap PMB (Reguler & Cicilan)',
            'Skenario Penerimaan Murid Baru (PPDB End-to-End)',
            'Alur Logika Bisnis Inti (Siklus Finansial & PPDB)',
            'Skenario Keuangan, Penagihan & Webhook (Billing Cycle)',
            '[Web] Alur Penerbitan Tagihan Finansial (Keuangan)',
            
            // Klaster Akademik & LMS
            'Skenario Akademik dan Ujian (LMS & CBT)',
            'Skenario Pengolahan Rapor Digital dan Kelulusan',
            'Skenario Jurnal Harian Guru dan Materi Ajar',
            '[Web] Manajemen LMS & Input Nilai Jurnal (Guru)',
            
            // Klaster Analisa UI/UX Generik
            'Panduan Anatomi UI/UX (Web Backoffice & Mobile App)',
            'Analisa Mendalam Menu Dashboard Backoffice',
            'Analisa Mendalam Struktur Menu Sidebar Backoffice',
            
            // Klaster Mobile App Duplikat
            '[Mobile] Alur Registrasi PPDB & Akun',
            '[Mobile] Panduan Cek Tagihan & Pembayaran SPP',
            '[Mobile] Cara Mengakses Kelas & Ujian LMS (Siswa)',
        ];

        // Lakukan penghapusan (Pruning) secara massal
        $deletedCount = Document::whereIn('title', $obsoleteTitles)->delete();

        if ($deletedCount > 0) {
            $this->command->info("Berhasil menghapus {$deletedCount} artikel duplikat/usang demi menjaga Single Source of Truth.");
        } else {
            $this->command->info("Tidak ada artikel usang yang ditemukan (Mungkin sudah dihapus sebelumnya).");
        }
    }
}

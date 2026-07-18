<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Base (User and Admin) - Tidak perlu memanggil UserSeeder jika tidak ada

        // 2. Artikel UI/UX dan Pedoman Dasar
        $this->call([
            GettingStartedSeeder::class,
            PanduanDashboardBackofficeSeeder::class,
            PanduanMenuBackofficeSeeder::class,
            PanduanUIUXSeeder::class,
            PanduanUIUX_01_DashboardTransaksiSeeder::class,
            PanduanUIUX_02_LaporanSeeder::class,
            PanduanUIUX_03_SekolahSeeder::class,
            PanduanUIUX_04_AdministrasiSeeder::class,
            PanduanUIUX_05_ManajemenUserJurnalSeeder::class,
            PanduanUserBackofficeSeeder::class,
            PanduanUserOrangTuaSeeder::class,
        ]);

        // 3. Artikel Skenario & Workflow Spesifik
        $this->call([
            PanduanWorkflowDiscountInstallmentSeeder::class,
            PanduanWorkflowDokuSeeder::class,
            PanduanWorkflowLearningAgendaSeeder::class,
            PanduanWorkflowReportCardSeeder::class,
        ]);

        // 4. Artikel Master SOP (Terbaru)
        $this->call([
            PanduanProsesBisnisALAZHARSeeder::class,
            PanduanProsesBisnisLMSSeeder::class,
            PanduanSpesifikAngsuranSeeder::class,
            PanduanSpesifikDiskonSeeder::class,
            PanduanSpesifikPembatalanSeeder::class,
            PanduanSpesifikTunggakanSeeder::class,
        ]);

        // 5. Utilitas Manajemen Kategori (Mengatur ulang semuanya)
        $this->call([
            MigrasiKategoriSeeder::class,
        ]);

        // 6. Utilitas Injeksi Logika Backend ke dalam Artikel (Update Otomatis)
        $this->call([
            UpdateArtikelUIUXSeeder::class,
            UpdateVendorJuli17Seeder::class,
        ]);

        // 7. Utilitas Sapu Bersih (Menghapus artikel kembar / tergantikan)
        $this->call([
            CleanupDuplicateArtikelSeeder::class,
        ]);
    }
}

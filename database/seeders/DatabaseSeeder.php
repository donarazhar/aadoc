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
        $this->call([
            UserSeeder::class,
            PanduanTambahPegawaiSeeder::class,
            WorkflowAdministratorSeeder::class,
            PerbedaanKelasDanRombelSeeder::class,
            PanduanTambahProgramSeeder::class,
            PanduanTambahKurikulumMapelSeeder::class,
            PanduanTambahDiskonPrestasiSeeder::class,
            PanduanTambahDiskonRaportSeeder::class,
            PanduanTambahDiskonHafalanSeeder::class,
            PanduanTambahDiskonSaudaraKandungSeeder::class,
            PanduanTambahDiskonAnakPegawaiSeeder::class,
            PanduanTambahDiskonAnakPegawaiSPPSeeder::class,
            PanduanTambahDiskonLulusanYPISeeder::class,
            PanduanTambahDiskonMuridPindahanSeeder::class,
            PanduanTambahAngsuranSeeder::class,
            PanduanTambahSumberInformasiSeeder::class,
            SetupManajemenUnitSekolahSeeder::class,
            PanduanTambahSekolahSeeder::class,
            PanduanRombelAdministratorSeeder::class,
            SetupAksesPenggunaAdministratorSeeder::class,
            SetupKeuanganAdministratorSeeder::class,
            PanduanSppPusatSeeder::class,
            PanduanSppSekolahSeeder::class,
            PanduanUangPangkalSeeder::class,
            PanduanTagihanTambahanSeeder::class,
            SetupPmbAdministratorSeeder::class,
            PanduanGelombangPmbSeeder::class,
            PanduanJadwalUjianPmbSeeder::class,
            PanduanTambahDaftarUlangSeeder::class,
            PanduanTambahEkstrakurikulerSeeder::class,
        ]);
    }
}

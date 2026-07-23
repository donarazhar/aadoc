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
        ]);
    }
}

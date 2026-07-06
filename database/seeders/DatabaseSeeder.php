<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Superadmin
        User::updateOrCreate(
            ['email' => 'donarazhar@gmail.com'],
            [
                'name' => 'Donar Azhar',
                'password' => Hash::make('password123'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );

        // Create Categories
        $categories = [
            'Dashboard',
            // 'Transaksi PMB',
            // 'Laporan Keuangan',
            // 'Sekolah',
            // 'Administrasi'
        ];

        foreach ($categories as $i => $catName) {
            Category::updateOrCreate(
                ['slug' => Str::slug($catName)],
                [
                    'name' => $catName,
                    'description' => 'Dokumentasi terkait ' . $catName,
                    'order' => $i + 1,
                ]
            );
        }

        // Memanggil seeder lainnya agar datanya ikut masuk
        $this->call([
            GettingStartedSeeder::class,
            UiUxMobileAppSeeder::class,
            DashboardArticleSeeder::class,
            ArchitectureSeeder::class,
            ArticleSeeder::class,
            InfrastructureSeeder::class,
            UpgradingSeeder::class,
            RegistrasiAkunSeeder::class,
            PmbWorkflowSeeder::class,
            AnalisaModulBackofficeArticleSeeder::class,
            AnalisaGambaranErdArticleSeeder::class,
            PanduanMembacaAlurArticleSeeder::class,
            UiUxBackofficeSummaryArticleSeeder::class,
        ]);
    }
}

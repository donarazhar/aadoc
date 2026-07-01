<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori Prologue ada
        $category = Category::firstOrCreate(
            ['slug' => 'prologue'],
            ['name' => 'Prologue', 'description' => 'Pendahuluan dan pengenalan aplikasi', 'order' => 1]
        );

        // Buat artikel Release Notes
        $title = 'Release Notes';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '<p>Salam Al-Azhar merupakan platform resmi yang dihadirkan oleh Yayasan Pesantren Islam Al-Azhar untuk memudahkan aktivitas peserta didik. Salam Al-Azhar dirancang untuk memudahkan dan mempercepat proses penerimaan peserta didik baru PPDB & pindahan, pembayaran uang sekolah, informasi akademik dan komunikasi layanan yang terbaik yang disajikan khusus untuk komunitas Al Azhar.</p>',
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

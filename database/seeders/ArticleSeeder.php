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
                'content' => '<p>Al Azhar Apps merupakan platform digital resmi dari Yayasan Pesantren Islam Al-Azhar yang dirancang untuk mengintegrasikan seluruh ekosistem pendidikan ke dalam satu genggaman. Mengusung semangat #OnePlatformAllSolutions, kami menghadirkan kemudahan mulai dari proses Penerimaan Murid Baru (PMB) yang cepat, hingga pemenuhan semua kebutuhan sekolah dalam satu aplikasi. Kini, Anda dapat memantau perkembangan anak, mengecek tagihan pendidikan, menerima pengumuman, melihat jadwal pelajaran, hingga berkomunikasi dengan sekolah secara mulus langsung dari smartphone Anda. Layanan terbaik, khusus untuk komunitas Al Azhar.</p>',
                'is_published' => true,
                'order' => 1
            ]
        );
    }
}

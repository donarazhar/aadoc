<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class InsertKTS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kts:insert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert KTS articles into the documentation database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categoryName = 'Knowledge Transfer Session (KTS)';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Dokumentasi hasil sesi transfer pengetahuan terkait proyek Fintech Al-Azhar Apps.',
            ]
        );

        $this->info("Kategori '{$categoryName}' berhasil dimuat.");

        $brainDir = 'C:\\Users\\bagian TI dan TD\\.gemini\\antigravity-ide\\brain\\7eab7293-666d-45f3-831a-5a5c13684d8e\\';

        $articles = [
            ['file' => 'struktur_proyek.md', 'title' => 'Struktur Proyek & Microservices'],
            ['file' => 'dependencies_documentation.md', 'title' => 'Teknologi & Dependensi'],
            ['file' => 'coding_standards.md', 'title' => 'Coding Standards'],
            ['file' => 'database_erd.md', 'title' => 'Skema Database (ERD)'],
            ['file' => 'query_kritis.md', 'title' => 'Analisis Query Kritis'],
            ['file' => 'data_management.md', 'title' => 'Manajemen Data'],
            ['file' => 'koneksi_staging.md', 'title' => 'Informasi Koneksi Staging'],
            ['file' => 'setup_guide.md', 'title' => 'Panduan Setup & Build'],
            ['file' => 'ci_cd_pipeline.md', 'title' => 'Analisis Deployment CI/CD'],
            ['file' => 'server_configuration.md', 'title' => 'Konfigurasi Server'],
            ['file' => 'api_documentation_summary.md', 'title' => 'Dokumentasi API'],
        ];

        $order = 1;
        foreach ($articles as $article) {
            $filePath = $brainDir . $article['file'];
            
            if (file_exists($filePath)) {
                $content = file_get_contents($filePath);
                
                $slug = Str::slug($article['title']);
                // Handle duplicate slugs by appending something unique if needed
                $originalSlug = $slug;
                $counter = 1;
                while(Document::where('slug', $slug)->exists()) {
                    // Update content if exists instead of creating new
                    $existingDoc = Document::where('slug', $slug)->first();
                    if ($existingDoc->title === $article['title']) {
                        break;
                    }
                    $slug = $originalSlug . '-' . $counter;
                    $counter++;
                }

                Document::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'category_id' => $category->id,
                        'title' => $article['title'],
                        'content' => $content,
                        'is_published' => true,
                        'order' => $order
                    ]
                );
                
                $this->info("Artikel '{$article['title']}' berhasil dimasukkan.");
                $order++;
            } else {
                $this->error("File tidak ditemukan: {$filePath}");
            }
        }
        
        $this->info('Semua artikel KTS berhasil diproses.');
    }
}

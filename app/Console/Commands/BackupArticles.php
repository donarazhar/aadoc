<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup tabel categories dan documents ke format SQL';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tables = ['categories', 'documents'];
        $sql = "-- Backup Artikel Aadoc\n-- Tanggal: " . now()->format('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $this->info("Mengekspor tabel: {$table}");
            $rows = DB::table($table)->get();
            
            // TRUNCATE untuk menimpa data yang ada saat restore
            $sql .= "TRUNCATE TABLE `{$table}`;\n";

            foreach ($rows as $row) {
                $rowArray = (array) $row;
                $keys = implode('`, `', array_keys($rowArray));
                
                $values = array_map(function($val) {
                    if ($val === null) return 'NULL';
                    // Escape single quotes and backslashes
                    $escaped = str_replace(['\\', "'"], ['\\\\', "\'"], $val);
                    // Handle newlines explicitly if needed, but standard SQL string literals accept them
                    $escaped = str_replace("\n", "\\n", $escaped);
                    $escaped = str_replace("\r", "\\r", $escaped);
                    return "'" . $escaped . "'";
                }, array_values($rowArray));
                
                $valuesStr = implode(', ', $values);
                $sql .= "INSERT INTO `{$table}` (`{$keys}`) VALUES ({$valuesStr});\n";
            }
            $sql .= "\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        // Tentukan path penyimpanan (di root folder aplikasi atau storage)
        $directory = storage_path('app/backups');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filename = 'backup_articles_' . date('Y_m_d_His') . '.sql';
        $filepath = $directory . '/' . $filename;
        
        File::put($filepath, $sql);

        $this->info("Backup berhasil dibuat di: {$filepath}");
    }
}

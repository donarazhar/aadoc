<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        $directory = storage_path('app/backups');
        $backups = [];
        
        if (File::exists($directory)) {
            $files = File::files($directory);
            foreach ($files as $file) {
                if ($file->getExtension() === 'sql') {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'size' => round($file->getSize() / 1024, 2) . ' KB',
                        'date' => date('Y-m-d H:i:s', $file->getMTime()),
                        'path' => $file->getPathname()
                    ];
                }
            }
        }
        
        // Urutkan dari yang terbaru
        usort($backups, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return view('admin.backups.index', compact('backups'));
    }

    public function generate()
    {
        Artisan::call('db:backup-articles');
        return redirect()->route('admin.backups.index')->with('success', 'Backup berhasil dibuat!');
    }

    public function download($file)
    {
        $path = storage_path('app/backups/' . $file);
        if (File::exists($path)) {
            return response()->download($path);
        }
        return redirect()->route('admin.backups.index')->with('error', 'File tidak ditemukan.');
    }

    public function destroy($file)
    {
        $path = storage_path('app/backups/' . $file);
        if (File::exists($path)) {
            File::delete($path);
            return redirect()->route('admin.backups.index')->with('success', 'Backup berhasil dihapus.');
        }
        return redirect()->route('admin.backups.index')->with('error', 'File tidak ditemukan.');
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file' // Validasi file diupload
        ]);

        $file = $request->file('backup_file');
        
        // Pastikan ekstensi .sql
        if ($file->getClientOriginalExtension() !== 'sql') {
            return redirect()->route('admin.backups.index')->with('error', 'Harap unggah file SQL.');
        }

        try {
            $sql = file_get_contents($file->getRealPath());
            DB::unprepared($sql);
            return redirect()->route('admin.backups.index')->with('success', 'Database berhasil direstore!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')->with('error', 'Gagal merestore: ' . $e->getMessage());
        }
    }
}


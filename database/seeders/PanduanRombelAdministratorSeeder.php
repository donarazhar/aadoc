<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanRombelAdministratorSeeder extends Seeder
{
    public function run()
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Setup Manajemen Unit Sekolah Role Administrator')],
            [
                'name' => 'Setup Manajemen Unit Sekolah Role Administrator',
                'description' => 'Panduan tahap kedua terkait pengelolaan unit sekolah dan rombongan belajar oleh Administrator.'
            ]
        );
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Rombongan Belajar (Khusus Administrator Pusat)</h1>
        
        <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 1rem; margin-bottom: 2rem; border-radius: 0.25rem;">
            <strong>Catatan Penting:</strong> Artikel ini dikhususkan bagi Anda yang login menggunakan akses <strong>Role Administrator (Pusat/Yayasan)</strong>. Jika Anda adalah Admin Sekolah, silakan merujuk pada panduan pengelolaan Rombel tingkat unit.
        </div>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">1. Siapa yang Berhak Membuat Rombel?</h3>
        <p style="margin-bottom: 1rem;">
            Secara arsitektur sistem, <strong>Rombongan Belajar (Rombel) wajib terikat pada satu Unit Sekolah spesifik</strong>. 
            Oleh karena itu, pembagian tugas antara Administrator Pusat dan Admin Sekolah diatur sebagai berikut:
        </p>
        <ul style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 0.5rem;"><strong>Administrator Pusat bertugas membangun "Rumah":</strong> Tugas Anda adalah mendefinisikan Profil Unit Sekolah (Misal: SDIA 1, SMPIA 2) di dalam sistem, serta mendaftarkan akun untuk Kepala Sekolah/Admin Sekolah terkait.</li>
            <li style="margin-bottom: 0.5rem;"><strong>Admin Sekolah bertugas membagi "Ruangan":</strong> Setelah akun dibuat, Admin Sekolah yang bersangkutan harus login. Karena akun mereka sudah otomatis terikat dengan ID Sekolah mereka, tugas merekalah untuk memecah kelas umum menjadi Rombel riil (Misal: Kelas 1A, Kelas 1B).</li>
        </ul>
        <p style="margin-bottom: 2rem;"><strong>Kesimpulan:</strong> Sebagai Administrator Pusat, Anda <u>tidak perlu (dan tidak disarankan)</u> untuk membuat Rombel secara langsung. Serahkan tugas tersebut kepada masing-masing Admin Sekolah.</p>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">2. Memahami Menu Rombel di Dashboard Pusat</h3>
        <p style="margin-bottom: 1rem;">
            Meskipun Anda tidak disarankan membuat Rombel, Anda tetap memiliki akses pemantauan (<em>monitoring</em>) penuh. 
            Ketika Anda mengklik menu <strong>Rombel</strong> di sidebar kiri, Anda akan diarahkan ke halaman <code>/admin/master/rombel/pusat</code>.
        </p>
        <ul style="margin-left: 1.5rem; margin-bottom: 2rem;">
            <li style="margin-bottom: 0.5rem;"><strong>Tampilan Utama:</strong> Halaman ini tidak langsung menampilkan daftar Rombel (1A, 1B), melainkan <strong>Daftar Unit Sekolah</strong> yang dikelompokkan berdasarkan jenjang (TK, SD, SMP, SMA).</li>
            <li style="margin-bottom: 0.5rem;"><strong>Cara Memantau:</strong> Untuk melihat daftar Rombel dari sebuah sekolah, klik tombol <strong>"View" (Lihat)</strong> pada baris sekolah yang Anda inginkan. Anda akan diarahkan ke detail sekolah tersebut beserta seluruh Rombel yang telah dibuat oleh Admin Sekolah mereka.</li>
        </ul>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">3. Mekanisme Keamanan Sistem (Redirect Rute)</h3>
        <p style="margin-bottom: 1rem;">
            Mungkin Anda bertanya-tanya, <em>"Apa yang terjadi jika saya secara tidak sengaja masuk ke halaman Rombel milik Sekolah dan mencoba mengklik tombol Tambah?"</em>
        </p>
        <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 1rem; border-radius: 0.25rem;">
            Sistem kami telah dilengkapi dengan proteksi berbasis <strong>Role-Based Access Control (RBAC)</strong>. Jika Anda (sebagai Administrator Pusat) secara paksa mengakses halaman manajemen Rombel milik Sekolah lalu mengklik tombol <strong>"Tambah Rombel"</strong>, sistem akan secara otomatis membelokkan arah (<em>redirect</em>) Anda kembali ke struktur <em>path</em> Pusat. Hal ini mencegah terjadinya <em>bug</em> di mana Rombel terbuat namun "menggantung" tanpa terikat ke unit sekolah mana pun.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Rombel Khusus Administrator')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Rombel Khusus Administrator',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 18,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanAdminSekolahMonitoringPendaftaranSeeder extends Seeder
{
    public function run()
    {
        $categoryName = 'Panduan Workflow Admin Sekolah';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Panduan alur kerja untuk Admin Sekolah terkait operasional harian, mulai dari PMB hingga pengaturan rombel.'
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
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Monitoring Pendaftaran: Dari Animo hingga Pembayaran Formulir</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Sebagai <strong>Admin Sekolah</strong>, salah satu peran krusial Anda pada masa Penerimaan Murid Baru (PMB) adalah memastikan bahwa setiap data pendaftar (Animo) yang masuk ke sistem dapat terpantau prosesnya hingga selesai.</p>
        <p style="margin-bottom: 1.5rem;">Workflow pendaftaran aplikasi Al-Azhar Apps dirancang sedemikian rupa agar seluruh pergerakan calon murid dapat dipantau secara otomatis, tanpa perlu rekapitulasi manual. Berikut adalah panduan tahap demi tahap mengenai alur yang akan Anda hadapi saat ada Orang Tua yang mendaftar.</p>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">1. Fase Animo (Pendaftaran Awal)</h4>
        <p><strong>Kondisi:</strong> Orang Tua baru saja membuat akun di aplikasi Al-Azhar Apps dan menambahkan profil anak mereka ke dalam sistem, lalu memilih sekolah Anda (misalnya <em>TK Islam Al-Azhar 1</em>).</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Begitu Orang Tua menyimpan pilihan pendaftaran, data tersebut akan masuk ke <em>database</em> sistem sebagai <strong>Animo Baru</strong>. Sistem akan menghasilkan kode pendaftaran unik dan menerbitkan tagihan <strong>Uang Formulir</strong> secara otomatis.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Buka menu <strong>Dashboard PMB</strong> pada portal sekolah.</li>
                    <li>Anda akan melihat daftar nama calon murid yang baru saja mendaftar.</li>
                    <li>Pada tahap ini, status mereka umumnya adalah <strong>"Menunggu Pembayaran Formulir"</strong>.</li>
                    <li>Jika diperlukan (opsional), Anda dapat menghubungi nomor HP Orang Tua sebagai tindak lanjut (<em>follow-up</em>) batas waktu pembayaran pendaftaran.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">2. Fase Pembayaran Uang Formulir</h4>
        <p><strong>Kondisi:</strong> Orang Tua menyelesaikan pembayaran tagihan Uang Formulir pendaftaran menggunakan kanal pembayaran yang tersedia di aplikasi <em>mobile</em> mereka.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Saat <em>payment gateway</em> mengonfirmasi dana telah masuk, sistem akan mengubah indikator pembayaran menjadi <strong>Lunas</strong> dan mengubah status pendaftar menjadi <strong>"Silahkan Lengkapi Formulir PMB"</strong>.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Ketika Anda menyegarkan (refresh) halaman Dashboard PMB, status calon murid tersebut akan berubah secara otomatis.</li>
                    <li>Anda tidak perlu mencetak kwitansi secara manual atau menandai lunas, karena sistem pendaftaran otomatis menyinkronkan data pembayaran.</li>
                </ul>
            </li>
        </ul>

        <h4 style="color: #1885c4; font-size: 1.25rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem;">3. Fase Pengisian Biodata Lengkap</h4>
        <p><strong>Kondisi:</strong> Karena formulir sudah lunas, sistem akan membuka akses bagi Orang Tua untuk mengisi kelengkapan formulir pendaftaran.</p>
        <ul style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li><strong>Tindakan Otomatis Sistem:</strong> Sistem akan menampilkan tombol <strong>"Lengkapi Formulir"</strong> bagi Orang Tua. Mereka diwajibkan mengisi secara detil data yang mencakup 3 bagian utama: Gelombang, Biodata Lengkap Anak, dan Biodata Orang Tua.</li>
            <li><strong>Tugas Admin Sekolah:</strong>
                <ul style="margin-left: 1.5rem; margin-top: 0.5rem; list-style-type: circle;">
                    <li>Pada tahap ini, Admin Sekolah cukup memantau progres kelengkapan data.</li>
                    <li>Setelah Orang Tua melakukan konfirmasi pengiriman (<em>submit</em>), status pendaftaran calon murid akan kembali diperbarui oleh sistem untuk proses selanjutnya.</li>
                </ul>
            </li>
        </ul>

        <div style="background-color: #f0f9ff; padding: 1rem; border-left: 4px solid #0284c7; border-radius: 0.25rem; margin-bottom: 1.5rem; margin-top: 2rem;">
            <strong style="color: #0284c7;">Praktek Terbaik (Best Practice):</strong><br>
            Pantau menu pendaftaran setidaknya satu atau dua hari sekali pada musim PMB. Jika ada banyak calon murid yang tertahan pada status <strong>"Menunggu Pembayaran Formulir"</strong> lebih dari 3 hari, pertimbangkan untuk mengirimkan pesan pengingat kepada Orang Tua bersangkutan.
        </div>
        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Monitoring Pendaftaran: Dari Animo hingga Pembayaran Formulir')],
            [
                'title' => 'Monitoring Pendaftaran: Dari Animo hingga Pembayaran Formulir',
                'content' => trim($htmlContent),
                'category_id' => $categoryId,
                'created_by' => $userId,
                'is_published' => true,
                'order' => 50,
            ]
        );
    }
}

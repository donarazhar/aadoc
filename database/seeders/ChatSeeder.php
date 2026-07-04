<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => 'ui-ux-mobile-app'],
            [
                'name' => 'UI/UX Mobile App',
                'description' => 'Penjelasan antarmuka, fitur, dan panduan penggunaan halaman pada mobile app Al Azhar Apps untuk orang tua murid.',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        $user = User::first();
        $userId = $user ? $user->id : 1;

        $content = <<<HTML
<p>Menu <strong>Chat</strong> yang dapat diakses melalui deretan ikon menu di bagian bawah layar (<em>Bottom Navigation</em>) merupakan jalur komunikasi resmi yang menghubungkan orang tua murid dengan pihak sekolah atau pusat layanan (Admin/Customer Service) Al Azhar.</p>
<p>Fasilitas ini telah terintegrasi dengan sistem penjadwalan cerdas (<em>smart routing</em>), sehingga antarmukanya akan beradaptasi secara otomatis berdasarkan hari dan jam operasional kerja.</p>

<h3>1. Tampilan Hari Kerja (Senin - Jumat)</h3>
<p>Pada saat jam dan hari operasional aktif, Menu Chat akan menampilkan antarmuka <strong>Ruang Obrolan Langsung (Live Chat Room)</strong>. Anda dapat saling bertukar pesan (mengirim teks, bertanya, atau mengajukan keluhan) dan akan direspons secara langsung (<em>real-time</em>) oleh tim Customer Service kami, mirip dengan aplikasi perpesanan instan pada umumnya.</p>

<h3>2. Tampilan Akhir Pekan (Sabtu - Minggu)</h3>
<p>Apabila Anda mengakses Menu Chat pada saat hari libur akhir pekan atau di luar jam kerja aktif, sistem secara cerdas akan mengganti tampilan Live Chat menjadi <strong>Formulir Tinggalkan Pesan (Offline Message Form)</strong>.</p>
<p>Seperti yang terlihat pada layar, akan muncul instruksi berbunyi <em>"Silakan isi form di bawah ini dan kami akan segera menghubungi Anda"</em>. Anda cukup memastikan data pada kolom berikut:</p>
<ul>
    <li><strong>Nama:</strong> Biasanya sudah terisi secara otomatis (<em>auto-filled</em>) dengan nama akun yang sedang Anda gunakan (contoh: Donar Azhar).</li>
    <li><strong>Email:</strong> Terisi otomatis dengan alamat email terdaftar (contoh: donarazhar@gmail.com).</li>
    <li><strong>Pesan:</strong> Pada kolom kosong ini, ketikkan secara rinci pertanyaan, kendala, atau permohonan informasi yang ingin Anda sampaikan.</li>
</ul>

<h3>3. Mengirim Pesan</h3>
<p>Setelah pesan dirasa cukup jelas, ketuk tombol <strong>Kirim</strong> (ikon pesawat kertas) berwarna biru di bagian bawah. Tiket pesan Anda akan langsung terekam dengan aman ke dalam sistem kami. Begitu jam operasional sekolah kembali aktif pada hari kerja berikutnya, tim Customer Service Al Azhar akan memprioritaskan untuk merespons pesan Anda.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'menu-chat'],
            [
                'category_id' => $category->id,
                'title' => 'Menu Chat (Layanan Komunikasi)',
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 7,
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;

class PmbSeeder extends Seeder
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
<p>Menu <strong>PMB (Penerimaan Murid Baru)</strong> adalah pintu masuk utama bagi orang tua yang ingin mendaftarkan putra-putrinya ke sekolah Al Azhar. Menu ini dapat diakses langsung melalui ikon PMB di halaman Dasbor Utama (Beranda).</p>

<h3>1. Mengisi Formulir PMB</h3>
<p>Formulir pendaftaran dirancang agar praktis diisi melalui <em>smartphone</em> Anda. Pastikan untuk mengisi semua kolom yang memiliki tanda bintang merah (*), yang menandakan bahwa kolom tersebut wajib diisi.</p>

<h4>A. Data Sekolah Tujuan</h4>
<ul>
    <li><strong>Tahun Ajaran & Jenjang:</strong> Pilih tahun ajaran yang tersedia dan jenjang pendidikan (misalnya: TK, SD, SMP, SMA) melalui menu <em>dropdown</em>.</li>
    <li><strong>Tujuan Sekolah, Kelas, & Program:</strong> Kolom-kolom ini pada awalnya akan terkunci (ditandai dengan ikon gembok). Anda baru bisa memilih data pada kolom ini <strong>setelah</strong> Anda menentukan Jenjang Pendidikan di bagian atas.</li>
</ul>

<h4>B. Data Pribadi Calon Murid</h4>
<ul>
    <li><strong>Nama Calon Murid:</strong> Masukkan nama lengkap calon murid sesuai dengan dokumen resmi (Akte Kelahiran).</li>
    <li><strong>Jenis Kelamin:</strong> Pilih jenis kelamin dengan mengetuk pilihan tombol radio: Laki-laki atau Perempuan.</li>
    <li><strong>Tempat & Tanggal Lahir:</strong> Ketik nama kota tempat lahir, lalu gunakan tombol ikon kalender di sebelah kanannya untuk memilih tanggal, bulan, dan tahun lahir dengan mudah tanpa harus mengetik manual.</li>
    <li><strong>Nama Ayah/Ibu:</strong> Masukkan nama lengkap orang tua atau wali murid.</li>
    <li><strong>Alamat:</strong> Masukkan alamat lengkap tempat tinggal saat ini (perhatikan batas maksimal 100 karakter).</li>
</ul>

<h4>C. Kontak & Informasi Tambahan</h4>
<ul>
    <li><strong>Nomor Handphone:</strong> Kolom ini secara otomatis akan terkunci dan terisi dengan nomor handphone/WhatsApp yang Anda gunakan saat mendaftar atau login pertama kali ke Al Azhar Apps.</li>
    <li><strong>Sumber Informasi:</strong> Beritahu kami dari mana Anda mengetahui informasi pendaftaran sekolah ini dengan mencentang satu atau beberapa kotak yang disediakan (seperti <em>Spanduk, Sosial Media, Website, Whatsapp Blast</em>, dll).</li>
</ul>

<h3>2. Tahap Akhir Pendaftaran</h3>
<p>Setelah seluruh kolom formulir Anda pastikan terisi dengan data yang valid dan lengkap, ketuk tombol <strong>Daftar PMB</strong> berwarna biru di bagian bawah layar. Jika Anda ingin membatalkan atau kembali, tekan tombol <strong>Batalkan</strong>.</p>
<p>Setelah pendaftaran berhasil dikirim, sistem akan memproses data Anda dan mengarahkan Anda ke tahap selanjutnya (misalnya proses pembayaran biaya formulir PMB yang akan muncul di menu Tagihan).</p>
HTML;

        Document::updateOrCreate(
            ['slug' => 'panduan-pmb'],
            [
                'category_id' => $category->id,
                'title' => 'Panduan Pendaftaran Murid Baru (PMB)',
                'content' => $content,
                'is_published' => true,
                'created_by' => $userId,
                'order' => 6,
            ]
        );
    }
}

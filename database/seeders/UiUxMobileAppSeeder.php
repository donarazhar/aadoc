<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxMobileAppSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Category
        $category = Category::firstOrCreate(
            ['slug' => 'ui-ux-mobile-app'],
            [
                'name' => 'UI/UX Mobile App',
                'description' => 'Penjelasan antarmuka, fitur, dan panduan penggunaan halaman pada mobile app Al Azhar Apps untuk orang tua murid.',
                'order' => 2,
                'is_hidden' => false,
            ]
        );

        // 2. Create Article Content for "Halaman Login & Registrasi (Selamat Datang)"
        $content = <<<HTML
<p>Halaman <strong>Selamat Datang</strong> adalah antarmuka pertama yang akan Anda (Orang Tua Murid) temui ketika membuka aplikasi Al Azhar Apps. Halaman ini dirancang dengan antarmuka yang bersih dan mudah dipahami, menggabungkan proses masuk (login) dan pendaftaran (registrasi) ke dalam satu alur yang praktis.</p>

<h3>Fitur dan Komponen Halaman</h3>
<p>Berikut adalah penjelasan detail mengenai elemen-elemen yang ada pada halaman ini:</p>

<ul>
    <li>
        <strong>Kolom Input Nomor Handphone:</strong><br>
        Anda diminta untuk memasukkan nomor handphone dengan kode negara (+62 untuk Indonesia). Sangat penting untuk memastikan bahwa nomor yang dimasukkan adalah <strong>nomor WhatsApp yang aktif</strong>. Sistem akan menggunakan nomor ini untuk mengirimkan kode verifikasi (OTP) baik untuk login maupun pendaftaran akun baru.
    </li>
    <li>
        <strong>Tombol "Masuk":</strong><br>
        Setelah memasukkan nomor handphone, tekan tombol biru "Masuk" untuk melanjutkan. Sistem akan secara otomatis mendeteksi apakah nomor Anda sudah terdaftar atau belum, dan mengarahkan Anda ke langkah verifikasi selanjutnya.
    </li>
    <li>
        <strong>Ikon Sidik Jari (Biometrik):</strong><br>
        Di sebelah kanan tombol Masuk, terdapat ikon sidik jari. Fitur ini memungkinkan Anda untuk masuk dengan cepat menggunakan sensor biometrik (sidik jari atau pengenalan wajah) di HP Anda, asalkan Anda sudah pernah berhasil login sebelumnya dan mengaktifkan fitur biometrik ini.
    </li>
    <li>
        <strong>Tautan Kebijakan Privasi:</strong><br>
        Di bagian bawah layar, terdapat tautan menuju <em>Kebijakan Privasi</em>. Dengan menekan tombol Masuk, Anda dianggap menyetujui kebijakan pengelolaan data dan privasi dari Yayasan Pesantren Islam Al Azhar.
    </li>
</ul>

<h3>Langkah Penggunaan Singkat</h3>
<ol>
    <li>Buka aplikasi Al Azhar Apps.</li>
    <li>Ketik nomor WhatsApp aktif Anda pada kolom yang disediakan (tidak perlu mengetik angka 0 di depan jika kode negara +62 sudah terpilih).</li>
    <li>Ketuk tombol <strong>Masuk</strong>.</li>
    <li>Tunggu pesan WhatsApp masuk yang berisi kode verifikasi OTP, lalu masukkan kode tersebut di layar berikutnya.</li>
</ol>
HTML;

        // 3. Create Document: Halaman Selamat Datang
        Document::updateOrCreate(
            ['slug' => 'halaman-selamat-datang-login'],
            [
                'category_id' => $category->id,
                'title' => 'Login & Registrasi',
                'content' => $content,
                'is_published' => true,
                'created_by' => 1,
                'order' => 1,
            ]
        );

        // 4. Create Article Content for "Halaman Masukkan PIN"
        $pinContent = <<<HTML
<p>Setelah Anda memasukkan nomor handphone atau melewati tahap awal login, langkah pengamanan selanjutnya adalah halaman <strong>Masukkan PIN</strong>. Halaman ini berfungsi sebagai lapisan keamanan untuk melindungi data pribadi dan aktivitas Anda di dalam aplikasi Al Azhar Apps.</p>

<h3>Fitur dan Komponen Halaman</h3>
<p>Berikut adalah komponen utama pada antarmuka ini:</p>
<ul>
    <li><strong>Tombol Kembali (Panah Kiri):</strong> Berada di pojok kiri atas, berfungsi untuk membatalkan proses dan kembali ke halaman Selamat Datang.</li>
    <li><strong>Indikator PIN (6 Digit):</strong> Terdapat enam buah titik yang akan berubah warna ketika Anda mengetikkan angka. Aplikasi ini mewajibkan penggunaan PIN sepanjang 6 digit untuk keamanan maksimal.</li>
    <li><strong>Tautan Reset PIN:</strong> Jika Anda melupakan PIN Anda, Anda dapat menekan tautan <em>"Lupa PIN? klik Reset PIN"</em>. Sistem akan memandu Anda melakukan prosedur pemulihan (umumnya dengan mengirimkan kode OTP ke WhatsApp Anda).</li>
    <li><strong>Keypad Angka Virtual:</strong> Terdapat tombol angka 0 hingga 9 yang didesain ergonomis, besar, dan jelas agar mudah ditekan di layar ponsel.</li>
    <li><strong>Ikon Mata (Sembunyikan/Tampilkan PIN):</strong> Terletak di pojok kiri bawah keypad, fitur ini sangat berguna jika Anda ingin mengintip/memastikan angka PIN yang Anda tekan sudah benar.</li>
    <li><strong>Ikon Hapus (Backspace):</strong> Terletak di pojok kanan bawah keypad, digunakan untuk menghapus angka terakhir yang Anda masukkan jika terjadi kesalahan ketik.</li>
    <li><strong>Tombol Masuk:</strong> Tombol biru di bagian bawah layar yang digunakan untuk memproses login Anda setelah seluruh digit PIN dimasukkan.</li>
</ul>

<h3>Panduan Penggunaan Singkat</h3>
<ol>
    <li>Perhatikan 6 titik indikator di atas keypad. Gunakan keypad angka yang tersedia di layar untuk memasukkan 6 digit PIN rahasia akun Anda.</li>
    <li>Jika ragu, Anda bisa menekan tombol <strong>ikon mata</strong> untuk melihat angka yang Anda ketik.</li>
    <li>Jika salah ketik, tekan ikon <strong>Hapus (Backspace)</strong>.</li>
    <li>Jika Anda benar-benar lupa PIN, langsung klik tulisan <strong>Reset PIN</strong>.</li>
    <li>Setelah 6 digit terisi penuh, ketuk tombol <strong>Masuk</strong> untuk memverifikasi. Jika PIN benar, Anda akan diarahkan ke dasbor utama aplikasi.</li>
</ol>
HTML;

        // 5. Create Document: Halaman Masukkan PIN
        Document::updateOrCreate(
            ['slug' => 'halaman-masukkan-pin'],
            [
                'category_id' => $category->id,
                'title' => 'Verifikasi PIN',
                'content' => $pinContent,
                'is_published' => true,
                'created_by' => 1,
                'order' => 2,
            ]
        );

        // 6. Create Article Content for "Halaman Beranda"
        $berandaContent = <<<HTML
<p>Setelah berhasil melewati verifikasi PIN, Anda akan diarahkan ke <strong>Halaman Beranda</strong>. Halaman ini adalah pusat kendali utama (dasbor) dari aplikasi Al Azhar Apps yang didesain agar Anda dapat mengakses semua fitur dan informasi penting dengan cepat.</p>

<h3>Komponen Utama Halaman Beranda</h3>
<p>Berikut adalah rincian elemen dan fitur yang tersedia di halaman ini:</p>

<ul>
    <li>
        <strong>Sapaan Pengguna:</strong><br>
        Di bagian atas halaman, Anda akan melihat sapaan "Assalamualaikum" diikuti dengan nama Anda, memberikan sentuhan personal pada aplikasi.
    </li>
    <li>
        <strong>Menu Akses Cepat (Grid Ikon):</strong><br>
        Kumpulan ikon menu utama yang paling sering digunakan, meliputi:
        <ul>
            <li><strong>PMB:</strong> Informasi Penerimaan Murid Baru.</li>
            <li><strong>Tagihan:</strong> Pengecekan tagihan sekolah (titik merah menandakan adanya notifikasi atau tagihan yang perlu diperhatikan).</li>
            <li><strong>Lokasi:</strong> Informasi dan peta sekolah.</li>
            <li><strong>Aktifitas:</strong> Laporan kegiatan dan aktivitas.</li>
            <li><strong>Layanan Islami:</strong> Fitur penunjang ibadah harian seperti panduan Sholat, arah Qiblah, kumpulan Doa, dan Al Quran digital.</li>
        </ul>
        Terdapat juga tombol <strong>Menu Lainnya</strong> untuk menampilkan menu-menu tambahan.
    </li>
    <li>
        <strong>Banner Informasi (Carousel):</strong><br>
        Sebuah <em>slider</em> gambar dinamis yang menampilkan informasi terkini, pengumuman sekolah, kegiatan, atau peringatan hari besar (seperti Hari Anak Nasional). Anda dapat menggesernya ke samping untuk melihat gambar lainnya.
    </li>
    <li>
        <strong>Widget Infaq:</strong><br>
        Panel informasi khusus untuk transparansi donasi, menampilkan Total Keseluruhan Infaq Sekolah. Anda dapat menekan tombol <strong>Infaq</strong> untuk berpartisipasi atau <strong>Detail</strong> untuk melihat riwayat secara lengkap.
    </li>
    <li>
        <strong>Jadwal Shalat:</strong><br>
        Menampilkan jadwal shalat lima waktu (Subuh, Dzuhur, Ashar, Maghrib, Isya) secara <em>real-time</em> yang menyesuaikan dengan lokasi Anda saat ini (contoh: Kota Adm. Jakarta Selatan). Terdapat juga ikon ilustrasi waktu pada masing-masing jadwal dan ikon perbarui (refresh) di sudut kanan.
    </li>
    <li>
        <strong>Majalah Digital:</strong><br>
        Di bagian bawah layar, terdapat rak virtual untuk <em>Majalah Al Azhar</em>. Anda dapat menggesernya ke samping (horizontal) untuk melihat edisi-edisi majalah (ditandai dengan label "NEW" untuk edisi terbaru). Tersedia pula tautan <strong>Lihat Semua</strong> untuk menjelajahi koleksi majalah secara lengkap.
    </li>
    <li>
        <strong>Bilah Navigasi Bawah (Bottom Navigation):</strong><br>
        Menu utama aplikasi yang selalu tampil di bagian bawah layar:
        <ul>
            <li><strong>Beranda:</strong> Kembali ke halaman dasbor utama ini.</li>
            <li><strong>Anak:</strong> Menu khusus untuk memantau profil, nilai, dan perkembangan anak Anda di sekolah.</li>
            <li><strong>Chat:</strong> Fitur pesan untuk berkomunikasi langsung dengan pihak sekolah atau guru.</li>
            <li><strong>Akun:</strong> Menu untuk mengatur profil, pengaturan privasi, dan keamanan.</li>
        </ul>
    </li>
</ul>

<p>Semua informasi dirancang dalam tata letak yang bersih dan modern agar Anda merasa nyaman menggunakan Al Azhar Apps sebagai solusi pendidikan terpadu.</p>
HTML;

        // 7. Create Document: Halaman Beranda
        Document::updateOrCreate(
            ['slug' => 'halaman-beranda-utama'],
            [
                'category_id' => $category->id,
                'title' => 'Dasbor Beranda',
                'content' => $berandaContent,
                'is_published' => true,
                'created_by' => 1,
                'order' => 3,
            ]
        );
    }
}

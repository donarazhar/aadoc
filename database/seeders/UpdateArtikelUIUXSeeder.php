<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class UpdateArtikelUIUXSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Update Seri 1 (Dashboard dan Transaksi PMB)
        $doc1 = Document::where('title', 'Seri 1: Anatomi UI/UX Dashboard dan Transaksi')->first();
        if ($doc1) {
            $addon1 = <<<HTML
<hr>
<h3>Arsitektur Sistem Sebenarnya (Backend Logic)</h3>
<p>Di balik form UI Pembuatan Gelombang PMB yang tampak sederhana, sistem *Backend* (<code>school-service-new</code>) sebenarnya melakukan penjagaan ganda (*Dual Validation*) yang sangat ketat:</p>
<ul>
    <li><strong>Validasi Bentrok Gelombang (CheckActiveBatch):</strong> Jika Admin menekan tombol Simpan, sistem akan mengecek apakah masih ada gelombang yang berstatus Aktif untuk sekolah dan jenjang yang sama. Jika ada, UI akan memunculkan *Error BadRequest* dan menolak pembuatan gelombang baru.</li>
    <li><strong>Validasi Kuota Penuh (CheckTargetSchool):</strong> Sistem juga menghitung kapasitas bangku kosong. Jika jumlah murid baru sudah mencapai Target Kuota yang ditetapkan Yayasan, sistem otomatis menolak pembukaan gelombang pendaftaran tambahan demi mencegah kelebihan kapasitas (<em>Overcapacity</em>).</li>
    <li><strong>Penerbitan NIS Aman:</strong> Setelah calon murid diluluskan, sistem tidak lagi menggunakan logika urutan mentah untuk membuat Nomor Induk Siswa (NIS). Sistem menggunakan kalkulasi <code>lpad(right(cast(id AS text), 3), 3, '0')</code> untuk mengambil 3 digit ID terakhir secara presisi, mencegah kegagalan sistem saat pendaftar mencapai ribuan anak.</li>
</ul>
HTML;
            if (strpos($doc1->content, 'Arsitektur Sistem Sebenarnya') === false) {
                $doc1->content .= $addon1;
                $doc1->save();
            }
        }

        // 2. Update Seri 4 (Administrasi Biaya)
        $doc4 = Document::where('title', 'Seri 4: Anatomi UI/UX Administrasi Biaya (Daftar Ulang)')->first();
        if ($doc4) {
            $addon4 = <<<HTML
<hr>
<h3>Arsitektur Sistem Sebenarnya (Backend Logic)</h3>
<p>Halaman Administrasi Biaya (seperti Uang Daftar Ulang dan Uang SPP) telah menerapkan <strong>Pengetatan Hak Akses Sentralistis (Role-Based Restriction)</strong> tingkat tinggi pada sisi *Frontend* (NextJS):</p>
<ul>
    <li><strong>Tombol Aksi Disembunyikan (Hidden UX):</strong> Jika Anda <em>login</em> sebagai Admin Sekolah/Unit, Anda tidak akan menemukan tombol <strong>Edit (Pensil)</strong>, <strong>Hapus (Tempat Sampah)</strong>, atau tombol <strong>Eksekusi Tagihan (Ceklis Generate)</strong> di layar Anda. Layar Anda hanya bersifat *Read-Only* (Hanya bisa melihat/Zoom).</li>
    <li><strong>Kekuasaan Superadmin:</strong> Semua tombol krusial pembuat tagihan tersebut kini dirancang untuk <strong>hanya muncul (di-*render*)</strong> jika pengguna memiliki hak akses tertinggi, yaitu <code>role_id = 1</code> (Admin Pusat Yayasan). Ini mencegah Admin Unit secara sepihak memodifikasi besaran tagihan tanpa izin Pusat.</li>
</ul>
HTML;
            if (strpos($doc4->content, 'Arsitektur Sistem Sebenarnya') === false) {
                $doc4->content .= $addon4;
                $doc4->save();
            }
        }

        // 3. Update Seri 5 (Manajemen User & Jurnal/E-Rapot)
        $doc5 = Document::where('title', 'Seri 5: Anatomi UI/UX Manajemen User dan E-Rapot')->first();
        if ($doc5) {
            $addon5 = <<<HTML
<hr>
<h3>Arsitektur Sistem Sebenarnya (Backend Logic)</h3>
<p>Untuk formulir yang melibatkan pengunggahan (*upload*) dokumen fisik, sistem kini menerapkan batasan efisiensi dan keamanan jaringan yang sangat ketat:</p>
<ul>
    <li><strong>Penyusutan Kapasitas (1MB Limit):</strong> Pada halaman pengisian <strong>Jurnal Mengajar Guru</strong> dan <strong>Pengajuan Diskon Prestasi</strong>, *Frontend* membatasi ukuran maksimal *file* (foto/PDF) dari yang sebelumnya 2MB kini menjadi <strong>maksimal 1MB</strong>. Langkah ini menghemat ruang server penyimpanan AWS S3 secara drastis.</li>
    <li><strong>Pencegahan Server Hang (Auto-Timeout):</strong> Di balik layar *Backend* pengunggahan dokumen (*student-discount-usecase*), diterapkan konteks *Timeout 30 Detik*. Artinya, jika internet pengguna sedang lambat dan proses unggah berjalan terlalu lama, sistem akan memutus (membatalkan) koneksi pada detik ke-30 secara rapi, mencegah aplikasi mengalami <em>loading</em> abadi (<em>Hang</em>).</li>
    <li><strong>Arsitektur Error Pembayaran:</strong> Jika terjadi masalah pada pembayaran <em>Virtual Account</em> DOKU, sistem *Backend* kini menggunakan pola <em>Error Builder</em> mutakhir yang merekam jejak (*Stack Trace*) kegagalan langkah demi langkah (Misal: Kode Error "01", "02") sehingga proses <em>Debugging</em> sangat akurat.</li>
</ul>
HTML;
            if (strpos($doc5->content, 'Arsitektur Sistem Sebenarnya') === false) {
                $doc5->content .= $addon5;
                $doc5->save();
            }
        }
    }
}

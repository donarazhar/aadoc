<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;

class UpdateVendorJuli17Seeder extends Seeder
{
    public function run(): void
    {
        // 1. Update Artikel SOP Finansial ALAZHARAPPS
        $doc1 = Document::where('title', 'Panduan Proses Bisnis: Siklus Administratif & Finansial ALAZHARAPPS')->first();
        if ($doc1) {
            $addon1 = <<<HTML
<hr>
<h3>Pembaruan Sistem (17 Juli 2026): Arsitektur Split Settlement & Ekspansi Daycare</h3>
<p>Berdasarkan pembaruan terkini dari vendor, terdapat dua perubahan fundamental dalam proses bisnis:</p>
<ul>
    <li><strong>Keuangan - Mekanisme Split Settlement (Pembelahan Dana):</strong> Saat orang tua melakukan pembayaran via *Virtual Account* DOKU, sistem <em>Backend</em> secara pintar akan membelah uang masuk ke dalam 2 saluran rekening yang berbeda:
        <ul>
            <li><strong>Rekening Pusat (Yayasan):</strong> Uang Sekolah (SPP), Uang Pangkal, Seragam, Medis, Kegiatan, dan <strong>School Fee</strong>.</li>
            <li><strong>Rekening Sekolah (Unit Daerah):</strong> Uang Observasi, Jamiyah (POMG), EKD, dan OSIS.</li>
        </ul>
        Perubahan ini membuat rekonsiliasi dana menjadi terdesentralisasi namun tetap terpantau ketat secara terpusat.
    </li>
    <li><strong>Operasional PMB - Jalur Bypass Daycare:</strong> Al-Azhar Apps kini secara resmi melayani bisnis <em>Daycare</em> (Penitipan Anak). Berbeda dengan PMB Reguler yang panjang, sistem memiliki jalur *bypass* (Fungsi <code>CreateDaycare</code>). Ketika Admin mendaftarkan anak Daycare, sistem akan otomatis menerbitkan tagihan (FEE) tanpa harus melalui siklus pendaftaran PMB yang normal.</li>
</ul>
HTML;
            if (strpos($doc1->content, 'Arsitektur Split Settlement') === false) {
                $doc1->content .= $addon1;
                $doc1->save();
            }
        }

        // 2. Update Artikel Modul Sekolah Menu Rombel
        $doc2 = Document::where('title', 'Modul Sekolah Menu Rombel')->first();
        if ($doc2) {
            $addon2 = <<<HTML
<hr>
<h3>Pembaruan Sistem (17 Juli 2026): Pembersihan Ghost Absent</h3>
<p><strong>Logika Backend Pemindahan Rombel:</strong> Terdapat satu kecerdasan *Backend* yang ditambahkan untuk mencegah <em>Bug</em> Data. Saat Admin mengeluarkan (*Remove*) seorang siswa dari sebuah Rombel (Kelas), sistem akan secara otomatis mereset nomor urut absen siswa tersebut (<code>absent_number = nil</code>). Ini memastikan tidak ada lagi "Nomor Absen Hantu" atau nomor yang ganda ketika siswa dipindahkan ke kelas lain, membuat urutan presensi kelas menjadi selalu presisi.</p>
HTML;
            if (strpos($doc2->content, 'Pembersihan Ghost Absent') === false) {
                $doc2->content .= $addon2;
                $doc2->save();
            }
        }
        
        // 3. Update Label UI di Artikel Terkait
        $doc3 = Document::where('title', 'Seri 4: Anatomi UI/UX Administrasi Biaya (Daftar Ulang)')->first();
        if ($doc3) {
            $addon3 = <<<HTML
<hr>
<h3>Pembaruan Sistem (Kosmetik UI - 17 Juli 2026)</h3>
<p>Sistem <em>Frontend</em> telah mengalami penyesuaian teks/kosakata (*Wording*). Label "Jenis Tagihan" pada *Tab* Keuangan telah diubah tata bahasanya agar lebih intuitif dan ramah pengguna (terutama untuk orang tua yang membaca kwitansi digital).</p>
HTML;
            if (strpos($doc3->content, 'Kosmetik UI - 17 Juli') === false) {
                $doc3->content .= $addon3;
                $doc3->save();
            }
        }
    }
}

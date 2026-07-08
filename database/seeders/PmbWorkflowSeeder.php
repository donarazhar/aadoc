<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class PmbWorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryName = 'Panduan Penggunaan Aplikasi bagi OTM';
        $category = Category::firstOrCreate(
            ['slug' => Str::slug($categoryName)],
            [
                'name' => $categoryName,
                'description' => 'Kumpulan panduan dan tutorial penggunaan Al Azhar Apps khusus untuk Orang Tua Murid.',
                'order' => 6
            ]
        );

        $title = 'Alur Lengkap PMB (Pendaftaran Murid Baru): Reguler & Cicilan';

        $content = '
<h2 style="color: #0f172a; font-weight: bold; font-size: 1.5rem; margin-bottom: 0.5rem; text-align: center;">Alur Lengkap Penerimaan Murid Baru (PMB)</h2>
<p style="color: #64748b; margin-bottom: 1.5rem; text-align: center;">Terdapat dua jenis alur pendaftaran: <strong>Tanpa Cicilan (Reguler)</strong> dan <strong>Dengan Cicilan</strong>, tergantung pilihan skema pembayaran Uang Pangkal.</p>

<div style="display: flex; justify-content: center; gap: 24px; margin-bottom: 2.5rem; font-family: sans-serif; font-size: 0.85rem;">
    <div style="display: flex; align-items: center; gap: 6px;"><span style="width: 12px; height: 12px; background-color: #1885C4; border-radius: 50%; display: inline-block;"></span> Backoffice Team (Sekolah)</div>
    <div style="display: flex; align-items: center; gap: 6px;"><span style="width: 12px; height: 12px; background-color: #22c55e; border-radius: 50%; display: inline-block;"></span> Orang Tua / Murid (OTM)</div>
</div>

<h3 style="color: #0f172a; font-size: 1.3rem; text-align: center; background-color: #eff6ff; padding: 10px; border-radius: 8px; margin-bottom: 1.5rem;">A. Alur PMB — Tanpa Cicilan (Reguler)</h3>

<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 2rem; font-family: sans-serif;">
    <div style="width: 150px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">1</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Pendaftaran Awal &<br>Bayar Formulir</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">2</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Ujian Masuk</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #f8fafc; border: 2px solid #1885C4; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #1885C4; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">3</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Pengumuman<br>Kelulusan</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #f0fdf4; border: 2px solid #22c55e; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #22c55e; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">4</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Bayar Uang Pangkal<br>& Aktivasi</div>
    </div>
</div>

<div style="font-family: sans-serif; color: #334155; line-height: 1.6; font-size: 0.95rem; margin-bottom: 2.5rem;">

    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 1: Pendaftaran Awal & Pembayaran Formulir</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Login ke aplikasi Al Azhar Apps dengan nomor handphone dan PIN Anda.</li>
        <li>Pada halaman Beranda, pilih menu <strong>PMB</strong>, lalu tekan tombol <strong>Daftar Sekarang</strong> untuk melakukan pendaftaran awal (Animo).</li>
        <li>Isi form biodata awal (Tahun Ajaran, Jenjang, Sekolah Tujuan, Nama Anak, dll) lalu tekan <strong>Daftar PMB</strong>.</li>
        <li>Status anak akan berada pada "Menunggu Pembayaran Formulir". Tekan <strong>Ke Halaman Tagihan</strong>, centang tagihan <strong>Formulir Pendaftaran</strong>, lalu selesaikan pembayaran (misal via QRIS).</li>
        <li>Setelah pembayaran berhasil, lengkapi data <strong>Asal Sekolah</strong> dan <strong>Profil Murid</strong> secara menyeluruh, lalu tekan <strong>Ajukan</strong>.</li>
        <li style="color: #64748b;"><em>Catatan: Sebelum gelombang pendaftaran dibuka, pihak sekolah (Backoffice) telah menyiapkan komponen Uang Pangkal, Uang Sekolah, dan jadwal Gelombang Pendaftaran di sistem.</em></li>
    </ul>

    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 2: Ujian Masuk</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Setelah data diverifikasi sekolah, Anda akan menerima <strong>Kartu Ujian</strong> di aplikasi.</li>
        <li>Buka profil anak di menu PMB untuk melihat dan mengunduh <strong>Kartu Peserta Ujian Masuk</strong>. Kartu ini wajib ditunjukkan saat jadwal ujian berlangsung.</li>
        <li>Anak mengikuti ujian sesuai jadwal yang ditentukan sekolah.</li>
    </ul>

    <h4 style="color: #1885C4; font-size: 1.05rem; margin-bottom: 10px;">Tahap 3: Penilaian & Pengumuman Kelulusan</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li style="color: #64748b;"><em>Di balik layar, pihak sekolah menginput dan mengunggah hasil nilai ujian ke sistem, kemudian meluluskan calon murid yang memenuhi syarat.</em></li>
        <li>Anda akan menerima notifikasi bahwa anak <strong>LULUS</strong> seleksi, sekaligus notifikasi syarat & ketentuan Uang Pangkal (UP).</li>
        <li>Buka menu syarat & ketentuan untuk melihat rincian komponen biaya UP.</li>
        <li>Tekan <strong>Setuju</strong> untuk menerima file PDF detail komponen UP.</li>
    </ul>

    <h4 style="color: #22c55e; font-size: 1.05rem; margin-bottom: 10px;">Tahap 4: Pembayaran Uang Pangkal & Aktivasi</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Tagihan Uang Pangkal (UP) akan muncul di menu <strong>Tagihan</strong> aplikasi Anda.</li>
        <li>Lakukan pembayaran komponen UP secara penuh melalui metode pembayaran yang tersedia (misal QRIS).</li>
        <li>Setelah pembayaran berhasil dikonfirmasi, status anak berubah menjadi <strong>Aktif</strong> dan resmi terdaftar sebagai siswa.</li>
    </ul>
</div>

<hr style="border: none; border-top: 2px solid #e2e8f0; margin: 2.5rem 0;">

<h3 style="color: #0f172a; font-size: 1.3rem; text-align: center; background-color: #fdf4ff; padding: 10px; border-radius: 8px; margin-bottom: 1.5rem;">B. Alur PMB — Dengan Cicilan Uang Pangkal</h3>

<p style="color: #64748b; text-align: center; margin-bottom: 1.5rem; font-family: sans-serif;">Alur ini digunakan bagi orang tua yang ingin membayar Uang Pangkal secara bertahap (angsuran), bukan sekaligus lunas.</p>

<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-bottom: 2rem; font-family: sans-serif;">
    <div style="width: 150px; background-color: #f5f3ff; border: 2px solid #7c3aed; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #7c3aed; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">1</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Persiapan Sekolah</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #f0fdf4; border: 2px solid #16a34a; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #16a34a; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">2</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Ujian</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #fff7ed; border: 2px solid #ea580c; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #ea580c; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">3</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Pengumuman &<br>Syarat UP</div>
    </div>
    <div style="display: flex; align-items: center; color: #cbd5e1;">&#10142;</div>
    <div style="width: 150px; background-color: #fdf2f8; border: 2px solid #db2777; border-radius: 8px; padding: 12px; text-align: center;">
        <div style="background-color: #db2777; color: white; width: 24px; height: 24px; border-radius: 50%; font-weight: bold; font-size: 0.8rem; line-height: 24px; margin: 0 auto 8px;">4</div>
        <div style="color: #0f172a; font-weight: bold; font-size: 0.85rem; line-height: 1.3;">Pembayaran &<br>Aktivasi</div>
    </div>
</div>

<div style="font-family: sans-serif; color: #334155; line-height: 1.6; font-size: 0.95rem;">

    <h4 style="color: #7c3aed; font-size: 1.05rem; margin-bottom: 10px;">Fase 1: Persiapan Sekolah, Pendaftaran, & Ujian</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Proses pendaftaran, pembayaran formulir, pelengkapan identitas, hingga pelaksanaan ujian pada alur cicilan ini <strong>sama persis</strong> dengan alur Tanpa Cicilan pada bagian A (Tahap 1 dan 2 di atas).</li>
        <li>Perbedaan baru muncul setelah pengumuman kelulusan terbit.</li>
    </ul>

    <h4 style="color: #ea580c; font-size: 1.05rem; margin-bottom: 10px;">Fase 2: Pengumuman Kelulusan & Syarat Uang Pangkal</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li>Anda akan menerima notifikasi kelulusan yang berisi syarat & ketentuan Uang Pangkal (UP).</li>
        <li>Baca dan pahami surat pernyataan yang diberikan, lalu tekan <strong>Setuju</strong> untuk menerima file PDF detail komponen UP.</li>
        <li>Jika Anda berencana membayar UP secara cicilan, <strong>datangi langsung pihak sekolah (Tata Usaha)</strong> untuk mengajukan permohonan skema angsuran. Pengajuan cicilan saat ini dilakukan secara luring (tatap muka), bukan melalui aplikasi.</li>
    </ul>

    <h4 style="color: #db2777; font-size: 1.05rem; margin-bottom: 10px;">Fase 3: Pengajuan & Persetujuan Angsuran</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li style="color: #64748b;"><em>Setelah Anda mengajukan permohonan cicilan, pihak sekolah akan memprosesnya di sistem sesuai ketentuan jumlah angsuran yang telah ditetapkan Yayasan.</em></li>
        <li>Jika permohonan cicilan <strong>lebih dari 3 kali angsuran</strong>, sekolah akan meneruskan permohonan tersebut ke <strong>Direktorat Keuangan</strong> untuk mendapat persetujuan khusus.</li>
        <li>Anda perlu menunggu proses <strong>approval</strong> dari Direktorat Keuangan sebelum skema cicilan resmi berlaku.</li>
    </ul>

    <h4 style="color: #db2777; font-size: 1.05rem; margin-bottom: 10px;">Fase 4: Pembayaran Bertahap & Aktivasi</h4>
    <ul style="margin-bottom: 1.5rem; padding-left: 1.2rem;">
        <li style="background-color: #fef9c3; padding: 10px; border-radius: 6px; border-left: 4px solid #eab308;"><strong>Ketentuan penting:</strong> Status anak baru akan diproses aktif apabila pembayaran termin/angsuran <strong>pertama</strong> sudah mencapai minimal <strong>50% dari total Uang Pangkal</strong>.</li>
        <li>Setelah skema cicilan disetujui, tagihan Uang Pangkal akan muncul di menu <strong>Tagihan</strong> aplikasi Anda, sudah disesuaikan dengan jadwal cicilan yang ditetapkan.</li>
        <li>Lakukan pembayaran setiap termin sesuai akad/perjanjian cicilan yang telah disetujui.</li>
        <li>Setelah syarat minimal termin pertama (50%) terpenuhi, status anak menjadi <strong>Aktif</strong>, dan pihak sekolah (Tata Usaha) akan menempatkan anak ke Rombongan Belajar (Rombel) yang sesuai.</li>
    </ul>

</div>

<div style="background-color: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 1.2rem; margin-top: 1rem; font-family: sans-serif; color: #1e3a8a; font-size: 0.9rem;">
    <strong>Ringkasan Perbedaan:</strong> Alur Tanpa Cicilan dan Alur Cicilan sama persis mulai dari pendaftaran awal hingga pengumuman kelulusan. Perbedaan utama terletak setelah anak dinyatakan lulus: pada alur Tanpa Cicilan, Uang Pangkal langsung dibayar lunas untuk aktivasi; sedangkan pada alur Cicilan, orang tua perlu mengajukan permohonan angsuran langsung ke sekolah, menunggu persetujuan (termasuk dari Direktorat Keuangan bila lebih dari 3 kali angsuran), lalu melunasi minimal 50% pada termin pertama sebelum anak dapat diaktifkan.
</div>
';

        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => $content,
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}
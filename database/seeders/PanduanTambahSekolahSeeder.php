<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanTambahSekolahSeeder extends Seeder
{
    public function run()
    {
        $category = Category::where('slug', Str::slug('Setup Manajemen Unit Sekolah Role Administrator'))->first();
        if (!$category) {
            $category = Category::firstOrCreate(
                ['slug' => Str::slug('Setup Manajemen Unit Sekolah Role Administrator')],
                [
                    'name' => 'Setup Manajemen Unit Sekolah Role Administrator',
                    'description' => 'Panduan tahap kedua terkait pengelolaan unit sekolah dan rombongan belajar oleh Administrator.'
                ]
            );
        }
        $categoryId = $category->id;

        $user = User::firstOrCreate(
            ['email' => 'admin_doc@alazhar.id'],
            ['name' => 'Admin Doc', 'password' => bcrypt('password')]
        );
        $userId = $user->id;

        $htmlContent = '
        <div style="font-family: sans-serif; line-height: 1.6; color: #334155;">
        <h1 style="color: #0f172a; font-size: 2.25rem; font-weight: 800; border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; margin-bottom: 1rem;">Panduan Menambahkan Profil Sekolah (Unit)</h1>
        <p style="font-size: 1.125rem; margin-bottom: 2rem;">Artikel ini memandu Anda dalam menambahkan profil lengkap untuk setiap unit sekolah yang berada di bawah Yayasan Pesantren Islam Al-Azhar (seperti TKIA, SDIA, SMPIA, SMAIA). Data ini akan menjadi pondasi bagi modul Penerimaan Murid Baru (PMB) dan penempatan Rombel.</p>

        <h3 style="color: #0f172a; font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem;">Langkah-Langkah Pengisian Formulir Profil Sekolah</h3>
        
        <ol style="margin-left: 1.5rem; margin-bottom: 1.5rem;">
            <li style="margin-bottom: 0.75rem;">
                <strong>Navigasi Menu:</strong> Dari layar admin utama, silakan akses <strong>Sekolah &gt; Profil Sekolah</strong>. Kemudian klik tombol <strong>Tambah Data</strong>.<br>
                <em>(Atau Anda dapat langsung mengakses rute: <code style="background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem;">admin/sekolah/add-school</code>)</em>.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Kolom Jenjang (Wajib):</strong> 
                Pilih jenjang pendidikan sekolah tersebut dari menu <em>dropdown</em> (Misal: TK, SD, SMP, SMA). Pilihan jenjang ini akan berpengaruh besar terhadap otomatisasi modul diskon dan kelas di menu lainnya.
                <div style="background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Perbaikan Sistem Terkini:</strong> Sebelumnya, dropdown Jenjang ini mungkin terlihat kosong karena adanya kesalahan pemanggilan kolom (<em>column "updated_at" does not exist</em>) di database inti. Kendala teknis tersebut sudah diperbaiki sehingga pilihan jenjang kini sudah bisa Anda klik dan gunakan.
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Identitas Institusi (Wajib):</strong> 
                Lengkapi nama institusi (Misal: SD Islam Al-Azhar 1), beserta kode-kode identitas resmi sekolah.
                <div style="background-color: #f8fafc; border-left: 4px solid #94a3b8; padding: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; border-radius: 0.25rem;">
                    <strong>Glosarium Singkatan Identitas Sekolah:</strong>
                    <ul style="margin-top: 0.5rem; margin-bottom: 0;">
                        <li><strong>NPSN (Nomor Pokok Sekolah Nasional):</strong> Kode unik standar yang ditetapkan oleh Kemendikbud untuk mengenali setiap satuan pendidikan secara nasional.</li>
                        <li><strong>NSS (Nomor Statistik Sekolah):</strong> Nomor unik yang diberikan oleh dinas pendidikan tingkat provinsi/kabupaten sebagai data statistik sekolah.</li>
                        <li><strong>No IJOP (Izin Operasional):</strong> Nomor surat izin sah beroperasinya sekolah yang dikeluarkan oleh pemerintah daerah atau instansi terkait.</li>
                        <li><strong>NIS (Nomor Induk Sekolah):</strong> Nomor registrasi internal atau identitas yang diberikan kepada sekolah itu sendiri.</li>
                        <li><strong>NPWP (Nomor Pokok Wajib Pajak):</strong> Nomor identitas pajak atas nama institusi/yayasan sekolah tersebut.</li>
                    </ul>
                </div>
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Profil Pimpinan (Wajib):</strong> 
                Masukkan nama lengkap Kepala Sekolah beserta dengan nomor handphone dan email aktifnya. Anda juga dapat menambahkan data Wakil Kepala Sekolah 1 & 2 di kolom yang tersedia.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Alamat &amp; Kontak Sekolah:</strong> 
                Tentukan provinsi, kabupaten, kecamatan, hingga kelurahan dari lokasi fisik gedung sekolah. Jangan lupa melengkapi informasi RT/RW, Kode Pos, serta kontak sosial media institusi.
            </li>
            <li style="margin-bottom: 0.75rem;">
                <strong>Penyimpanan:</strong> 
                Setelah memastikan semua field terisi dengan benar (terutama field yang berlabel merah/wajib), klik tombol <strong>Simpan</strong> di kanan bawah.
            </li>
        </ol>

        </div>
        ';

        Document::updateOrCreate(
            ['slug' => Str::slug('Panduan Menambahkan Profil Sekolah')],
            [
                'category_id' => $categoryId,
                'title' => 'Panduan Menambahkan Profil Sekolah',
                'content' => trim($htmlContent),
                'is_published' => true,
                'created_by' => $userId,
                'order' => 18,
            ]
        );
    }
}

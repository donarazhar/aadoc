<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuBiayaPengajuanDiskonArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu Biaya > Pengajuan Diskon';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Pengajuan Diskon</strong> (atau Potongan Biaya) di dalam payung "Administrasi &gt; Biaya" merupakan etalase (*showcase*) dari fleksibilitas antarmuka sistem. Mengingat kebijakan subsidi memiliki banyak jalur (Prestasi Kejuaraan, Hafalan Al Quran, Raport, Saudara Kandung, Anak Pegawai, dan Lulusan YPIA), sistem menolak untuk memaksakan satu formulir sapu jagat (<i>one-size-fits-all</i>). Sebaliknya, ia menyajikan antarmuka dinamis yang bermutasi bentuk menyesuaikan jenis diskon yang dipilih.</p>

<h3>Struktur Antarmuka (UI) Form Kontekstual</h3>
<p>Halaman ini memamerkan eksekusi brilian dari prinsip <strong>Contextual UI</strong> (Antarmuka Kontekstual). Form berevolusi untuk hanya menampilkan *field* yang secara logis dibutuhkan untuk memvalidasi *tab* diskon bersangkutan:</p>
<ul>
    <li><strong>Identitas Jangkar (Anchor Fields):</strong> Di setiap *tab*, formulir selalu dipersatukan oleh *field* absolut: <code>Nama Siswa</code> (berupa kotak pencarian *real-time* cerdas yang menyuguhkan nama dan No. Registrasi), dan <code>Tujuan Sekolah</code>. *Field* <code>Besar Potongan (%)</code> juga selalu hadir sebagai luaran numerik (<i>numeric output</i>) dari pengajuan tersebut.</li>
    <li><strong>Mutasi *Field* Kontekstual:</strong> Kehebatan UX terasa dari detail perubahan kolom di masing-masing jalur pendaftaran:
        <ul>
            <li><strong>Jalur Prestasi &amp; Tahfidz:</strong> Sistem memunculkan parameter validasi kompetitif seperti <code>Tingkat</code> (Nasional/Internasional) dan <code>Medali</code> (Emas/Perak/Perunggu), demi menakar *grade* potongan.</li>
            <li><strong>Jalur Saudara Kandung:</strong> Fokus beralih ke demografi keluarga dengan memunculkan <i>field</i> <code>Jumlah Saudara</code>.</li>
            <li><strong>Jalur Anak Pegawai:</strong> Mengusung integrasi lintas-modul (<i>cross-module integration</i>) dengan HR. Muncul <i>field</i> pencarian <code>Nama Pegawai/NIP</code> yang terhubung dengan <code>Jabatan</code>. Menariknya, sistem memecah besaran potongan secara spesifik menjadi 3 kolom terpisah (Diskon Uang Pangkal, SPP, Biaya Lainnya).</li>
        </ul>
    </li>
    <li><strong>Dokumen Pendukung Adaptif:</strong> Setiap pengajuan menuntut alat bukti fisik yang didigitalisasi (Unggah Dokumen, Maks 2MB). Hebatnya, label kotak unggahan beradaptasi cerdas: meminta <code>Sertifikat/Piagam</code> untuk jalur prestasi/tahfidz, namun berubah meminta <code>Kartu Keluarga</code> untuk jalur Saudara Kandung &amp; Anak Pegawai. Penyesuaian mikro (<i>micro-copywriting</i>) ini melenyapkan kebingungan staf (*ambiguity prevention*).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Ditinjau dari kacamata arsitektur ERP Sekolah, fitur <strong>Pengajuan Diskon</strong> berperan esensial sebagai <strong>"Interseptor Tagihan"</strong> (<i>Billing Interceptor / Modifier</i>) sesaat sebelum tagihan resmi dieksekusi.</p>
<ul>
    <li><strong>Hulu Integrasi Data (Input Sources):</strong> Formulir ini menyedot referensi identitas secara menyilang: mengambil nama anak dari modul <strong>Data Calon Murid/Data Murid</strong>, serta menarik data identitas karyawan dari modul <strong>Kepegawaian (HR)</strong>.</li>
    <li><strong>Hilir Otomatisasi (Workflow Execution):</strong> Data (Besar Potongan %) yang di-<i>submit</i> di sini lazimnya akan memicu siklus persetujuan (<i>Approval Workflow</i>) berjenjang ke pimpinan yayasan. Begitu diteken sah, persentase diskon tersebut diinjeksi (*injected*) ke dalam mesin Penagihan di modul <strong>Transaksi</strong>. Alhasil, sistem kasir akan secara otomatis memotong (mendiskon) <i>Invoice</i> SPP bulanan atau tagihan Uang Pangkal siswa yang bersangkutan, tanpa kasir harus menekan tombol "Diskon" secara manual lagi.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Penerapan pola *Contextual UI* pada fitur "Pengajuan Diskon" berhasil menyelamatkan *database* dari sampah kolom-kolom statis yang tak terpakai (*general string columns*). Dengan mendikte tipe data secara kaku sesuai jalur pengajuannya (contoh: NIP vs Medali) dan mendandani label *upload* dokumen secara adaptif, perancang sistem menggaransi tingginya integritas data. Dari perspektif alur kerja, menu ini bertindak bagai jembatan emas yang menghubungkan amanat beasiswa/subsidi dari yayasan dengan presisi otomatisasi mesin penagihan keuangan.</p>
',
                'is_published' => true,
                'order' => 25
            ]
        );
    }
}

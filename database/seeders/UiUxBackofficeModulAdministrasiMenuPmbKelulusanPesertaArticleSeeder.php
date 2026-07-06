<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class UiUxBackofficeModulAdministrasiMenuPmbKelulusanPesertaArticleSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('UI/UX Backoffice')],
            ['name' => 'UI/UX Backoffice', 'description' => 'Dokumentasi antarmuka pengguna (UI/UX) untuk Backoffice Al Azhar Apps', 'order' => 2]
        );

        $title = 'Modul Administrasi Menu PMB > Kelulusan Peserta';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p>Menu <strong>Kelulusan Peserta</strong> adalah gerbang penentuan akhir (<i>final judgement gate</i>) dalam arsitektur modul "Administrasi &gt; PMB". Halaman ini dirancang secara khusus untuk bertindak sebagai <i>dashboard</i> eksekusi (<i>execution board</i>) di mana panitia atau pimpinan sekolah menjatuhkan vonis kelulusan bagi para calon murid baru.</p>

<h3>Struktur Antarmuka (UI) Eksekusi Kelulusan</h3>
<p>Halaman ini sangat sarat akan fitur tindakan massal (<i>bulk actions</i>) dan pengategorian data (*data triaging*), yang direpresentasikan melalui elemen-elemen UI strategis berikut:</p>
<ul>
    <li><strong>Tab Navigasi Status (Status Switcher):</strong> Bidang kerja dipecah menjadi tiga tabulasi logis: <code>Belum Diproses</code>, <code>Peserta Lulus</code>, dan <code>Peserta Tidak Lulus</code>. Pola UX berbasis <i>pipeline</i> ini sangat krusial; ia mencegah admin mengeksekusi data siswa yang sama dua kali dan memberikan gambaran instan (<i>progress tracking</i>) mengenai berapa banyak siswa yang nasibnya belum ditentukan.</li>
    <li><strong>Bilah Aksi Massal (Bulk Action Bar):</strong> Pada tab utama ("Belum Diproses"), sistem menyuguhkan deretan tombol eksekusi: <code>Luluskan</code> (berwarna biru berikon centang) dan <code>Tidak Lulus</code> (merah berikon coret). Tombol ini secara logis terhubung dengan <i>Checkbox</i> di tabel bawahnya, memampukan pimpinan menetapkan status puluhan siswa sekaligus hanya dengan sekali klik (<i>Batch Processing</i>).</li>
    <li><strong>Dukungan Evaluasi Luring (Offline Processing):</strong> Memahami kultur panitia PMB yang mungkin lebih nyaman mengolah nilai di Microsoft Excel, UI ini cerdas menyediakan tombol <code>Download Template</code> (hijau) dan <code>Upload Hasil Ujian</code> (biru). Fitur inklusif ini menjembatani <i>workflow</i> tradisional dengan sistem digital modern.</li>
    <li><strong>Fitur Ralat (Revert Action):</strong> Pada tab "Peserta Lulus" maupun "Tidak Lulus", deretan tombol aksi bertransformasi menjadi tombol <code>Batalkan</code> (merah). Ini adalah wujud jaring pengaman UX (<i>Safety Net</i>), memberikan hak dan ruang bagi pengguna untuk mengoreksi keputusan apabila terjadi kelalaian klik (*human error correction*).</li>
</ul>

<h3>Peran dalam Alur Kerja (Workflow) Aplikasi</h3>
<p>Dalam skala bisnis proses yang lebih luas, menu <strong>Kelulusan Peserta</strong> memegang tongkat estafet sebagai <strong>Muara Keputusan</strong> (<i>The Decision Hub</i>) dari keseluruhan rantai Penerimaan Murid Baru.</p>
<ul>
    <li><strong>Hulu Data (Input Source):</strong> Menu ini secara eksklusif menyedot data dari menu pra-syaratnya, yaitu <strong>Peserta Ujian</strong>. Tabel kelulusan ini mengambil parameter <strong>Nilai</strong> (skor akhir ujian) yang telah di-*input* sebelumnya sebagai landasan objektif untuk menyortir dan memfilter kelayakan kandidat.</li>
    <li><strong>Hilir Data (Output Destination):</strong> Vonis yang dijatuhkan di halaman ini akan menentukan takdir aliran data selanjutnya. Sistem akan menangkap siswa-siswa berstatus "Lulus" dan mentransformasikannya dari "Calon Pendaftar" menjadi entitas nyata yang akan dialirkan (<i>pushed</i>) ke *database* utama <strong>Sekolah &gt; Data Murid</strong> (biasanya setelah tahapan bayar daftar ulang dituntaskan). Sebaliknya, mereka yang ditolak akan diarsipkan dalam modul riwayat.</li>
</ul>

<h3>Kesimpulan Desain</h3>
<p>Desain "Kelulusan Peserta" adalah perwujudan sempurna dari <strong>Action-Oriented Dashboard</strong> (Dasbor Berorientasi Eksekusi). Melalui penyediaan navigasi <i>tab</i> yang lugas, integrasi <i>checkbox</i> untuk <i>bulk approval</i>, serta opsi pemrosesan <i>file</i> via Excel, antarmuka ini memastikan fase paling kritis dan menegangkan di musim PMB dapat diselesaikan oleh tim panitia dengan sangat luwes, minim friksi, dan sepenuhnya kebal terhadap tekanan (<i>stress-free</i>).</p>
',
                'is_published' => true,
                'order' => 20
            ]
        );
    }
}

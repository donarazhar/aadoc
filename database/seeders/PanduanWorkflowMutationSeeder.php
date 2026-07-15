<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowMutationSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catPanduan = Category::firstOrCreate(
            ['slug' => Str::slug('Skenario Workflow Lintas Sistem')],
            ['name' => 'Skenario Workflow Lintas Sistem']
        );

        $content = <<<HTML
<p>Artikel ini mendokumentasikan skenario tahunan yang paling krusial di sistem pendidikan, yaitu proses penutupan Tahun Ajaran, mutasi status siswa (Naik Kelas, Lulus, atau Pindah), dan persiapannya menuju Tahun Ajaran Baru. Orkestrasi ini melibatkan interaksi intensif antara <code>report-service</code>, <code>student-service</code>, dan <code>transaction-service</code>.</p>

<h3>Diagram Urutan: Mutasi & Kenaikan Kelas Akhir Tahun</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant GRU as Wali Kelas (Web)
    participant RPT as Report Service (Rapor)
    participant STU as Student Service (Data Pokok)
    participant TXN as Transaction Service (Keuangan)
    participant DB as Database (PostgreSQL)

    %% Fase Penilaian Akhir
    Note over GRU,RPT: Tahap A: Evaluasi Akademik
    GRU->>RPT: Finalisasi Pengisian Nilai Rapor Semester Genap
    RPT->>DB: Validasi Kelengkapan Nilai & Ekstrakurikuler
    RPT-->>GRU: Rapor Terkunci (Locked) & Siap Cetak
    
    %% Fase Kenaikan Kelas / Mutasi
    Note over GRU,STU: Tahap B: Eksekusi Kenaikan Kelas (Massal)
    GRU->>STU: Submit Keputusan: Kumpulan Siswa "Naik Kelas" / "Lulus"
    STU->>DB: Update Status Akademik Siswa
    STU->>DB: Putus Relasi Siswa dari Rombel Lama
    STU->>DB: Petakan Siswa ke Rombel Tahun Ajaran Baru
    STU-->>GRU: Mutasi Rombel Berhasil

    %% Fase Keuangan
    Note over STU,TXN: Tahap C: Implikasi Keuangan
    STU->>TXN: Trigger Event (Siswa Masuk Tahun Ajaran Baru)
    TXN->>DB: Tarik Tarif SPP / Daftar Ulang Kelas Baru
    TXN->>DB: Generate Tagihan Daftar Ulang (Status UNPAID)
    TXN-->>STU: Status Tagihan Tersinkronisasi
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Kenaikan kelas bukan sekadar mengubah angka kelas (misal dari Kelas 1 menjadi Kelas 2), melainkan sebuah operasi relasional yang mengubah sejarah akademik (<em>History</em>) dan implikasi finansial murid tersebut.</p>

<h4>1. Finalisasi Penilaian (Report Service)</h4>
<ul>
    <li>Wali kelas memastikan seluruh guru mata pelajaran telah menginput nilai ujian akhir semester.</li>
    <li>Wali kelas memasukkan catatan tambahan (prestasi, presensi akhir, dan catatan perilaku).</li>
    <li>Setelah Rapor difinalisasi (<em>Locked</em>), data menjadi permanen (<em>read-only</em>) untuk dicetak sebagai dokumen legal dan diunggah ke aplikasi Mobile orang tua. Keputusan Naik/Tinggal Kelas ditentukan di titik ini.</li>
</ul>

<h4>2. Pemindahan Rombongan Belajar (Student Service)</h4>
<ul>
    <li>Sistem mengakomodasi eksekusi massal (<em>Bulk Mutation</em>). Wali kelas atau Admin Sekolah menyeleksi murid-murid yang "Naik Kelas".</li>
    <li>Sistem <code>student-service</code> akan memutus relasi siswa dari Rombel (Rombongan Belajar) di Tahun Ajaran Genap (lama), dan mengaitkannya ke Rombel di Tahun Ajaran Ganjil (baru).</li>
    <li><strong>Alur Kelulusan:</strong> Jika murid berada di tingkat akhir (Kelas 6, 9, atau 12), status mereka diubah menjadi <strong>ALUMNI</strong>. Mereka tidak akan dipetakan ke Rombel baru, dan otomatis dihentikan dari siklus penagihan biaya pendidikan selanjutnya.</li>
</ul>

<h4>3. Otomatisasi Tagihan Tahun Baru (Transaction Service)</h4>
<ul>
    <li>Transisi tahun ajaran baru biasanya disertai dengan kewajiban pembayaran Daftar Ulang atau penyesuaian tarif SPP baru.</li>
    <li>Begitu data murid dipindahkan ke Rombel baru oleh <code>student-service</code>, sebuah <em>Event Listener</em> (pendeteksi kejadian) di dalam <code>transaction-service</code> akan menyala.</li>
    <li>Mesin keuangan ini secara otomatis mendeteksi, <em>"Oh, Budi sekarang Kelas 2, tarif SPP-nya sekian"</em>. Sistem langsung menerbitkan faktur tagihan untuk tahun ajaran baru di latar belakang tanpa Admin Keuangan perlu mengetik ulang daftar murid.</li>
</ul>

<h4>4. Konsistensi Sejarah (Data Lineage)</h4>
<ul>
    <li>Arsitektur database dirancang agar sejarah (<em>Track Record</em>) anak di kelas sebelumnya tidak tertimpa. Jika orang tua membuka aplikasi Mobile dan memilih filter "Tahun Ajaran Lalu", mereka tetap bisa melihat rapor, tagihan, dan daftar guru Budi saat ia masih berada di Kelas 1.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Mutasi Akademik dan Kenaikan Kelas')],
            [
                'title' => 'Skenario Mutasi Akademik dan Kenaikan Kelas',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

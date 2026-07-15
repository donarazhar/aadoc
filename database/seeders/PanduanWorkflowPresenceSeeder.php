<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class PanduanWorkflowPresenceSeeder extends Seeder
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
<p>Artikel ini menjabarkan alur kerja (workflow) pencatatan presensi (kehadiran) harian di lingkungan Yayasan Pesantren Islam Al-Azhar, baik untuk Guru/Pegawai maupun untuk Siswa, serta integrasinya dengan sistem pelaporan kepada Orang Tua.</p>

<h3>Diagram Urutan: Skenario Presensi & Kehadiran</h3>
<pre><code class="language-mermaid">
sequenceDiagram
    autonumber
    participant GRU as Guru/Pegawai (Mobile/Web)
    participant STU as Student Service (Backend)
    participant ACC as Account Service (Notifikasi)
    participant OTM as Orang Tua (Mobile)
    participant DB as Database (PostgreSQL)

    %% Presensi Pegawai/Guru
    Note over GRU,DB: Tahap A: Presensi Guru & Pegawai
    GRU->>STU: Scan QR / Klik Tombol Hadir (Location GPS aktif)
    STU->>STU: Validasi Jarak Geofencing (Radius Sekolah)
    STU->>DB: Catat Waktu Masuk (Status: HADIR / TERLAMBAT)
    STU-->>GRU: Berhasil Absen

    %% Presensi Siswa oleh Wali Kelas
    Note over GRU,OTM: Tahap B: Presensi Siswa di Kelas
    GRU->>STU: Buka Daftar Hadir Kelas (Rombel)
    GRU->>STU: Tandai Siswa (Hadir, Sakit, Izin, Alpa)
    STU->>DB: Simpan Data Presensi Siswa
    
    %% Trigger Notifikasi Real-time
    STU->>ACC: Trigger Event: Presensi Siswa Tersimpan
    ACC->>ACC: Cek Pengaturan Notifikasi Orang Tua
    ACC-->>OTM: Push Notification: "Ananda Budi telah Hadir di Sekolah pada 07:15"
    
    %% Rekapitulasi
    Note over OTM,DB: Tahap C: Rekapitulasi & Pelaporan
    OTM->>STU: Buka Menu Kehadiran Anak
    STU->>DB: Kalkulasi Persentase Kehadiran Bulanan
    DB-->>STU: Return Data Rekap (Grafik)
    STU-->>OTM: Tampilkan Laporan Kehadiran
</code></pre>

<h3>Penjelasan Alur (Workflow Detail)</h3>
<p>Pencatatan presensi di kelola secara terpusat oleh <code>student-service</code>. Fitur ini dirancang untuk mendigitalisasi buku absensi konvensional dan memberikan kepastian (<em>peace of mind</em>) secara seketika (<em>real-time</em>) kepada orang tua.</p>

<h4>1. Absensi Guru & Tenaga Kependidikan (Geofencing)</h4>
<ul>
    <li>Saat guru tiba di lingkungan sekolah, mereka menggunakan Aplikasi Mobile atau Web untuk melakukan <em>check-in</em>.</li>
    <li><strong>Validasi Lokasi (Geofencing):</strong> Sistem tidak serta merta menerima absen. Aplikasi akan menarik titik koordinat GPS (Latitude/Longitude) perangkat dan mencocokkannya dengan koordinat gedung sekolah. Jika berada di luar radius yang diizinkan (misalnya > 50 meter), absensi akan ditolak.</li>
    <li>Sistem secara otomatis membandingkan <em>timestamp</em> (waktu server) dengan jam masuk standar untuk memberikan penanda <strong>Tepat Waktu</strong> atau <strong>Terlambat</strong>.</li>
</ul>

<h4>2. Presensi Siswa di Kelas (Oleh Wali Kelas/Guru Mata Pelajaran)</h4>
<ul>
    <li>Di dalam kelas, guru membuka menu daftar hadir (Absensi Rombel) di aplikasi genggam atau laptop mereka.</li>
    <li>Guru melakukan pemanggilan <em>(roll call)</em> dan menandai status masing-masing siswa (Hadir, Sakit, Izin, atau Alpa).</li>
    <li>Jika ada siswa yang ditandai <strong>Sakit/Izin</strong>, guru dapat mengunggah bukti surat keterangan atau catatan (<em>Meeting Note</em> / Keterangan).</li>
</ul>

<h4>3. Notifikasi Cerdas & Otomatis</h4>
<ul>
    <li>Tepat di detik guru menekan tombol <strong>Simpan Absensi</strong>, <code>student-service</code> akan melemparkan instruksi (<em>Event Trigger</em>) ke <code>account-service</code>.</li>
    <li>Sistem akan mencari ID perangkat (<em>Device Token</em>) milik orang tua dari siswa yang bersangkutan.</li>
    <li>Sebuah <strong>Push Notification</strong> otomatis dikirimkan ke ponsel orang tua (Contoh: <em>"Ananda telah tiba dan terabsen di kelas pada 07:15"</em>). Fitur ini sangat diapresiasi oleh orang tua demi keamanan anak mereka.</li>
</ul>

<h4>4. Dasbor Rekapitulasi</h4>
<ul>
    <li>Data presensi tidak pernah dihapus dan menjadi rekam jejak permanen. Pada akhir semester, data ini secara otomatis diagregasi (dikalkulasi) dan di-<em>inject</em> langsung ke dalam nilai Rapor Digital di <code>report-service</code> tanpa perlu diketik ulang oleh Tata Usaha.</li>
</ul>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('Skenario Presensi, Absensi Harian & Geofencing')],
            [
                'title' => 'Skenario Presensi, Absensi Harian & Geofencing',
                'category_id' => $catPanduan->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

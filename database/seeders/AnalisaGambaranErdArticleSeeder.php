<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Support\Str;

class AnalisaGambaranErdArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan kategori Backoffice Al Azhar Apps ada
        $category = Category::firstOrCreate(
            ['slug' => Str::slug('Backoffice Al Azhar Apps')],
            ['name' => 'Backoffice Al Azhar Apps', 'description' => 'Artikel tentang sistem backoffice Al Azhar Apps', 'order' => 1]
        );

        // Buat artikel Analisa Gambaran ERD
        $title = 'Analisa Gambaran ERD';
        Document::updateOrCreate(
            ['slug' => Str::slug($title)],
            [
                'category_id' => $category->id,
                'title' => $title,
                'content' => '
<p><strong>2. Gambaran ERD (Entity Relationship Diagram)</strong></p>
<p>Berdasarkan analisa database relasional yang dibutuhkan untuk mengakomodasi layar-layar tersebut, berikut adalah gambaran utama ERD-nya. (Diagram ini berfokus pada entitas utama agar mudah dipahami)</p>

<pre><code class="language-mermaid">
erDiagram
    YAYASAN ||--o{ SEKOLAH : membina
    SEKOLAH ||--o{ PEGAWAI : mempekerjakan
    PEGAWAI ||--o| USER : "punya akun"
    SEKOLAH ||--o{ TAHUN_AJARAN : "beroperasi pada"
    SEKOLAH ||--o{ PROGRAM : menawarkan
    SEKOLAH ||--o{ ROMBEL : memiliki
    SEKOLAH ||--o{ RUANGAN : memiliki
    SEKOLAH ||--o{ KURIKULUM : menetapkan
    SEKOLAH ||--o{ SARANA_PRASARANA : memiliki
    SEKOLAH ||--o{ EKSTRAKURIKULER : menyediakan
    SEKOLAH ||--o{ GELOMBANG_PENDAFTARAN : membuka

    TAHUN_AJARAN ||--o{ ROMBEL : "berlaku utk"
    TAHUN_AJARAN ||--o{ MURID : "mendaftar pada"
    TAHUN_AJARAN ||--o{ UANG_SEKOLAH : "berlaku utk"
    TAHUN_AJARAN ||--o{ UANG_PANGKAL : "berlaku utk"
    TAHUN_AJARAN ||--o{ UANG_DAFTAR_ULANG : "berlaku utk"
    TAHUN_AJARAN ||--o{ GELOMBANG_PENDAFTARAN : "berlaku utk"

    PROGRAM ||--o{ ROMBEL : mengelompokkan
    PROGRAM ||--o{ MURID : diikuti
    RUANGAN ||--o{ ROMBEL : ditempati
    PEGAWAI ||--o{ ROMBEL : "jadi wali kelas"
    KURIKULUM ||--o{ MATA_PELAJARAN : terdiri

    ROMBEL ||--o{ MURID : menampung
    MURID ||--o{ TRANSAKSI : melakukan
    MURID ||--o{ TAGIHAN : menerima
    MURID ||--o{ DISKON : mengajukan
    MURID ||--o{ PRESTASI : mencatat
    MURID ||--o{ KENAIKAN_KELAS : mengalami
    MURID ||--o{ E_RAPOT : memiliki
    MURID ||--o| IJAZAH : menerima
    MURID ||--o{ EKSTRAKURIKULER_MURID : mengikuti
    EKSTRAKURIKULER ||--o{ EKSTRAKURIKULER_MURID : diikuti

    GELOMBANG_PENDAFTARAN ||--o{ JADWAL_UJIAN : mencakup
    GELOMBANG_PENDAFTARAN ||--o{ CALON_MURID : menaungi
    JADWAL_UJIAN ||--o{ PESERTA_UJIAN : melibatkan
    CALON_MURID ||--o{ PESERTA_UJIAN : "ikut ujian sbg"
    CALON_MURID ||--o| KELULUSAN_PESERTA : dievaluasi
    CALON_MURID ||--o| MURID : "menjadi (jika diterima)"
    CALON_MURID ||--o{ TRANSAKSI : "bayar formulir/DSP"

    USER ||--o{ LOG_ACTIVITY : menghasilkan

    SEKOLAH {
        id id
        string npsn
        string nama_sekolah
        string alamat
        int yayasan_id
    }
    MURID {
        id id
        string nis
        string nisn
        string nama
        string status
        int rombel_id
        int program_id
        int tahun_ajaran_id
    }
    CALON_MURID {
        id id
        string no_registrasi
        string nama
        string jenjang
        string status_pendaftaran
        int gelombang_id
    }
    GELOMBANG_PENDAFTARAN {
        id id
        string nama_gelombang
        date tgl_buka
        date tgl_tutup
        date jatuh_tempo
        int target
    }
    JADWAL_UJIAN {
        id id
        string nama_ujian
        string tipe_ujian
        int ruangan_id
    }
    PESERTA_UJIAN {
        id id
        int calon_murid_id
        int jadwal_ujian_id
        float nilai
    }
    KELULUSAN_PESERTA {
        id id
        int peserta_ujian_id
        string status
    }
    UANG_SEKOLAH {
        id id
        int tahun_ajaran_id
        string tingkat_kelas
        int program_id
        float nominal
    }
    UANG_PANGKAL {
        id id
        int tahun_ajaran_id
        string komponen
        float nominal
    }
    UANG_DAFTAR_ULANG {
        id id
        int tahun_ajaran_id
        string komponen_biaya
        float nominal
        date jatuh_tempo
    }
    TAGIHAN {
        id id
        int murid_id
        string jenis_biaya
        float nominal
        string status
    }
    TRANSAKSI {
        id id
        int murid_id
        string no_reference
        string va
        float nominal
        date tanggal
    }
    DISKON {
        id id
        int murid_id
        string kategori
        float besar_potongan
        string status_approval
    }
    PRESTASI {
        id id
        int murid_id
        string bidang
        string jenis_lomba
        string juara
        string tingkat
    }
    KENAIKAN_KELAS {
        id id
        int murid_id
        int rombel_asal
        int rombel_tujuan
        string status
    }
    E_RAPOT {
        id id
        int murid_id
        string term
        string kelengkapan
    }
    IJAZAH {
        id id
        int murid_id
        date tgl_lulus
    }
    USER {
        id id
        int pegawai_id
        string role
        string username
    }
    LOG_ACTIVITY {
        id id
        int user_id
        string aktivitas
        datetime waktu
    }
</code></pre>
',
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}

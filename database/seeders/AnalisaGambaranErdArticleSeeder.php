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
    SEKOLAH {
        int id_sekolah PK
        string npsn
        string nama_sekolah
        string tingkat_jenjang
    }
    TAHUN_AJARAN {
        int id_tahun_ajaran PK
        string nama_tahun_ajaran
    }
    TINGKAT_KELAS {
        int id_tingkat_kelas PK
        string nama_tingkat_kelas
    }
    PROGRAM {
        int id_program PK
        string nama_program
    }
    GELOMBANG_PMB {
        int id_gelombang PK
        int id_sekolah FK
        int id_tahun_ajaran FK
        string nama_gelombang
        date tgl_buka
        date tgl_tutup
    }
    CALON_MURID {
        int id_calon PK
        int id_gelombang FK
        int id_program FK
        string no_registrasi
        string nama_lengkap
        string status_pendaftaran "Animo / Formulir / Lulus"
    }
    JADWAL_UJIAN {
        int id_ujian PK
        int id_gelombang FK
        string nama_ujian
        string tipe_ujian
    }
    PESERTA_UJIAN {
        int id_peserta_ujian PK
        int id_ujian FK
        int id_calon FK
        float nilai
        string status_kelulusan
    }
    PEGAWAI {
        int id_pegawai PK
        string nip
        string nama_lengkap
        string jabatan
    }
    ROMBEL {
        int id_rombel PK
        int id_tahun_ajaran FK
        int id_tingkat_kelas FK
        int id_pegawai FK "Wali Kelas"
        string nama_rombel
    }
    MURID {
        int id_murid PK
        int id_calon FK "Jika dari PMB"
        int id_rombel FK
        string nis
        string nama_lengkap
        string status_aktif
    }
    TAGIHAN_KEUANGAN {
        int id_tagihan PK
        int id_murid FK
        string jenis_tagihan "Pangkal / SPP / Daftar Ulang"
        float nominal_total
        string no_virtual_account
        string status_bayar
    }
    DISKON {
        int id_diskon PK
        int id_murid FK
        string kategori_diskon
        float persen_potongan
        string status_approval
    }
    SEKOLAH ||--o{ GELOMBANG_PMB : membuka
    TAHUN_AJARAN ||--o{ GELOMBANG_PMB : berlaku_pada
    GELOMBANG_PMB ||--o{ CALON_MURID : menerima
    PROGRAM ||--o{ CALON_MURID : dipilih
    GELOMBANG_PMB ||--o{ JADWAL_UJIAN : memiliki
    JADWAL_UJIAN ||--o{ PESERTA_UJIAN : diikuti_oleh
    CALON_MURID ||--o{ PESERTA_UJIAN : menjadi
    CALON_MURID ||--o| MURID : diterima_menjadi
    TAHUN_AJARAN ||--o{ ROMBEL : memiliki
    TINGKAT_KELAS ||--o{ ROMBEL : tingkatan
    PEGAWAI ||--o{ ROMBEL : menjadi_wali_kelas
    ROMBEL ||--o{ MURID : memiliki_anggota
    MURID ||--o{ TAGIHAN_KEUANGAN : dibebankan
    MURID ||--o{ DISKON : mendapatkan
</code></pre>
',
                'is_published' => true,
                'order' => 2
            ]
        );
    }
}

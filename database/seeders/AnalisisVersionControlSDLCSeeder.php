<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisVersionControlSDLCSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Analisis Sistem ALAZHARAPPS')],
            ['name' => 'Analisis Sistem ALAZHARAPPS']
        );

        $content = <<<HTML
<p>Dokumen ini memetakan kebiasaan operasional pengembang (Developer Workflow) dan kebijakan Siklus Hidup Pengembangan Perangkat Lunak (SDLC) yang diamankan melalui GitLab.</p>

<h3>1. Strategi Pencabangan Git (Branching Strategy)</h3>
<p>Repositori ALAZHARAPPS mengadopsi modifikasi dari pola kolaborasi <strong>GitFlow / Feature Branch</strong>. Terlihat dari eksekusi perintah <code>git pull</code> yang memunculkan banyak variasi cabang (Branches):</p>
<ul>
    <li><strong><code>master</code> / <code>main</code>:</strong> Cabang Suci. Tidak ada pengembang yang boleh mendorong (Push) kode secara langsung ke sini. Cabang ini merepresentasikan *Image* kontainer yang saat ini sedang aktif (Live) melayani pengguna di Production.</li>
    <li><strong><code>develop</code> / <code>staging</code>:</strong> Kawah Candradimuka. Tempat bertemunya fitur-fitur baru (sebelum diuji coba dan dirilis bulan depan). Jika aplikasi di *Staging* hancur, tidak masalah, karena di sinilah pengujian pra-rilis (*User Acceptance Test*) dilakukan.</li>
    <li><strong><code>feature/nama-fitur</code> atau nama personal (contoh <code>rahmat</code>):</strong> Cabang tempat koding sehari-hari. Fitur PPDB atau SPP baru dikerjakan terpisah secara paralel.</li>
    <li><strong><code>hotfix</code>:</strong> Jalur cepat (*Fast-track*). Dibuat langsung dari <code>master</code> untuk menambal kebocoran atau *bug* parah tanpa harus menunggu siklus rilis reguler selesai.</li>
</ul>

<h3>2. Peninjauan Kode (Pull/Merge Request)</h3>
<p>Sistem ini tidak membiarkan pengembang sembarangan menyuntik kode ke <code>develop</code>. Proses penyatuan fitur harus melewati mekanisme <strong>Merge Request (MR)</strong>.</p>
<ul>
    <li><strong>Peer Review:</strong> Pengembang senior (Tech Lead) bertugas mengecek kode yang diajukan oleh pemrogram junior. Apakah sesuai *Coding Standard*? Apakah *raw query*-nya aman dari *SQL Injection*?</li>
    <li><strong>CI Gates:</strong> Saat MR dibuat, GitLab secara otomatis akan menjalankan *Unit Test* dan *Linter*. Tim tidak bisa menekan tombol <em>"Accept Merge"</em> jika tanda silang merah (Gagal Test) masih muncul di halaman GitLab (*Pipeline Enforcement*).</li>
</ul>

<h3>3. Konvensi Pesan Komit (Commit Guidelines)</h3>
<p>Walaupun kadang fleksibel, praktik yang baik di dunia peranti lunak (seperti <em>Conventional Commits</em>) menganjurkan pelabelan *commit* untuk pelacakan rilis (Changelog) yang teratur. (Contoh standar industri: <code>feat: add automatic billing</code>, <code>fix: resolve rounding error on SPP</code>). Ini akan membuat proses penelusuran sejarah (*blame*) di ALAZHARAPPS menjadi jauh lebih mudah di kemudian hari.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('6. Kebijakan Version Control & Siklus SDLC')],
            [
                'title' => '6. Kebijakan Version Control & Siklus SDLC',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

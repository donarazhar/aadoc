<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Str;

class AnalisisObservabilitySeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'donarazhar@gmail.com')->first();
        $adminId = $admin ? $admin->id : User::first()->id;

        $catAnalisis = Category::firstOrCreate(
            ['slug' => Str::slug('Observabilitas & Monitoring')],
            [
                'name' => 'Observabilitas & Monitoring',
                'description' => 'Pemantauan, metrik, dan agregasi log sistem',
                'order' => 5,
                'is_hidden' => false,
            ]
        );

        $content = <<<HTML
<p>Dokumen ini merangkum lapisan Pemantauan Cerdas (Observability) yang menjadi mata dan telinga sistem ALAZHARAPPS saat beroperasi tanpa pengawasan di lingkungan Produksi.</p>

<h3>1. Melampaui Pembacaan Log Manual</h3>
<p>Pada panduan <em>Troubleshooting</em>, kita diajarkan cara membaca log dari terminal Docker secara manual. Namun, hal itu hanya berlaku jika kita <strong>tahu</strong> sistem sedang rusak. Bagaimana cara kita tahu sebuah sistem rusak <em>sebelum</em> ditelepon oleh orang tua murid yang komplain?</p>

<h3>2. Tiga Pilar Observabilitas Sistem</h3>
<ul>
    <li><strong>Logs (Agregasi):</strong> Log dari ke-12 layanan *microservice* tidak boleh dibiarkan berserakan di mesin masing-masing. Tim DevOps wajib menerapkan sistem *Log Aggregator* (seperti ELK Stack: Elasticsearch, Logstash, Kibana atau tumpukan Grafana Loki). Dengan ini, pencarian (Trace) ID Transaksi <code>TRX-123</code> dapat langsung terlihat menembus semua *microservices* dalam satu dasbor raksasa.</li>
    <li><strong>Metrics (Beban Server):</strong> Menggunakan alat bernama Prometheus untuk menarik metrik *hardware* dan *software* (CPU Usage, Memory, durasi respon API). Metrik ini divisualisasikan oleh dasbor Grafana secara *Realtime*.</li>
    <li><strong>Traces (APM):</strong> Menggunakan <em>Application Performance Monitoring (APM)</em> untuk melacak *bottleneck* (kemacetan). Misalnya, dasbor APM bisa menunjukkan bahwa: <em>Request Pendaftaran memakan waktu 4 detik (1 detik di API gateway, 2.5 detik macet saat kueri GORM, 0.5 detik cetak PDF)</em>. Data ini sangat mahal untuk proses optimasi.</li>
</ul>

<h3>3. Error Tracking Frontend (Sentry)</h3>
<p>Bagaimana jika aplikasi *Mobile* <em>crash</em> atau layar *blank* (putih) di *smartphone* orang tua saat mereka mencoba membayar tagihan? Server Golang tidak akan pernah menerima log error ini karena rusaknya ada di sisi *device* (Klien).</p>
<p><strong>[TIP] Integrasi Pihak Ketiga:</strong> Ekosistem NextJS dan Mobile biasanya diintegrasikan dengan alat pelacak *Error* klien seperti <strong>Sentry</strong>. Ketika pengguna mendapati layar *Error 500*, *smartphone* secara asinkron akan mengirim *Stack Trace* lengkap dengan tipe *smartphone* dan versi OS ke dasbor Sentry milik pengembang, sehingga masalah UI dapat segera diinvestigasi (Patch) di hari yang sama.</p>
HTML;

        Document::updateOrCreate(
            ['slug' => Str::slug('4. Observabilitas & Monitoring Sistem (Grafana/Sentry)')],
            [
                'title' => '4. Observabilitas & Monitoring Sistem (Grafana/Sentry)',
                'category_id' => $catAnalisis->id,
                'content' => $content,
                'is_published' => true,
                'created_by' => $adminId,
            ]
        );
    }
}

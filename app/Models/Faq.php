<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
    ];

    /**
     * Konten fallback saat tabel masih kosong (belum di-seed),
     * sekaligus sumber data untuk FaqSeeder agar tidak duplikasi.
     */
    public const DEFAULTS = [
        [
            'question' => 'Berapa lama proses pembuatan website?',
            'answer' => 'Website company profile umumnya selesai dalam 2–4 minggu tergantung kompleksitas. Landing page bisa 1–2 minggu, sedangkan web application 4–8 minggu. Setiap proyek memiliki timeline yang jelas sejak awal, dan kami selalu mengirimkan laporan progres berkala.',
        ],
        [
            'question' => 'Berapa biaya pembuatan website?',
            'answer' => 'Biaya tergantung kebutuhan: landing page mulai dari Rp4,5 juta, company profile dari Rp9 juta, e-commerce dan web application dihitung berdasarkan fitur. Untuk penawaran yang akurat, kirimkan brief melalui halaman Mulai Proyek — kami balas dalam 1×24 jam kerja.',
        ],
        [
            'question' => 'Apa saja yang termasuk dalam paket?',
            'answer' => 'Semua paket mencakup desain UI, pengembangan responsif (mobile-friendly), optimasi kecepatan, SEO dasar (meta tag, sitemap, robots.txt), formulir kontak, integrasi WhatsApp, dan pelatihan pengelolaan konten singkat. Paket lanjutan menambahkan halaman blog/CMS, multi-bahasa, dan integrasi pembayaran.',
        ],
        [
            'question' => 'Bagaimana alur kerja / prosesnya?',
            'answer' => 'Alurnya sederhana: (1) konsultasi & brief, (2) proposal & kontrak, (3) desain & revisi, (4) pengembangan & integrasi, (5) pengujian lintas perangkat, (6) peluncuran, lalu (7) dukungan purna jual. Anda mendapat akses staging server untuk melihat progres sebelum go-live.',
        ],
        [
            'question' => 'Berapa kali revisi yang disediakan?',
            'answer' => 'Paket standar menyediakan 2 putaran revisi desain dan 2 putaran revisi konten. Revisi tambahan dapat diajukan dengan biaya wajar, atau Anda bisa memilih paket yang menyertakan revisi tanpa batas selama masa proyek.',
        ],
        [
            'question' => 'Teknologi apa yang digunakan?',
            'answer' => 'Kami membangun dengan stack modern: Laravel (PHP) untuk backend dan CMS, PostgreSQL untuk database, serta HTML/CSS/JavaScript murni atau Vue.js untuk antarmuka. Hasilnya: kode rapi, aman, dan mudah dikembangkan di kemudian hari.',
        ],
        [
            'question' => 'Apakah website bisa dirawat setelah selesai?',
            'answer' => 'Bisa. Kami menyediakan paket pemeliharaan bulanan: backup rutin, pembaruan keamanan, pemantauan uptime, serta kuota perubahan konten. Ini opsional — tanpa paket pemeliharaan, website tetap berjalan, namun Anda tidak mendapat prioritas dukungan.',
        ],
        [
            'question' => 'Bagaimana cara membayar?',
            'answer' => 'Pembayaran dilakukan bertahap: 50% di muka untuk memulai proyek dan 50% saat website siap diluncurkan. Kami menerima transfer bank, dan invoice resmi selalu diberikan. Detail termin tercantum transparan di dalam kontrak.',
        ],
        [
            'question' => 'Apakah saya bisa mengelola konten sendiri?',
            'answer' => 'Ya. Setiap website dilengkapi panel admin sederhana untuk mengubah teks, gambar, layanan, portofolio, dan artikel blog — tanpa perlu kemampuan coding. Kami sertakan sesi pelatihan singkat dan dokumentasi panduan penggunaan.',
        ],
        [
            'question' => 'Apakah domain dan hosting termasuk?',
            'answer' => 'Pendaftaran/pengalihan domain dan pengaturan hosting dapat kami bantu penuh. Biaya domain dan hosting ditanggung oleh Anda, namun kami urus prosesnya dari A sampai Z serta memastikan sertifikat SSL terpasang.',
        ],
    ];
}

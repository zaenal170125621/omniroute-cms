<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'about',
                'content' => "## Studio yang percaya pada kekuatan kesederhanaan\n\nSejak **2020**, OmniRoute Studio membantu bisnis di Indonesia tampil kredibel di dunia digital. Kami percaya desain yang baik adalah desain yang *jujur* — presisi, tanpa hiasan, dan selalu melayani tujuan.\n\n<figure class=\"figure-full\">\n    <img src=\"/images/about-studio.jpg\" alt=\"Suasana kerja OmniRoute Studio\" loading=\"lazy\">\n    <figcaption>OmniRoute Studio — ruang kerja di Jakarta Selatan, tempat kami merancang dan membangun.</figcaption>\n</figure>\n\n> \"Desain bukan ornamen. Desain adalah cara kita memecahkan masalah dengan jujur.\" — Rizky Dwiputra, Founder\n\n## Perjalanan kami\n\n- **2020** — OmniRoute lahir sebagai studio kecil tiga orang di Jakarta.\n- **2022** — Tim berkembang menjadi 8 orang; portofolio 50+ proyek selesai.\n- **2024** — Melayani klien di 12 kota; memperkenalkan layanan web application.\n- **2026** — 120+ proyek selesai dengan 98% klien merekomendasikan kami.\n\n## Nilai yang kami pegang\n\n1. **Presisi** — setiap piksel punya alasan.\n2. **Kecepatan** — website harus cepat, bukan hanya cantik.\n3. **Keterbukaan** — Anda tahu progress di setiap tahap.\n4. **Keberlanjutan** — kami mengajarkan Anda mengelola website sendiri.\n\n<div class=\"about-grid\">\n    <div class=\"about-stat\"><div class=\"num\">120<sup>+</sup></div><div class=\"label\">Proyek selesai</div></div>\n    <div class=\"about-stat\"><div class=\"num\">4,9<sup>/5</sup></div><div class=\"label\">Rating klien</div></div>\n    <div class=\"about-stat\"><div class=\"num\">98<sup>%</sup></div><div class=\"label\">Klien merekomendasikan</div></div>\n    <div class=\"about-stat\"><div class=\"num\">24<sup>j</sup></div><div class=\"label\">Respons cepat</div></div>\n</div>\n\n## Tim di balik studio\n\n<div class=\"team-grid\">\n    <div class=\"team-card\">\n        <img src=\"/images/team/team-1.jpg\" alt=\"Rizky Dwiputra\" loading=\"lazy\">\n        <h4>Rizky Dwiputra</h4>\n        <p>Founder &amp; Creative Director</p>\n    </div>\n    <div class=\"team-card\">\n        <img src=\"/images/team/team-2.jpg\" alt=\"Sarah Wijaya\" loading=\"lazy\">\n        <h4>Sarah Wijaya</h4>\n        <p>Head of Design</p>\n    </div>\n    <div class=\"team-card\">\n        <img src=\"/images/team/team-3.jpg\" alt=\"Andi Nugroho\" loading=\"lazy\">\n        <h4>Andi Nugroho</h4>\n        <p>Lead Engineer</p>\n    </div>\n    <div class=\"team-card\">\n        <img src=\"/images/team/team-4.jpg\" alt=\"Maya Kusuma\" loading=\"lazy\">\n        <h4>Maya Kusuma</h4>\n        <p>Project Manager</p>\n    </div>\n</div>\n\n## Bagaimana kami bekerja\n\n- **Konsultasi (1 hari)** — kami dengarkan kebutuhan Anda, gratis.\n- **Proposal &amp; estimasi (2–3 hari)** — ruang lingkup, timeline, dan harga yang transparan.\n- **Desain &amp; revisi (1–2 minggu)** — grid, tipografi, dan alur yang teruji.\n- **Pengembangan (1–3 minggu)** — kode bersih, responsif, dan cepat.\n- **Launch &amp; dukungan (selamanya)** — pelatihan, garansi, dan maintenance.\n\nTertarik bekerja sama? [Mulai proyek Anda](/order) — atau kirim pesan lewat [halaman kontak](/contact).",
                'seo_title' => 'Tentang OmniRoute Studio',
                'seo_description' => 'Kenali OmniRoute Studio — digital agency yang membangun website presisi, cepat, dan estetik sejak 2020.',
            ],
            [
                'title' => 'Harga & Paket',
                'slug' => 'pricing',
                'content' => "## Investasi yang jelas\n\nKami percaya harga harus transparan. Berikut paket layanan kami:\n\n### Starter — Rp 3.500.000\n\n- Landing page 1 halaman\n- Desain custom\n- Form lead + WhatsApp\n- Selesai 5–7 hari\n\n### Business — Rp 7.500.000\n\n- Company profile hingga 8 halaman\n- Blog + CMS\n- Optimasi SEO dasar\n- Selesai 2–3 minggu\n\n### Custom — Diskusi\n\n- E-commerce / web application\n- Fitur dan integrasi khusus\n- Timeline sesuai kebutuhan\n\n> Semua paket termasuk: desain responsif, SSL, pelatihan penggunaan, dan garansi 3 bulan.\n\nButuh estimasi lebih akurat? [Konsultasi gratis](/contact) atau [mulai order](/order).",
                'seo_title' => 'Harga & Paket — OmniRoute Studio',
                'seo_description' => 'Paket pembuatan website transparan: Starter, Business, dan Custom. Mulai dari Rp 3.500.000.',
            ],
            [
                'title' => 'Kebijakan Privasi',
                'slug' => 'privacy',
                'content' => "## Kebijakan Privasi\n\nTerakhir diperbarui: Agustus 2026\n\n### Data yang kami kumpulkan\n\nKami mengumpulkan data yang Anda kirimkan melalui form kontak dan form order: nama, email, nomor telepon, nama perusahaan, dan pesan.\n\n### Penggunaan data\n\nData digunakan hanya untuk:\n\n1. Menindaklanjuti permintaan Anda.\n2. Mengirim penawaran yang relevan (dengan persetujuan).\n3. Meningkatkan layanan kami.\n\n### Perlindungan\n\nSeluruh data disimpan dengan akses terbatas dan proteksi berlapis. Kami tidak menjual data Anda kepada pihak ketiga.\n\n### Kontak\n\nUntuk pertanyaan seputar privasi, hubungi [hello@omniroute.dev](mailto:hello@omniroute.dev).",
                'seo_title' => 'Kebijakan Privasi — OmniRoute Studio',
                'seo_description' => 'Kebijakan privasi OmniRoute Studio.',
            ],
            [
                'title' => 'Syarat & Ketentuan',
                'slug' => 'terms',
                'content' => "## Syarat & Ketentuan\n\nTerakhir diperbarui: Agustus 2026\n\n### Ruang lingkup\n\nLayanan OmniRoute Studio meliputi desain, pengembangan, dan pemeliharaan website. Detail layanan diatur dalam proposal yang disetujui kedua pihak.\n\n### Pembayaran\n\n1. Uang muka 50% di awal proyek.\n2. Pelunasan 50% sebelum website diluncurkan.\n3. Pembayaran melalui transfer bank atau metode yang disepakati.\n\n### Revisi\n\nSetiap paket mencakup jumlah revisi tertentu. Revisi tambahan di luar paket dikenakan biaya sesuai kesepakatan.\n\n### Garansi\n\nGaransi perbaikan bug berlaku 3 bulan setelah peluncuran. Perubahan konten atau fitur di luar lingkup tidak termasuk garansi.\n\n### Hak kekayaan intelektual\n\nKode dan desain menjadi milik klien setelah pelunasan penuh, kecuali komponen berlisensi pihak ketiga.",
                'seo_title' => 'Syarat & Ketentuan — OmniRoute Studio',
                'seo_description' => 'Syarat dan ketentuan layanan OmniRoute Studio.',
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run()
    {
        $portfolios = [
            [
                'title' => 'PT Nusantara Logistik',
                'slug' => 'pt-nusantara-logistik',
                'category' => 'company-profile',
                'cover_color' => '#0A0A0A',
                'cover_image' => 'images/portfolio/portfolio-1.jpg',
                'description' => "Redesign company profile untuk perusahaan logistik nasional. Fokus pada kecepatan muat dan kredibilitas:\n\n- Struktur informasi 6 halaman yang jelas\n- Dashboard pencarian tracking terintegrasi\n- Skor Lighthouse 98 (mobile)\n- Konten dikelola mandiri lewat CMS internal",
                'link' => 'https://nusantaralogistik.example.com',
                'tech_stack' => ['Laravel', 'PostgreSQL', 'Tailwind'],
                'year' => '2025',
                'sort_order' => 1,
            ],
            [
                'title' => 'Kopi Luhur — E-Commerce',
                'slug' => 'kopi-luhur-ecommerce',
                'category' => 'e-commerce',
                'cover_color' => '#C2410C',
                'cover_image' => 'images/portfolio/portfolio-2.jpg',
                'description' => "Toko online specialty coffee dengan 200+ SKU:\n\n- Katalog produk + filter roast level\n- Checkout sekali klik dengan Midtrans\n- Manajemen stok multi-gudang\n- Konversi naik 38% setelah redesign",
                'link' => 'https://kopiluhur.example.com',
                'tech_stack' => ['Laravel', 'MySQL', 'Vue.js', 'Midtrans'],
                'year' => '2025',
                'sort_order' => 2,
            ],
            [
                'title' => 'Summit Conference 2026',
                'slug' => 'summit-conference-2026',
                'category' => 'landing-page',
                'cover_color' => '#1D4ED8',
                'cover_image' => 'images/portfolio/portfolio-3.jpg',
                'description' => "Landing page event teknologi dengan 12.000+ registrasi:\n\n- Multi-section: agenda, pembicara, tiket\n- Form registrasi + integrasi email marketing\n- Load time 1,4 detik di 4G\n- A/B testing headline menghasilkan +22% konversi",
                'link' => 'https://summit2026.example.com',
                'tech_stack' => ['Astro', 'Tailwind', 'Resend'],
                'year' => '2026',
                'sort_order' => 3,
            ],
            [
                'title' => 'HaloKlinik — Booking System',
                'slug' => 'haloklinik-booking',
                'category' => 'web-app',
                'cover_color' => '#16A34A',
                'cover_image' => 'images/portfolio/portfolio-4.jpg',
                'description' => "Sistem booking dan manajemen antrean untuk klinik:\n\n- Booking online + reminder WhatsApp\n- Dashboard admin & dokter\n- Riwayat pasien dengan rekam medis digital\n- 3.000+ transaksi per bulan stabil",
                'link' => 'https://haloklinik.example.com',
                'tech_stack' => ['Laravel', 'PostgreSQL', 'React', 'WhatsApp API'],
                'year' => '2025',
                'sort_order' => 4,
            ],
            [
                'title' => 'Arsitektur Ruang — Studio',
                'slug' => 'arsitektur-ruang',
                'category' => 'company-profile',
                'cover_color' => '#B45309',
                'cover_image' => 'images/portfolio/portfolio-5.jpg',
                'description' => "Portofolio digital studio arsitektur dengan pendekatan galeri:\n\n- Grid karya 4:3 yang konsisten\n- Studi kasus per proyek\n- Mode gelap default yang dramatis\n- Enam kali lipat inquiry setelah peluncuran",
                'link' => 'https://arsitekturruang.example.com',
                'tech_stack' => ['Next.js', 'Sanity', 'Vercel'],
                'year' => '2024',
                'sort_order' => 5,
            ],
            [
                'title' => 'FitTrack — Fitness App',
                'slug' => 'fittrack-fitness-app',
                'category' => 'web-app',
                'cover_color' => '#DB2777',
                'cover_image' => 'images/portfolio/portfolio-6.jpg',
                'description' => "Aplikasi web untuk personal trainer:\n\n- Program latihan & progres tracking\n- Video tutorial tersinkronisasi\n- Manajemen klien untuk trainer\n- 1.500+ pengguna aktif bulanan",
                'link' => 'https://fittrack.example.com',
                'tech_stack' => ['Laravel', 'Vue.js', 'PostgreSQL'],
                'year' => '2026',
                'sort_order' => 6,
            ],
        ];

        foreach ($portfolios as $portfolio) {
            Portfolio::updateOrCreate(['slug' => $portfolio['slug']], $portfolio);
        }
    }
}

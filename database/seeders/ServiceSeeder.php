<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Website Company Profile',
                'slug' => 'website-company-profile',
                'icon' => 'building',
                'short_description' => 'Website resmi perusahaan dengan desain Swiss yang kredibel, cepat, dan SEO-friendly.',
                'description' => "Company profile adalah wajah digital pertama yang dilihat calon klien. Kami membangunnya dengan presisi:\n\n- Struktur informasi yang jelas (tentang, layanan, portofolio, kontak)\n- Desain grid Swiss yang konsisten dan mudah discan\n- Kecepatan muat di bawah 2 detik\n- Optimasi SEO dasar + integrasi analytics\n- Panel admin sederhana untuk update konten mandiri",
                'features' => [
                    'Hingga 8 halaman',
                    'Desain custom ala Swiss',
                    'Optimasi SEO dasar',
                    'Integrasi WhatsApp & Google Maps',
                    'Training penggunaan CMS',
                    'Garansi 3 bulan',
                ],
                'starting_price' => 'Rp 7.500.000',
                'sort_order' => 1,
            ],
            [
                'title' => 'E-Commerce Website',
                'slug' => 'e-commerce-website',
                'icon' => 'cart',
                'short_description' => 'Toko online lengkap: katalog produk, keranjang, checkout, dan pembayaran otomatis.',
                'description' => "Jualan online tanpa ribet. Kami bangun toko online yang cepat dan mudah dikelola:\n\n- Katalog produk dengan kategori & pencarian\n- Keranjang belanja + checkout aman\n- Integrasi payment gateway (Midtrans/Xendit)\n- Manajemen stok & laporan penjualan\n- Desain mobile-first yang konversi",
                'features' => [
                    'Katalog & kategori produk',
                    'Checkout + payment gateway',
                    'Manajemen stok',
                    'Laporan penjualan',
                    'Halaman produk unlimited',
                    'Garansi 3 bulan',
                ],
                'starting_price' => 'Rp 12.500.000',
                'sort_order' => 2,
            ],
            [
                'title' => 'Landing Page',
                'slug' => 'landing-page',
                'icon' => 'layout',
                'short_description' => 'Halaman satu layar yang fokus pada satu tujuan: mengubah pengunjung menjadi lead.',
                'description' => "Landing page yang tepat sasaran untuk campaign iklan, product launch, atau event:\n\n- Copywriting & struktur yang fokus pada konversi\n- Desain hero yang kuat + CTA jelas\n- Form lead terintegrasi ke CRM/email\n- A/B testing siap (Google Optimize)\n- Tracking pixel & analytics terpasang",
                'features' => [
                    '1 halaman fokus konversi',
                    'Copywriting profesional',
                    'Form lead terintegrasi',
                    'Tracking pixel & analytics',
                    'Optimasi kecepatan',
                    'Revisi 2×',
                ],
                'starting_price' => 'Rp 3.500.000',
                'sort_order' => 3,
            ],
            [
                'title' => 'Web Application',
                'slug' => 'web-application',
                'icon' => 'code',
                'short_description' => 'Sistem berbasis web: dashboard, CRM, booking, hingga SaaS yang disesuaikan kebutuhan.',
                'description' => "Butuh sistem khusus? Kami rancang dan bangun web application sesuai proses bisnis Anda:\n\n- Analisis kebutuhan & arsitektur sistem\n- UI/UX yang efisien untuk produktivitas tinggi\n- API dan integrasi pihak ketiga\n- Keamanan berlapis (auth, enkripsi, audit log)\n- Dokumentasi teknis + training",
                'features' => [
                    'Analisis kebutuhan',
                    'UI/UX custom',
                    'API & integrasi',
                    'Keamanan berlapis',
                    'Dokumentasi teknis',
                    'Maintenance 3 bulan',
                ],
                'starting_price' => 'Rp 25.000.000',
                'sort_order' => 4,
            ],
            [
                'title' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'icon' => 'pen',
                'short_description' => 'Desain antarmuka yang presisi dan estetik — dari wireframe hingga design system.',
                'description' => "Desain bukan sekadar tampilan, tapi cara pengguna menyelesaikan masalahnya:\n\n- Riset & wireframe berbasis data\n- Design system (tokens, komponen, grid)\n- Prototype interaktif untuk user testing\n- Handoff rapi ke developer (Figma)\n- Iterasi cepat 3 siklus revisi",
                'features' => [
                    'Riset pengguna',
                    'Wireframe & prototype',
                    'Design system lengkap',
                    'User testing',
                    'Figma handoff',
                    'Revisi 3×',
                ],
                'starting_price' => 'Rp 4.500.000',
                'sort_order' => 5,
            ],
            [
                'title' => 'SEO & Maintenance',
                'slug' => 'seo-maintenance',
                'icon' => 'search',
                'short_description' => 'Website cepat, aman, dan naik peringkat — perawatan berkala + optimasi pencarian.',
                'description' => "Website yang sehat adalah website yang terus berkembang:\n\n- Audit teknis SEO bulanan\n- Optimasi kecepatan & Core Web Vitals\n- Pembaruan keamanan & backup rutin\n- Monitoring uptime 24/7\n- Laporan performa bulanan",
                'features' => [
                    'Audit SEO bulanan',
                    'Optimasi kecepatan',
                    'Keamanan & backup',
                    'Monitoring uptime',
                    'Laporan bulanan',
                    'Support prioritas',
                ],
                'starting_price' => 'Rp 1.500.000 / bln',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}

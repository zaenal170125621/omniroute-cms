<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $testimonials = [
            [
                'client_name' => 'Rina Wijaya',
                'position' => 'CEO',
                'company' => 'PT Nusantara Logistik',
                'photo' => '/images/avatars/avatar-1.jpg',
                'quote' => 'Website baru kami terlihat jauh lebih profesional. Prosesnya rapi, tepat waktu, dan tim OmniRoute sangat komunikatif. Klien baru sering menyebut website kami sebagai alasan mereka percaya.',
                'rating' => 5,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Andi Pratama',
                'position' => 'Founder',
                'company' => 'Kopi Luhur',
                'photo' => '/images/avatars/avatar-2.jpg',
                'quote' => 'Penjualan online naik 38% dalam 3 bulan setelah redesign. Yang paling saya suka: panel adminnya simpel, tim saya bisa update produk sendiri tanpa bertanya ke developer.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Siti Rahmawati',
                'position' => 'Marketing Lead',
                'company' => 'Summit Conference',
                'photo' => '/images/avatars/avatar-3.jpg',
                'quote' => 'Landing page-nya cepat banget dan konversinya luar biasa. 12 ribu pendaftar datang dari halaman itu. Desainnya bersih, sesuai brand, dan enak dilihat.',
                'rating' => 5,
                'sort_order' => 3,
            ],
            [
                'client_name' => 'Budi Santoso',
                'position' => 'Direktur',
                'company' => 'HaloKlinik',
                'photo' => '/images/avatars/avatar-4.jpg',
                'quote' => 'Sistem booking yang dibangun OmniRoute menyelesaikan masalah antrean kami. Timnya memahami kebutuhan medis dan keamanan data. Sangat direkomendasikan.',
                'rating' => 5,
                'sort_order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonial['client_name']],
                $testimonial
            );
        }
    }
}

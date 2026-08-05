<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title' => 'Mengapa Website Company Profile Masih Penting di 2026',
                'slug' => 'mengapa-website-company-profile-penting',
                'category' => 'Tips Bisnis',
                'cover_image' => 'images/blog/blog-3.jpg',
                'excerpt' => 'Sosial media boleh ramai, tapi website tetap satu-satunya aset digital yang Anda kendalikan penuh. Ini alasannya.',
                'content' => "## Website adalah aset, media sosial adalah pinjaman\n\nAlgoritma berubah, akun bisa dibekukan, tapi website Anda tetap milik Anda. Inilah mengapa company profile yang solid masih menjadi fondasi kredibilitas bisnis.\n\n## Yang dicari calon klien\n\n1. **Kecepatan** — 53% pengunjung pergi jika halaman > 3 detik.\n2. **Kejelasan** — apa yang Anda jual harus terlihat dalam 5 detik pertama.\n3. **Kredibilitas** — portofolio, testimoni, dan kontak yang jelas.\n\n## Mulai dari mana\n\nMulai dari struktur: Beranda, Layanan, Portofolio, Tentang, Kontak. Jangan over-design. Desain Swiss justru menonjol karena kebersihan dan konsistensinya.",
                'status' => 'published',
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Gaya Desain Swiss: Mengapa Minimalis Selalu Menang',
                'slug' => 'gaya-desain-swiss-minimalis',
                'category' => 'Desain',
                'cover_image' => 'images/blog/blog-2.jpg',
                'excerpt' => 'Grid, tipografi, dan ruang kosong — tiga pilar Swiss Style yang membuat website terlihat mahal tanpa ornamen.',
                'content' => "## Sejarah singkat\n\nSwiss Style lahir di tahun 1950-an dan menjadi fondasi desain modern. Prinsipnya: informasi disampaikan sejelas dan seobjektif mungkin.\n\n## Tiga pilar\n\n- **Grid** — semua elemen sejajar pada kolom yang disiplin.\n- **Tipografi** — hierarki kuat, sans-serif, kontras besar.\n- **Ruang kosong** — whitespace bukan area kosong, melainkan alat bantu fokus.\n\n## Kenapa efektif untuk bisnis\n\nWebsite minimalis memuat lebih cepat, mudah discan, dan membuat brand terlihat lebih dipercaya. Riset Nielsen Norman Group menunjukkan pengguna hanya menghabiskan 5–10 detik di halaman pertama.\n\nDi OmniRoute, kami menerapkan prinsip ini di setiap proyek — dari landing page hingga web application.",
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => '7 Pertanyaan Sebelum Memesan Website',
                'slug' => '7-pertanyaan-sebelum-memesan-website',
                'category' => 'Tips Bisnis',
                'cover_image' => 'images/blog/blog-1.jpg',
                'excerpt' => 'Sebelum menghubungi vendor, jawab 7 pertanyaan ini agar proyek berjalan cepat dan budget tidak membengkak.',
                'content' => "## Tanyakan pada diri sendiri\n\n1. **Tujuan utama?** — jualan, branding, atau info?\n2. **Target pengguna?** — siapa yang datang dan apa yang mereka butuhkan?\n3. **Jumlah halaman?** — perkiraan kasar membantu estimasi harga.\n4. **Konten sudah ada?** — teks dan foto mempercepat proses 2× lipat.\n5. **Fitur khusus?** — booking, pembayaran, multi-bahasa?\n6. **Siapa yang mengelola konten?** — butuh CMS yang simpel?\n7. **Timeline?** — kapan website harus tayang?\n\n## Cara kami bekerja\n\nSetiap proyek dimulai dari analisis singkat 30 menit untuk menjawab pertanyaan di atas. Hasilnya: proposal harga yang realistis dan timeline yang jelas.\n\nGunakan halaman [Order](/order) untuk memulai diskusi.",
                'status' => 'published',
                'published_at' => now()->subDay(),
            ],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }
    }
}

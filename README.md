# OmniRoute Studio — Website Company + CMS

Website company profile untuk jasa pembuatan website (web agency) lengkap dengan **CMS admin panel** untuk mengelola konten dan lead. Dibangun dengan **Laravel 9 + PostgreSQL** dan gaya desain **Swiss / International Typographic Style**.

## Fitur

### Website Publik
| Halaman | Deskripsi |
|---|---|
| `/` | Beranda: hero, ticker layanan, layanan unggulan, portofolio terpilih, statistik, testimoni, blog, CTA |
| `/services` | Daftar layanan + halaman detail per layanan |
| `/portfolio` | Galeri portofolio + filter kategori + halaman detail |
| `/pricing` | Tabel paket harga (Starter / Business / Custom) |
| `/blog` | Daftar artikel + halaman detail |
| `/about`, `/privacy`, `/terms` | Halaman statis yang dikelola lewat CMS |
| `/contact` | Form kontak → masuk ke modul Leads |
| `/order` | Form order multi-step (pilih paket → data kontak → kebutuhan) → masuk ke modul Leads |

### CMS Admin (`/admin`)
| Modul | Fitur |
|---|---|
| **Dashboard** | KPI: total lead, lead baru, deal, konten aktif |
| **Leads** | List + filter status/sumber/pencarian, detail dengan timeline riwayat status, update status (Baru → Dihubungi → Proposal → Deal/Batal) + catatan |
| **Layanan** | CRUD + field fitur dinamis + harga mulai |
| **Portofolio** | CRUD + upload cover + tech stack dinamis + filter kategori |
| **Testimoni** | CRUD + rating + toggle tampil |
| **Blog** | CRUD + status draft/terbit + SEO field |
| **Halaman** | CRUD halaman statis (about, pricing, dll) |
| **Pengguna** | Kelola user admin (admin/editor/sales) |
| **Pengaturan** | Kontak, sosial media, hero, SEO global |

### Hak Akses (Role)
- **admin** — semua modul termasuk pengguna & pengaturan
- **editor** — kelola konten (layanan, portofolio, testimoni, blog, halaman)
- **sales** — hanya modul leads

## Tech Stack

- Laravel **9.5** (PHP 8.0+)
- PostgreSQL **15+** (lokal, service `omniroute-pg` port 5433)
- Blade + vanilla CSS/JS (tanpa framework frontend)
- Desain Swiss: grid ketat, sans-serif, warna hitam/putih + aksen oranye `#FF4D00`

## Instalasi

```bash
# 1. Dependensi
composer install

# 2. Konfigurasi .env (lihat contoh di bawah)
copy .env.example .env

# 3. Key aplikasi
php artisan key:generate

# 4. Koneksi database (PostgreSQL sudah berjalan di port 5433)
#    DB_DATABASE=omniroute  DB_USERNAME=omniroute  DB_PASSWORD=secret123

# 5. Migrasi + seed data demo
php artisan migrate --seed

# 6. Symlink untuk upload gambar
php artisan storage:link

# 7. Jalankan
php artisan serve
```

Akses: `http://127.0.0.1:8000` (website) dan `http://127.0.0.1:8000/admin` (CMS).

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Admin | `admin@omniroute.dev` | `password` |
| Editor | `editor@omniroute.dev` | `password` |
| Sales | `sales@omniroute.dev` | `password` |

## Struktur Utama

```
app/Helpers/helpers.php          → helper setting(), swiss_block(), wa_number(), wa_link()
app/Http/Controllers/           → controller publik + Admin\ (panel)
app/Http/Middleware/RoleMiddleware.php → cek role (auth:admin,editor,sales)
app/Models/                     → Service, Portfolio, Testimonial, Post, Page, Lead, LeadHistory, Setting, User
database/migrations/            → skema: services, portfolios, testimonials, posts, pages, leads, lead_histories, settings
database/seeders/               → data demo + 3 akun user + pengaturan website
resources/views/public/         → halaman website (layout Swiss)
resources/views/admin/          → halaman panel (layout compact)
public/css/public.css           → gaya Swiss (website)
public/css/admin.css            → gaya compact (panel)
routes/web.php                  → semua route publik + admin
```

## Catatan

- **Alur lead**: form `/order` dan `/contact` otomatis membuat lead berstatus "Baru"; sales/admin memperbarui status lewat panel dan setiap perubahan tercatat di timeline.
- **Gambar cover**: upload tersimpan di `storage/app/public` (symlink `public/storage`). Jika kosong, tampil placeholder blok warna ala Swiss.
- **Isi konten (blog/halaman)**: format sederhana — `# Heading`, `- list`, `> kutipan`.
- Database PostgreSQL lokal dijalankan via `pg_ctl` (data di `.pgdata`, log di `pg-server.log`) — lihat skrip di `database/pg` jika ada.

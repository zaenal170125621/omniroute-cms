# PRD — Web Company Profile + CMS Penjualan Website

| | |
|---|---|
| **Nama Produk** | Company Profile Website & CMS (Internal) |
| **Versi** | 1.0 |
| **Tanggal** | 2026-08-05 |
| **Penulis** | Business Analyst |
| **Status** | Draft untuk review |
| **Gaya Visual** | Swiss / International Typographic Style — minimalis, estetik, presisi |

---

## 1. Ringkasan Eksekutif

Produk terdiri dari **dua bagian**:

1. **Public Website (Company Profile)** — wajah perusahaan yang menampilkan layanan, portofolio, testimoni, dan jalur pemesanan website kepada calon klien.
2. **CMS / Admin Panel** — alat internal (dan opsional untuk klien) untuk mengelola seluruh konten website tanpa menulis kode: layanan, portofolio, testimoni, artikel blog, halaman statis, dan data lead/pesanan.

Nilai utama produk: **klien bisa melihat hasil kerja (company profile) dan membeli layanan pembuatan website langsung dari halaman yang sama**, sementara tim internal mengelola semuanya dari satu CMS yang **compact** (padat, cepat diakses, tanpa elemen dekoratif yang membuang ruang).

---

## 2. Tujuan & Sasaran (Goals)

| No | Tujuan | Ukuran Keberhasilan (KPI) |
|----|--------|---------------------------|
| G1 | Menampilkan kredibilitas perusahaan secara profesional | Bounce rate < 45% di halaman beranda |
| G2 | Mengubah pengunjung menjadi lead/pesanan | Konversi form → lead ≥ 3% |
| G3 | Mempercepat produksi konten tanpa developer | Waktu publikasi konten baru < 15 menit |
| G4 | Menjaga konsistensi brand | 100% halaman mengikuti design system yang sama |
| G5 | Memudahkan follow-up penjualan | 100% lead tersimpan otomatis di CMS dengan status jelas |

**Non-tujuan (Non-Goals):**
- Bukan e-commerce produk fisik (tidak ada keranjang belanja/checkout pembayaran di v1).
- Bukan marketplace multi-vendor.
- Bukan sistem ERP/akuntansi.

---

## 3. Target Pengguna & Persona

### 3.1 Pengguna Publik Website
| Persona | Kebutuhan |
|---------|-----------|
| **Pemilik UMKM / Startup** | Ingin website murah, cepat jadi, terlihat profesional. Butuh estimasi harga jelas. |
| **Pemilik bisnis skala menengah** | Ingin website custom + fitur lebih (e-commerce, booking). Butuh portofolio relevan. |
| **Agen/partner** | Butuh info kerja sama, kontak langsung, dan halaman "About" yang kredibel. |

### 3.2 Pengguna CMS
| Persona | Peran di Sistem | Kebutuhan |
|---------|-----------------|-----------|
| **Admin / Super Admin** | Akses penuh | Kelola semua modul, kelola user, lihat laporan. |
| **Content Editor** | Akses konten | Kelola blog, testimoni, portofolio, halaman statis. |
| **Sales / CS** | Akses lead & pesanan | Lihat, update status, dan follow-up lead. |
| **Klien (opsional, fase 2)** | Akses terbatas | Lihat status order dan konten miliknya. |

---

## 4. Ruang Lingkup

### 4.1 In Scope (v1)
- Public website (halaman beranda, layanan, portofolio, harga, tentang, blog, kontak).
- Form order/lead + penyimpanan otomatis ke CMS.
- CMS dengan modul: Dashboard, Layanan, Portofolio, Testimoni, Blog, Halaman, Lead/Pesanan, Pengaturan, Manajemen User.
- Autentikasi & kontrol akses (role-based).
- CRUD penuh pada seluruh modul konten.
- Desain system (design tokens, komponen, grid) gaya Swiss minimalis.
- Responsif (desktop, tablet, mobile).

### 4.2 Out of Scope (v1 → rencana fase 2)
- Pembayaran online & invoice otomatis.
- Multibahasa (i18n) penuh.
- Akses klien ke CMS.
- Multi-tenant / white-label.
- A/B testing dan analytics lanjutan.

---

## 5. Sitemap & Struktur Halaman

### 5.1 Public Website (Frontend)
```
/                     → Beranda (Hero, layanan unggulan, portofolio terpilih, testimoni, CTA)
/about                → Tentang kami (misi, timeline, tim)
/services             → Daftar layanan lengkap
/services/:slug       → Detail layanan (fitur, alur, harga mulai)
/portfolio            → Grid portofolio (filter kategori)
/portfolio/:slug      → Detail proyek (studi kasus)
/pricing              → Paket harga + tabel perbandingan
/blog                 → Daftar artikel
/blog/:slug           → Detail artikel
/contact              → Form kontak + info perusahaan
/order                → Form pemesanan website (multi-step)
/legal/privacy        → Kebijakan privasi
/legal/terms          → Syarat & ketentuan
```

### 5.2 CMS (Admin Panel)
```
/admin/login          → Halaman login
/admin                → Dashboard (ringkasan KPI)
/admin/services       → CRUD layanan
/admin/portfolio      → CRUD portofolio
/admin/testimonials   → CRUD testimoni
/admin/blog           → CRUD artikel (draft/publish)
/admin/pages          → Kelola halaman statis (About, Pricing, Legal)
/admin/leads          → Daftar lead/pesanan + update status
/admin/leads/:id      → Detail lead (timeline follow-up)
/admin/users          → Kelola user & role
/admin/settings       → Pengaturan umum (logo, kontak, sosial media, SEO global)
/admin/media          → Perpustakaan media (gambar, file)
```

---

## 6. Persyaratan Fungsional (Functional Requirements)

### 6.1 Public Website

| ID | Persyaratan | Prioritas |
|----|-------------|-----------|
| FR-01 | Menampilkan hero section dengan tagline, CTA utama ("Lihat Layanan" / "Mulai Proyek"), dan visual minimalis. | P0 |
| FR-02 | Menampilkan layanan dari data CMS (ikon, judul, deskripsi singkat, harga mulai). | P0 |
| FR-03 | Menampilkan portofolio dengan filter kategori (website company profile, e-commerce, landing page, web app). | P0 |
| FR-04 | Menampilkan testimoni klien (nama, jabatan, perusahaan, kutipan, foto opsional). | P1 |
| FR-05 | Halaman pricing dengan tabel perbandingan paket (Starter / Business / Custom) + CTA order. | P0 |
| FR-06 | Form pemesanan multi-step: (1) pilih layanan/paket, (2) data kontak & deskripsi kebutuhan, (3) ringkasan + submit. | P0 |
| FR-07 | Form kontak sederhana (nama, email, pesan) → tersimpan sebagai lead. | P0 |
| FR-08 | Blog dengan daftar artikel, kategori, pencarian, dan halaman detail. | P1 |
| FR-09 | Halaman statis (About, Legal) dapat diedit dari CMS tanpa deploy. | P1 |
| FR-10 | Meta title/description per halaman dapat diatur dari CMS (SEO dasar). | P1 |
| FR-11 | Seluruh halaman responsif dan mempertahankan estetika di mobile. | P0 |
| FR-12 | Validasi form (format email, required field) dengan pesan error yang jelas. | P0 |

### 6.2 CMS

| ID | Persyaratan | Prioritas |
|----|-------------|-----------|
| FR-20 | Login dengan email + password; sesi aman (token, masa berlaku). | P0 |
| FR-21 | Role-based access: Admin (penuh), Editor (konten), Sales (lead saja). | P0 |
| FR-22 | Dashboard ringkas: total lead, lead baru hari ini, konversi, artikel draft, portofolio aktif — dalam satu layar tanpa scroll berlebih. | P0 |
| FR-23 | CRUD Layanan: judul, slug, ikon, deskripsi, fitur (list), harga mulai, urutan tampil, status aktif. | P0 |
| FR-24 | CRUD Portofolio: judul, kategori, gambar cover, galeri, deskripsi, link live, teknologi, tahun, urutan. | P0 |
| FR-25 | CRUD Testimoni: nama, jabatan, perusahaan, kutipan, foto, rating, status tampil. | P1 |
| FR-26 | CRUD Blog: judul, slug, kategori, konten (editor WYSIWYG/rich text), gambar cover, SEO field, status draft/publish, jadwal publikasi. | P1 |
| FR-27 | Kelola halaman statis: konten flexible (blok teks, gambar, CTA), slug, status. | P1 |
| FR-28 | Daftar Lead/Pesanan: tabel dengan kolom nama, layanan, harga estimasi, status, tanggal; pencarian & filter status. | P0 |
| FR-29 | Detail Lead: data lengkap, riwayat perubahan status (timeline), catatan internal. | P0 |
| FR-30 | Status lead: Baru → Dihubungi → Proposal → Deal / Batal (workflow dapat dikonfigurasi). | P0 |
| FR-31 | Manajemen User: buat/ubah/hapus user, tetapkan role, aktif/nonaktif. | P0 |
| FR-32 | Pengaturan umum: nama perusahaan, logo, kontak (email/telepon/alamat), media sosial, tracking script. | P0 |
| FR-33 | Media library: upload gambar, kategorisasi folder, pemilihan gambar via picker. | P1 |
| FR-34 | Notifikasi: badge lead baru di sidebar + opsi notifikasi email ke sales. | P1 |
| FR-35 | Semua daftar (list view) mendukung pencarian, filter, pagination, dan sorting. | P0 |
| FR-36 | Auto-save draft pada form panjang (blog, portofolio). | P2 |

---

## 7. Persyaratan Non-Fungsional (NFR)

| Kode | Aspek | Persyaratan |
|------|-------|-------------|
| NFR-01 | Performa | Skor Lighthouse ≥ 90 (Performance, SEO, Accessibility) pada halaman publik. |
| NFR-02 | Performa | Waktu muat halaman publik < 2,5 detik (3G/4G), CMS < 2 detik per navigasi. |
| NFR-03 | Keamanan | Autentikasi aman, rate limiting pada login, hashing password, proteksi CSRF, sanitasi input, upload divalidasi (tipe & ukuran). |
| NFR-04 | Keamanan | HTTPS wajib di semua environment produksi. |
| NFR-05 | Ketersediaan | Uptime target ≥ 99,5% (bulanan). |
| NFR-06 | Skalabilitas | Arsitektur mendukung penambahan modul CMS tanpa rewrite. |
| NFR-07 | SEO | URL bersih (`/services/web-development`), canonical, sitemap.xml otomatis, Open Graph. |
| NFR-08 | Aksesibilitas | Kontras warna memenuhi WCAG AA; navigasi keyboard; alt text pada gambar. |
| NFR-09 | Data | Backup database harian otomatis, retensi 30 hari. |
| NFR-10 | Audit | Log aktivitas admin (siapa mengubah apa, kapan) minimal untuk konten & user. |

---

## 8. Desain UI/UX — Swiss / International Minimalis

### 8.1 Prinsip Desain
1. **Grid & Tipografi** — layout berbasis grid ketat (mis. 12 kolom), tipografi kuat (heading bold, kontras besar), memakai type scale yang konsisten.
2. **Minimalis** — tanpa ornamen dekoratif; putih/ruang kosong sebagai elemen desain; maksimal 2–3 warna aksen.
3. **Estetik & Presisi** — alignment presisi, whitespace simetris, ikon linier konsisten, foto dengan crop konsisten.
4. **Fungsionalitas dulu** — setiap elemen punya tujuan; tanpa efek animasi berlebihan (maks. transisi 150–300ms, hanya untuk feedback).

### 8.2 Design Tokens (Referensi)
| Token | Nilai |
|-------|-------|
| Warna dasar | `#FFFFFF` (putih), `#0A0A0A` (hitam) |
| Warna aksen | Satu warna utama (mis. `#FF4D00` / merah internasional atau `#0057FF` / biru) + 1 warna netral abu (`#F5F5F5`, `#E5E5E5`) |
| Tipografi | Sans-serif grotesk (mis. **Inter**, **Neue Haas Grotesk**, **Helvetica Now**, atau **Space Grotesk**) |
| Skala tipe | 12 / 14 / 16 / 20 / 28 / 36 / 48 / 64 px |
| Spacing | Basis 8px (8, 16, 24, 32, 48, 64, 96) |
| Radius | 0–4px (minimal/sedikit; Swiss cenderung sharp corner) |
| Border | 1px solid `#E5E5E5` |

### 8.3 Komponen Kunci (Public)
- Sticky header transparan → solid saat scroll; nav + CTA.
- Hero dengan headline besar (72–96px desktop), subline, CTA.
- Section label ala Swiss: teks kecil uppercase + garis (mis. `01 — LAYANAN`).
- Kartu layanan: ikon, judul, deskripsi, "Mulai dari Rp X".
- Grid portofolio: rasio konsisten (4:3 atau 1:1), hover menampilkan judul + kategori.
- Tabel pricing: kolom paket, baris fitur, kolom populer diberi aksen warna.
- Footer: navigasi 3 kolom + kontak + copyright.

### 8.4 Desain CMS yang Compact
**Prinsip compact**: informasi sebanyak mungkin per piksel tanpa terasa sesak — kepadatan ala alat profesional (Linear, Notion, Vercel dashboard).

| Aspek | Keputusan Desain |
|-------|------------------|
| Layout | Sidebar kiri 220–240px (icon + label kecil), konten utama, tanpa header berulang besar |
| Density | Table row height 40px, form field compact (padding 8–10px), font 13–14px |
| Dashboard | Kartu KPI kecil di atas (angka besar + label kecil), di bawahnya hanya 2 tabel (lead terbaru & konten pending) |
| Daftar (list) | Tabel datar: kolom minimal (judul, status, tanggal, aksi); aksi icon-only dengan tooltip |
| Form | Layout 2 kolom pada desktop; field opsional ditandai "(opsional)"; tombol aksi di kiri bawah form |
| Status | Badge warna: Baru (biru), Dihubungi (kuning), Proposal (ungu), Deal (hijau), Batal (merah/netral) |
| Mode | Dark mode opsional (fase 2) |
| Navigasi cepat | Command palette (Ctrl+K) untuk buka halaman/modul — fase 2 |

---

## 9. Arsitektur Teknis (Referensi)

```
┌────────────────────────────────────────────────────┐
│                    CLIENT                          │
│  Public Website (SSR/SSG)     Admin Panel (SPA)    │
└───────────────┬──────────────────────┬─────────────┘
                │                      │
                └──────────┬───────────┘
                           ▼
                 ┌──────────────────┐
                 │  API / Backend   │
                 │  REST atau GraphQL│
                 └────────┬─────────┘
                          ▼
              ┌──────────────────────┐
              │  Database (PostgreSQL │
              │  / MySQL / SQLite)    │
              └──────────────────────┘
              ┌──────────────────────┐
              │  Storage (gambar,    │
              │  media upload)       │
              └──────────────────────┘
```

**Rekomendasi stack (bebas pilih, PRD ini agnostik):**
- **Frontend publik**: Next.js / Astro (SSR/SSG → SEO bagus).
- **Admin CMS**: React/Vue SPA terpisah, atau satu app dengan route `/admin`.
- **Backend**: Node.js (NestJS/Express) atau Laravel atau Django.
- **Database**: PostgreSQL (produksi), SQLite (development).
- **Auth**: JWT + refresh token, atau session-based (Laravel/Express-session).
- **Media**: upload lokal atau object storage (S3-compatible).
- **Deploy**: Vercel/Netlify untuk frontend, container/hosting VPS untuk API + DB.

**Catatan**: Jika tim kecil (1–2 developer) dan ingin rilis cepat, gunakan satu framework monolitik (mis. **Laravel + Blade + Alpine**, atau **Next.js fullstack + Prisma + SQLite/Postgres**) agar API dan CMS dalam satu codebase.

---

## 10. Alur Pengguna Kunci (User Flows)

### 10.1 Pengunjung → Lead
```
Beranda/Harga → Pilih Paket → Klik "Mulai Proyek"
      → Form (layanan, data kontak, kebutuhan)
      → Validasi → Submit → Halaman sukses ("Terima kasih,
        tim kami akan menghubungi Anda dalam 1x24 jam")
      → Lead tersimpan otomatis di CMS (status: Baru)
      → (Opsional) Email notifikasi ke sales
```

### 10.2 Admin Menangani Lead
```
Login CMS → Dashboard (badge lead baru)
  → Buka /admin/leads → Filter status "Baru"
  → Buka detail lead → Update status → "Dihubungi"
  → Tulis catatan internal → (saat deal) status "Deal"
```

### 10.3 Editor Menerbitkan Artikel
```
Login → Blog → Buat baru → Isi judul & konten (WYSIWYG)
  → Set status Draft → Preview → Publish
  → Artikel muncul di /blog dengan meta SEO
```

---

## 11. Metrik Keberhasilan Produk

| Metrik | Target (3 bulan) |
|--------|------------------|
| Kunjungan bulanan (organic) | ≥ 5.000 |
| Konversi form → lead | ≥ 3% |
| Lead per bulan | ≥ 50 |
| Lead-to-deal | ≥ 20% |
| Rata-rata waktu publikasi konten | < 15 menit |
| Lighthouse Performance (mobile) | ≥ 90 |
| Waktu muat halaman | < 2,5 dtk |

---

## 12. Milestone & Timeline (Estimasi 8–12 minggu)

| Fase | Durasi | Deliverable |
|------|--------|-------------|
| **M1 — Discovery & Desain** | 2 minggu | Design system + mockup public & CMS; finalisasi copywriting & struktur konten |
| **M2 — Fondasi** | 2 minggu | Setup project, database schema, auth & role, routing |
| **M3 — CMS Core** | 3 minggu | CRUD layanan, portofolio, testimoni, blog, halaman, media |
| **M4 — Lead & Sales** | 2 minggu | Form order multi-step, form kontak, dashboard lead, workflow status, notifikasi |
| **M5 — Public Site** | 2 minggu | Integrasi semua halaman publik + SEO + responsif |
| **M6 — QA & Launch** | 1–2 minggu | Uji performa, aksesibilitas, keamanan, content seeding, deploy |

---

## 13. Risiko & Mitigasi

| Risiko | Dampak | Mitigasi |
|--------|--------|----------|
| Ruang lingkup membengkak (scope creep) | Telat rilis | Pegang Non-Goals; fitur fase 2 dipisah jelas di backlog |
| Konten tidak siap saat launch | Website terlihat kosong | Content seeding di M2–M3 (copywriting dimulai lebih awal) |
| CMS terlalu kompleks untuk kebutuhan | Produktivitas turun | Mulai dari modul minimum (FR prioritas P0) |
| Keamanan CMS lemah | Data lead bocor | Auth ketat, rate limit, audit log, review keamanan di M6 |
| Estetika Swiss sulit dijaga konsisten | Brand terlihat tidak profesional | Design tokens + komponen terpusat; review desain per fase |

---

## 14. Pertanyaan Terbuka (Open Questions)

1. Stack teknologi final: monolitik (Laravel/Next.js) atau terpisah (frontend + API)?
2. Apakah klien perlu akses CMS di v1, atau cukup fase 2?
3. Apakah pembayaran online dibutuhkan untuk paket order (v2)?
4. Bahasa konten: Indonesia saja, atau perlu Inggris (multibahasa)?
5. Perlu blog sebagai fitur v1, atau bisa ditunda?
6. Domain & hosting sudah disiapkan? (mempengaruhi keputusan stack & deploy)
7. Apakah perlu integrasi WhatsApp/email marketing untuk follow-up lead otomatis?

---

## 15. Glossary

| Istilah | Definisi |
|---------|----------|
| **CMS** | Content Management System — sistem untuk mengelola konten website tanpa kode. |
| **Lead** | Calon klien yang mengirimkan data melalui form (order/kontak). |
| **CRUD** | Create, Read, Update, Delete — operasi dasar pengelolaan data. |
| **Design Token** | Nilai desain terpusat (warna, font, spacing) yang dipakai konsisten. |
| **SSR/SSG** | Server-Side Rendering / Static Site Generation — teknik render untuk SEO. |
| **Swiss Style** | Gaya desain grafis internasional: grid, tipografi, minimalis, presisi. |
| **Compact UI** | Antarmuka padat dengan kepadatan informasi tinggi tanpa mengorbankan keterbacaan. |

<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\LeadHistory;
use App\Models\Service;
use Illuminate\Database\Seeder;

class LeadSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@koperasi-sejahtera.id',
                'phone' => '0812-3456-7890',
                'company' => 'Koperasi Sejahtera',
                'service_slug' => 'website-company-profile',
                'package' => 'Business',
                'budget' => 'Rp 7–10 juta',
                'timeline' => '2 bulan',
                'message' => 'Membutuhkan website company profile untuk koperasi, dengan halaman anggota dan berita.',
                'status' => 'baru',
                'source' => 'order',
                'notes' => '',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@gmail.com',
                'phone' => '0821-9988-7766',
                'company' => 'Rahayu Cake & Bakery',
                'service_slug' => 'e-commerce',
                'package' => 'Starter',
                'budget' => 'Rp 3–5 juta',
                'timeline' => '1 bulan',
                'message' => 'Mau toko online untuk menjual kue, dengan pembayaran transfer bank.',
                'status' => 'dihubungi',
                'source' => 'order',
                'notes' => 'Sudah dihubungi via WhatsApp, klien minta contoh portofolio bakery.',
            ],
            [
                'name' => 'Budi Hartono',
                'email' => 'budi@ptmitrasarana.co.id',
                'phone' => '0813-2222-1111',
                'company' => 'PT Mitra Sarana',
                'service_slug' => 'web-application',
                'package' => 'Custom',
                'budget' => 'Rp 25–40 juta',
                'timeline' => '3 bulan',
                'message' => 'Perlu sistem monitoring proyek internal untuk 50 karyawan.',
                'status' => 'proposal',
                'source' => 'order',
                'notes' => 'Proposal dikirim 3 hari lalu, menunggu keputusan direksi.',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@estetikastudio.co',
                'phone' => '0857-1111-2222',
                'company' => 'Estetika Studio',
                'service_slug' => 'landing-page',
                'package' => 'Starter',
                'budget' => 'Rp 3–4 juta',
                'timeline' => '3 minggu',
                'message' => 'Landing page untuk peluncuran jasa desain interior, target konversi WhatsApp.',
                'status' => 'deal',
                'source' => 'order',
                'notes' => 'Deal! Kontrak ditandatangani, mulai pengerjaan minggu depan.',
            ],
            [
                'name' => 'Rizky Firmansyah',
                'email' => 'rizky@firmancorp.id',
                'phone' => '0896-3333-4444',
                'company' => 'Firman Corp',
                'service_slug' => 'ui-ux-design',
                'package' => 'Business',
                'budget' => 'Rp 10–15 juta',
                'timeline' => '6 minggu',
                'message' => 'Redesign UI/UX aplikasi kasir yang sudah berjalan.',
                'status' => 'batal',
                'source' => 'order',
                'notes' => 'Klien menunda proyek karena anggaran dipotong Q3.',
            ],
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya@klinikbunda.co.id',
                'phone' => '0811-5555-6666',
                'company' => 'Klinik Bunda',
                'service_slug' => 'website-company-profile',
                'package' => 'Business',
                'budget' => 'Rp 8–12 juta',
                'timeline' => '6 minggu',
                'message' => 'Website klinik dengan booking jadwal dokter online.',
                'status' => 'baru',
                'source' => 'contact',
                'notes' => '',
            ],
        ];

        foreach ($data as $item) {
            $service = Service::where('slug', $item['service_slug'])->first();

            $lead = Lead::create([
                'name' => $item['name'],
                'email' => $item['email'],
                'phone' => $item['phone'],
                'company' => $item['company'],
                'service_id' => $service?->id,
                'package' => $item['package'],
                'budget' => $item['budget'],
                'timeline' => $item['timeline'],
                'message' => $item['message'],
                'status' => $item['status'],
                'source' => $item['source'],
                'internal_notes' => $item['notes'],
            ]);

            // Riwayat status awal
            LeadHistory::create([
                'lead_id' => $lead->id,
                'status' => $item['status'],
                'note' => $item['notes'] ?: 'Lead masuk via ' . ($item['source'] === 'order' ? 'form order' : 'form kontak') . '.',
                'user_id' => null,
                'created_at' => $lead->created_at,
                'updated_at' => $lead->created_at,
            ]);
        }
    }
}

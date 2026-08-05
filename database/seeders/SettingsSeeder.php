<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            'company_name' => 'OmniRoute Studio',
            'tagline' => 'Digital agency untuk brand yang serius.',
            'logo_text' => 'OmniRoute®',
            'email' => 'hello@omniroute.dev',
            'phone' => '+62 812 3456 7890',
            'address' => 'Jl. Sudirman No. 88, Jakarta Selatan, Indonesia',
            'whatsapp' => '6281234567890',
            'instagram' => 'https://instagram.com/omniroute',
            'linkedin' => 'https://linkedin.com/company/omniroute',
            'footer_text' => 'Desain presisi. Kode rapi. Hasil yang dapat diukur.',
            'hero_badge' => 'EST. 2020 — JAKARTA, ID',
            'hero_title' => 'Website yang bekerja sekeras tim Anda.',
            'hero_subtitle' => 'Kami membangun website company profile, e-commerce, dan web application dengan desain Swiss yang presisi — cepat, estetik, dan terukur.',
            'hero_cta_primary' => 'Mulai Proyek',
            'hero_cta_secondary' => 'Lihat Portofolio',
            'seo_title' => 'OmniRoute Studio — Jasa Pembuatan Website Profesional',
            'seo_description' => 'Jasa pembuatan website company profile, e-commerce, landing page, dan web application. Desain Swiss minimalis, cepat, dan SEO-friendly.',
            'order_note' => 'Setelah mengirim, tim sales kami akan menghubungi Anda maksimal 1×24 jam kerja.',
            'lead_notify_email' => 'sales@omniroute.dev',
            'analytics_head' => '',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}

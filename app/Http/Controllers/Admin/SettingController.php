<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public const FIELDS = [
        'company_name' => 'Nama Perusahaan',
        'tagline' => 'Tagline',
        'logo_text' => 'Teks Logo',
        'email' => 'Email',
        'phone' => 'Telepon',
        'address' => 'Alamat',
        'whatsapp' => 'WhatsApp',
        'instagram' => 'Instagram',
        'linkedin' => 'LinkedIn',
        'footer_text' => 'Teks Footer',
        'hero_badge' => 'Hero — Badge',
        'hero_title' => 'Hero — Judul',
        'hero_subtitle' => 'Hero — Subjudul',
        'hero_cta_primary' => 'Hero — CTA Utama',
        'hero_cta_secondary' => 'Hero — CTA Sekunder',
        'seo_title' => 'SEO — Judul Global',
        'seo_description' => 'SEO — Deskripsi Global',
        'order_note' => 'Catatan Halaman Order',
        'lead_notify_email' => 'Email Notifikasi Lead Baru (Sales)',
        'analytics_head' => 'Kode Analytics (Header)',
    ];

    public function index()
    {
        $fields = self::FIELDS;

        return view('admin.settings', compact('fields'));
    }

    public function update(Request $request)
    {
        foreach (self::FIELDS as $key => $label) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings')
            ->with('success', 'Pengaturan berhasil disimpan.');
    }
}

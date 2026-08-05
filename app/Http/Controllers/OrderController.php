<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->get();

        $packages = [
            [
                'code' => 'starter',
                'name' => 'Starter',
                'price' => 'Rp 3.500.000',
                'desc' => 'Landing page / company profile satu halaman, 5–7 hari.',
            ],
            [
                'code' => 'business',
                'name' => 'Business',
                'price' => 'Rp 7.500.000',
                'desc' => 'Company profile multi-halaman + blog, 2–3 minggu.',
            ],
            [
                'code' => 'custom',
                'name' => 'Custom',
                'price' => 'Diskusi',
                'desc' => 'E-commerce, web app, atau kebutuhan khusus.',
            ],
        ];

        return view('public.order', compact('services', 'packages'));
    }

    public function store(Request $request)
    {
        // Honeypot anti-spam (lihat ContactController::store).
        if ($request->filled('company_site')) {
            return redirect()->route('order.success');
        }

        $validated = $request->validate([
            'package' => ['required', 'in:starter,business,custom'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'company' => ['nullable', 'string', 'max:255'],
            'service_id' => ['nullable', 'exists:services,id'],
            'budget' => ['nullable', 'string', 'max:100'],
            'timeline' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:5000'],
        ]);

        $lead = Lead::create(array_merge($validated, [
            'source' => 'order',
            'status' => 'baru',
        ]));

        notify_lead_sales($lead);

        return redirect()->route('order.success')->with('lead_id', $lead->id);
    }

    public function success()
    {
        return view('public.order-success');
    }

    public function pricing()
    {
        $packages = [
            [
                'code' => 'starter',
                'name' => 'Starter',
                'price' => 'Rp 3.500.000',
                'desc' => 'Landing page / company profile satu halaman, 5–7 hari.',
                'features' => [
                    'Desain custom & responsive',
                    'Halaman: Home, About, Contact',
                    'Form kontak & Google Maps',
                    'SEO basic (meta tags, sitemap)',
                    'Integrasi WhatsApp & Sosmed',
                    '1x revisi desain',
                    'Domain & hosting 1 tahun',
                    'Support 30 hari pasca launch',
                ],
            ],
            [
                'code' => 'business',
                'name' => 'Business',
                'price' => 'Rp 7.500.000',
                'desc' => 'Company profile multi-halaman + blog, 2–3 minggu.',
                'features' => [
                    'Semua fitur Starter',
                    'Halaman: Home, About, Services, Portfolio, Blog, Contact',
                    'CMS untuk kelola blog & portofolio',
                    'Blog system (kategori, tag, pencarian)',
                    'Portfolio/Case study dengan filter',
                    'Testimonial slider',
                    'Newsletter subscription',
                    'Analytics dashboard (GA4)',
                    '2x revisi desain',
                    'Domain & hosting 1 tahun',
                    'Support 60 hari pasca launch',
                ],
                'popular' => true,
            ],
            [
                'code' => 'custom',
                'name' => 'Custom',
                'price' => 'Diskusi',
                'desc' => 'E-commerce, web app, atau kebutuhan khusus.',
                'features' => [
                    'Desain & arsitektur custom',
                    'Fitur sesuai kebutuhan (e-commerce, booking, dashboard, dll)',
                    'Database design & API development',
                    'User authentication & role management',
                    'Payment gateway integration',
                    'Admin panel untuk kelola data',
                    'Automated testing (unit/feature)',
                    'CI/CD pipeline setup',
                    'Performance optimization',
                    'Security audit & hardening',
                    'Unlimited revisi saat development',
                    'Domain & hosting 1 tahun',
                    'Support 90 hari + maintenance opsional',
                ],
            ],
        ];

        return view('public.pricing', compact('packages'));
    }
}
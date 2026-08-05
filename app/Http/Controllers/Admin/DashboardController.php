<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_leads' => Lead::count(),
            'new_leads_today' => Lead::whereDate('created_at', today())->count(),
            'deals' => Lead::where('status', 'deal')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'active_portfolios' => Portfolio::where('is_active', true)->count(),
            'total_portfolios' => Portfolio::count(),
            'active_services' => Service::where('is_active', true)->count(),
            'active_testimonials' => Testimonial::where('is_active', true)->count(),
        ];

        $recentLeads = Lead::with('service')->latest()->limit(8)->get();
        $pendingPosts = Post::where('status', 'draft')->latest()->limit(5)->get();
        $leadsByStatus = Lead::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // 12 bulan terakhir (termasuk bulan berjalan)
        $leadsByMonth = Lead::where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->selectRaw("to_char(created_at, 'YYYY-MM') as month, count(*) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $leadsByService = Lead::selectRaw('COALESCE(services.title, \'Tanpa layanan\') as service_name, count(*) as total')
            ->leftJoin('services', 'services.id', '=', 'leads.service_id')
            ->groupBy('service_name')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        $conversionRate = $stats['total_leads'] > 0
            ? round($stats['deals'] / $stats['total_leads'] * 100, 1)
            : 0;

        return view('admin.dashboard', compact(
            'stats',
            'recentLeads',
            'pendingPosts',
            'leadsByStatus',
            'leadsByMonth',
            'months',
            'leadsByService',
            'conversionRate'
        ));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Portfolio;
use App\Models\Service;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        $add = function (string $loc, ?string $lastmod = null) use (&$urls) {
            $urls[] = ['loc' => $loc, 'lastmod' => $lastmod];
        };

        // Halaman statis
        $add(url('/'));
        $add(route('services.index'));
        $add(route('portfolio.index'));
        $add(route('blog.index'));
        $add(route('contact'));
        $add(route('order'));
        $add(route('pricing'));
        $add(route('faq'));

        // Konten dinamis (hanya yang aktif/terbit)
        foreach (Service::where('is_active', true)->get() as $item) {
            $add(route('services.show', $item->slug), $item->updated_at?->toAtomString());
        }

        foreach (Portfolio::where('is_active', true)->get() as $item) {
            $add(route('portfolio.show', $item->slug), $item->updated_at?->toAtomString());
        }

        foreach (Post::published()->get() as $item) {
            $add(route('blog.show', $item->slug), $item->updated_at?->toAtomString());
        }

        foreach (Page::where('is_active', true)->get() as $item) {
            $add(route('pages.show', $item->slug), $item->updated_at?->toAtomString());
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . e($url['loc']) . '</loc>' . "\n";
            if ($url['lastmod']) {
                $xml .= '    <lastmod>' . e($url['lastmod']) . '</lastmod>' . "\n";
            }
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>' . "\n";

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}

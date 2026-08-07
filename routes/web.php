<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LeadExportController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Website
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');

Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PostController::class, 'show'])->name('blog.show');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    return response("User-agent: *\nDisallow:\n\nSitemap: " . url('/sitemap.xml') . "\n")
        ->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::get('/faq', [FaqController::class, 'index'])->name('faq');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->middleware('throttle:5,1')->name('newsletter.subscribe');
Route::get('/newsletter/confirm/{token}', [NewsletterController::class, 'confirm'])->name('newsletter.confirm');

Route::get('/order', [OrderController::class, 'show'])->name('order');
Route::post('/order', [OrderController::class, 'store'])->middleware('throttle:5,1')->name('order.store');
Route::get('/order/success', [OrderController::class, 'success'])->name('order.success');

Route::get('/pricing', [OrderController::class, 'pricing'])->name('pricing');

Route::get('/styleguide', function () {
    return view('public.styleguide');
})->name('styleguide');

Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['id', 'en'], true)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');

/*
|--------------------------------------------------------------------------
| Halaman statis dinamis (about, pricing, privacy, terms, dll)
| Harus terdaftar PALING AKHIR agar tidak menangkap /panel, /services, dst.
|--------------------------------------------------------------------------
*/
// Export CSV prospek — di luar route Filament (terdaftar setelahnya) tapi tetap
// harus sebelum catch-all /{slug} dan hanya boleh diakses pengguna panel yang login.
Route::get('/panel/leads/export', LeadExportController::class)
    ->middleware(['web', \Filament\Http\Middleware\Authenticate::class])
    ->name('panel.leads.export');

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!panel$).*') // panel dipakai Filament — jangan disambar halaman statis
    ->name('pages.show');
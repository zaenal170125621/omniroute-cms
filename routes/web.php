<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
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

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
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
| CMS / Admin Panel
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'role:admin,editor,sales'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::middleware('role:admin,editor')->group(function () {
            Route::resource('services', AdminServiceController::class);
            Route::resource('portfolios', AdminPortfolioController::class);
            Route::resource('testimonials', TestimonialController::class);
            Route::resource('posts', AdminPostController::class);
            Route::resource('pages', AdminPageController::class);
        });

        Route::middleware('role:admin,sales')->group(function () {
            Route::get('leads/export', [LeadController::class, 'export'])->name('leads.export');
            Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
            Route::get('leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
            Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus'])->name('leads.status');
            Route::delete('leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
        });

        Route::middleware('role:admin')->group(function () {
            Route::resource('users', UserController::class);
            Route::get('settings', [SettingController::class, 'index'])->name('settings');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
            Route::post('theme-preference', function () {
                request()->validate(['theme' => 'required|in:light,dark']);
                auth()->user()->update(['theme_preference' => request('theme')]);
                return response()->json(['success' => true]);
            })->name('theme-preference');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Halaman statis dinamis (about, pricing, privacy, terms, dll)
| Harus terdaftar PALING AKHIR agar tidak menangkap /admin, /services, dst.
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [PageController::class, 'show'])->name('pages.show');
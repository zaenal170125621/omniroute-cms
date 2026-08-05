<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — CMS OmniRoute</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-theme-preference" content="{{ auth()->check() ? (auth()->user()->theme_preference ?? '') : '' }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="app">

    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="logo">OmniRoute<sup>®</sup> CMS</a>
            <button class="sidebar-close" aria-label="Tutup menu">×</button>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section">Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="nav-icon">▦</span> Dashboard
            </a>
            <a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}">
                <span class="nav-icon">✉</span> Leads / Pesanan
                @php $newLeads = \App\Models\Lead::where('status', 'baru')->count(); @endphp
                @if ($newLeads > 0 && (auth()->user()->isAdmin() || auth()->user()->isSales()))
                    <span class="badge-dot">{{ $newLeads > 9 ? '9+' : $newLeads }}</span>
                @endif
            </a>

            @if (auth()->user()->isAdmin() || auth()->user()->isEditor())
                <div class="sidebar-section">Konten</div>
                <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <span class="nav-icon">◈</span> Layanan
                </a>
                <a href="{{ route('admin.portfolios.index') }}" class="{{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                    <span class="nav-icon">▣</span> Portofolio
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <span class="nav-icon">❝</span> Testimoni
                </a>
                <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <span class="nav-icon">☰</span> Blog
                </a>
                <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <span class="nav-icon">▤</span> Halaman
                </a>
            @endif

            @if (auth()->user()->isAdmin())
                <div class="sidebar-section">Sistem</div>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span class="nav-icon">♟</span> Pengguna
                </a>
                <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                    <span class="nav-icon">⚙</span> Pengaturan
                </a>
            @endif
        </nav>

        <div class="sidebar-user">
            <div class="u-name">
                <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                {{ auth()->user()->name }}
            </div>
            <div class="u-role">{{ auth()->user()->role }}</div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="link-logout">Keluar →</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="menu-open" aria-label="Buka menu">☰</button>
                <span class="topbar-title">@yield('title', 'Dashboard')</span>
            </div>
            <div class="topbar-right">
                <button id="theme-toggle" class="topbar-btn theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode (Ctrl+Shift+D)">
                    <span class="theme-icon-light">☀</span>
                    <span class="theme-icon-dark">☾</span>
                </button>
                <a href="{{ route('home') }}" target="_blank" class="topbar-btn">Lihat Website ↗</a>
            </div>
        </header>

        <main class="content">
            <div class="content-inner">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

{{-- JavaScript Translations --}}
<script>
    window.translations = @json(__('*'));
    window.t = function(key) {
        return (window.translations && window.translations[key]) ? window.translations[key] : key;
    };
</script>

<script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>

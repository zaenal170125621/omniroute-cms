<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    /**
     * Ambil nilai pengaturan global dari tabel settings.
     */
    function setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('wa_number')) {
    /**
     * Nomor WhatsApp dari pengaturan, dibersihkan jadi angka polos (format 62...).
     */
    function wa_number(): string
    {
        return preg_replace('/[^0-9]/', '', (string) setting('whatsapp', ''));
    }
}

if (!function_exists('wa_link')) {
    /**
     * Link chat WhatsApp (wa.me) dengan pesan awal opsional.
     * Mengembalikan null jika nomor belum diatur di pengaturan.
     */
    function wa_link(?string $message = null): ?string
    {
        $number = wa_number();

        if (!$number) {
            return null;
        }

        return 'https://wa.me/' . $number . ($message ? '?text=' . rawurlencode($message) : '');
    }
}

if (!function_exists('swiss_block')) {
    /**
     * Placeholder visual ala Swiss: blok warna solid dengan angka besar.
     * Dipakai saat item tidak memiliki gambar cover.
     */
    function swiss_block(string $color, string $label, string $index = ''): string
    {
        $hex = ltrim($color, '#');
        $label = e($label);
        $index = e($index);

        return <<<HTML
        <div class="swiss-block" style="background:{$color}">
            <span class="swiss-block-index">{$index}</span>
            <span class="swiss-block-label">{$label}</span>
        </div>
        HTML;
    }
}

if (!function_exists('service_icon_url')) {
    /**
     * URL ikon layanan (SVG publik). Mengembalikan null jika file tidak ada.
     */
    function service_icon_url(?string $icon): ?string
    {
        if (!$icon) {
            return null;
        }

        $file = 'images/services/' . $icon . '.svg';

        return file_exists(public_path($file)) ? asset($file) : null;
    }
}

if (!function_exists('cover_url')) {
    /**
     * Resolusi path gambar cover.
     * - 'images/...'       → aset publik (public/images)
     * - 'storage/...'      → aset upload (storage symlink)
     * - http(s)://...      → URL eksternal apa adanya
     */
    function cover_url(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, '/images/')) {
            return asset(ltrim($path, '/'));
        }

        return asset('storage/' . $path);
    }
}

if (!function_exists('markdown')) {
    /**
     * Parser markdown ringan untuk konten CMS.
     * Mendukung: heading, bold, italic, list, blockquote, link, gambar, dan HTML passthrough
     * untuk blok yang diawali karakter '<' (konten diisi oleh admin yang terpercaya).
     */
    function markdown(?string $text): string
    {
        if ($text === null || trim($text) === '') {
            return '';
        }

        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $lines = explode("\n", $text);

        $html = '';
        $listStack = [];

        $closeLists = function () use (&$html, &$listStack) {
            while ($listStack) {
                $html .= '</' . array_pop($listStack) . '>' . "\n";
            }
        };

        $inline = function (string $line): string {
            // [teks](url)
            $line = preg_replace_callback('/\[([^\]]+)\]\(([^)\s]+)\)/', function ($m) {
                return '<a href="' . e($m[2]) . '">' . e($m[1]) . '</a>';
            }, $line);
            // **tebal**
            $line = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $line);
            // *miring*
            $line = preg_replace('/(^|[^*])\*([^*]+)\*/', '$1<em>$2</em>', $line);
            // `kode`
            $line = preg_replace('/`([^`]+)`/', '<code>$1</code>', $line);

            return $line;
        };

        foreach ($lines as $line) {
            $trimmed = trim($line);

            // HTML blok mentah (konten admin tepercaya) — dibiarkan apa adanya
            if (str_starts_with($trimmed, '<')) {
                $closeLists();
                $html .= $trimmed . "\n";
                continue;
            }

            // Heading
            if (preg_match('/^(#{1,6})\s+(.*)$/', $trimmed, $m)) {
                $closeLists();
                $level = strlen($m[1]);
                $html .= '<h' . $level . '>' . $inline($m[2]) . '</h' . $level . '>' . "\n";
                continue;
            }

            // Blockquote
            if (preg_match('/^>\s?(.*)$/', $trimmed, $m)) {
                $closeLists();
                $html .= '<blockquote>' . $inline($m[1]) . '</blockquote>' . "\n";
                continue;
            }

            // Horizontal rule
            if (preg_match('/^(?:-{3,}|\*{3,})$/', $trimmed)) {
                $closeLists();
                $html .= '<hr>' . "\n";
                continue;
            }

            // Gambar markdown ![alt](src)
            if (preg_match('/^!\[([^\]]*)\]\(([^)\s]+)\)$/', $trimmed, $m)) {
                $closeLists();
                $html .= '<img src="' . e($m[2]) . '" alt="' . e($m[1]) . '" loading="lazy">' . "\n";
                continue;
            }

            // List tak berurut
            if (preg_match('/^[-*•]\s+(.*)$/', $trimmed, $m)) {
                if (end($listStack) !== 'ul') {
                    $closeLists();
                    $listStack[] = 'ul';
                    $html .= '<ul>' . "\n";
                }
                $html .= '<li>' . $inline($m[1]) . '</li>' . "\n";
                continue;
            }

            // List berurut
            if (preg_match('/^\d+[.)]\s+(.*)$/', $trimmed, $m)) {
                if (end($listStack) !== 'ol') {
                    $closeLists();
                    $listStack[] = 'ol';
                    $html .= '<ol>' . "\n";
                }
                $html .= '<li>' . $inline($m[1]) . '</li>' . "\n";
                continue;
            }

            // Baris kosong = jeda paragraf
            if ($trimmed === '') {
                $closeLists();
                continue;
            }

            // Paragraf biasa
            $closeLists();
            $html .= '<p>' . $inline($line) . '</p>' . "\n";
        }

        $closeLists();

        return $html;
    }
}

if (!function_exists('notify_lead_sales')) {
    /**
     * Kirim notifikasi email ke tim sales saat lead baru masuk.
     * Alamat tujuan diambil dari pengaturan 'lead_notify_email'.
     * Jika gagal terkirim (mis. SMTP belum dikonfigurasi), alur tidak terhenti
     * — kegagalan hanya dicatat di log aplikasi.
     */
    function notify_lead_sales(\App\Models\Lead $lead): void
    {
        $to = setting('lead_notify_email');

        if (!$to || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Mail::to($to)
                ->send(new \App\Mail\NewLeadNotification($lead));

            \Illuminate\Support\Facades\Log::info('Notifikasi lead #' . $lead->id . ' terkirim ke ' . $to);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning(
                'Notifikasi lead #' . $lead->id . ' gagal terkirim (cek konfigurasi MAIL_* di .env): ' . $e->getMessage()
                . ' — ' . $lead->name . ' <' . $lead->email . '> via ' . $lead->source
            );
        }
    }
}

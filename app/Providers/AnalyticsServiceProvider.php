<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AnalyticsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // @ga4Event('event_name', ['param' => 'value'])
        Blade::directive('ga4Event', function ($expression) {
            return "<?php echo \\App\\Services\\Analytics::onclick($expression); ?>";
        });

        // @ga4Data('event_name', ['param' => 'value']) - outputs data-attributes
        Blade::directive('ga4Data', function ($expression) {
            $attrs = \App\Services\Analytics::dataAttributes($expression);
            return "<?php echo ' ' . implode(' ', array_map(fn(\$k, \$v) => \"\$k=\\\"\\$v\\\"\", \$attrs)); ?>";
        });
    }
}
<?php

namespace App\Services;

class Analytics
{
    /**
     * Standard event names for consistency
     */
    public const EVENT_CTA_CLICK = 'cta_click';
    public const EVENT_FORM_STEP = 'form_step';
    public const EVENT_FORM_SUBMIT = 'form_submit';
    public const EVENT_FORM_ERROR = 'form_error';
    public const EVENT_WHATSAPP_CLICK = 'whatsapp_click';
    public const EVENT_PORTFOLIO_VIEW = 'portfolio_view';
    public const EVENT_SERVICE_VIEW = 'service_view';
    public const EVENT_PACKAGE_SELECT = 'package_select';
    public const EVENT_COMPARISON_TOGGLE = 'comparison_toggle';
    public const EVENT_FAQ_OPEN = 'faq_open';
    public const EVENT_NEWSLETTER_SUBSCRIBE = 'newsletter_subscribe';
    public const EVENT_LANG_SWITCH = 'lang_switch';
    public const EVENT_SEARCH = 'search';

    /**
     * Generate onclick attribute for GA4 event
     */
    public static function onclick(string $event, array $params = []): string
    {
        $paramsJson = json_encode($params, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        return "window.gtag && gtag('event', '{$event}', {$paramsJson})";
    }

    /**
     * Generate data attributes for event tracking
     */
    public static function dataAttributes(string $event, array $params = []): array
    {
        return [
            'data-ga-event' => $event,
            'data-ga-params' => json_encode($params, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
        ];
    }

    /**
     * CTA Click event
     */
    public static function ctaClick(string $ctaName, string $location, array $extra = []): array
    {
        return self::dataAttributes(self::EVENT_CTA_CLICK, array_merge([
            'cta_name' => $ctaName,
            'location' => $location,
        ], $extra));
    }

    /**
     * Form step event
     */
    public static function formStep(int $step, string $form, array $extra = []): array
    {
        return self::dataAttributes(self::EVENT_FORM_STEP, array_merge([
            'step' => $step,
            'form_name' => $form,
        ], $extra));
    }

    /**
     * Form submit event
     */
    public static function formSubmit(string $form, array $data = []): array
    {
        return self::dataAttributes(self::EVENT_FORM_SUBMIT, array_merge([
            'form_name' => $form,
        ], $data));
    }

    /**
     * WhatsApp click event
     */
    public static function whatsappClick(string $source, array $extra = []): array
    {
        return self::dataAttributes(self::EVENT_WHATSAPP_CLICK, array_merge([
            'source' => $source, // float_button, header_cta, footer, sticky_cta, pricing_card
        ], $extra));
    }

    /**
     * Portfolio view event
     */
    public static function portfolioView(string $slug, string $category): array
    {
        return self::dataAttributes(self::EVENT_PORTFOLIO_VIEW, [
            'project_slug' => $slug,
            'category' => $category,
        ]);
    }

    /**
     * Service view event
     */
    public static function serviceView(string $slug): array
    {
        return self::dataAttributes(self::EVENT_SERVICE_VIEW, [
            'service_slug' => $slug,
        ]);
    }

    /**
     * Package select event
     */
    public static function packageSelect(string $packageCode, string $packageName, string $location): array
    {
        return self::dataAttributes(self::EVENT_PACKAGE_SELECT, [
            'package_code' => $packageCode,
            'package_name' => $packageName,
            'location' => $location, // pricing, order, home_cta
        ]);
    }

    /**
     * Comparison table toggle event
     */
    public static function comparisonToggle(bool $opened): array
    {
        return self::dataAttributes(self::EVENT_COMPARISON_TOGGLE, [
            'opened' => $opened,
        ]);
    }

    /**
     * FAQ open event
     */
    public static function faqOpen(string $question): array
    {
        return self::dataAttributes(self::EVENT_FAQ_OPEN, [
            'question' => $question,
        ]);
    }

    /**
     * Newsletter subscribe event
     */
    public static function newsletterSubscribe(string $source): array
    {
        return self::dataAttributes(self::EVENT_NEWSLETTER_SUBSCRIBE, [
            'source' => $source, // footer, blog_inline, order_success
        ]);
    }

    /**
     * Language switch event
     */
    public static function langSwitch(string $fromLocale, string $toLocale): array
    {
        return self::dataAttributes(self::EVENT_LANG_SWITCH, [
            'from_locale' => $fromLocale,
            'to_locale' => $toLocale,
        ]);
    }

    /**
     * Search event
     */
    public static function search(string $query, string $type, int $resultsCount): array
    {
        return self::dataAttributes(self::EVENT_SEARCH, [
            'search_term' => $query,
            'search_type' => $type, // blog, portfolio, services
            'results_count' => $resultsCount,
        ]);
    }

    /**
     * Render script tag for manual event firing
     */
    public static function script(string $event, array $params = []): string
    {
        $paramsJson = json_encode($params, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        return "<script>window.gtag && gtag('event', '{$event}', {$paramsJson});</script>";
    }
}
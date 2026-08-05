{{-- 
  GA4 Event Tracking Component
  Usage:
  <x-ga4-event 
    event="cta_click" 
    :params="['cta_name' => 'hero_primary', 'location' => 'home']" 
  />
  
  Or inline with onclick:
  <a href="{{ route('order') }}" 
     onclick="{{ ga4_event('cta_click', ['cta_name' => 'pricing_business', 'location' => 'pricing']) }}">
     Mulai Proyek
  </a>
--}}

@php
  $event = $event ?? 'custom_event';
  $params = $params ?? [];
  $paramsJson = json_encode($params, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  $js = "window.gtag && gtag('event', '{$event}', {$paramsJson})";
@endphp

@if ($attributes->get('onclick'))
  {{-- Merge with existing onclick --}}
  <span {{ $attributes->merge(['onclick' => $attributes->get('onclick') . '; ' . $js]) }}></span>
@else
  <span {{ $attributes->merge(['onclick' => $js]) }}></span>
@endif
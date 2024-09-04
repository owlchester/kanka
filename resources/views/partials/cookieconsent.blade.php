@inject('countryService', 'App\Services\CountryService')
@php
$cookieconsent = [
    'header' => __('cookieconsent.header'),
    'message' => __('cookieconsent.message'),
    'dismiss' => __('cookieconsent.dismiss'),
    'allow' => __('cookieconsent.allow'),
    'deny' => __('cookieconsent.reject'),
    'link' => __('cookieconsent.link'),
    'href' => 'https://kanka.io/privacy-policy',
    'close' => '&#x274c;',
    'policy' => __('cookieconsent.policy'),
    'target' => '_blank',
];
@endphp
<div
    id="cookieconsent"
    class="hidden"
    data-api="{{ route('cookieconsent.country') }}"
    data-country="{{ $countryService->getCountry() }}"
    data-setup='{{ json_encode($cookieconsent) }}'
@if (!empty(config('tracking.ga'))) data-gtag="{{ config('tracking.ga') }}" @endif
@if (!empty(config('tracking.gtm'))) data-gtm="{{ config('tracking.gtm') }}" @endif
></div>

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
$cookietracking = [];
if (!empty(config('tracking.ga'))) {
    $cookietracking['gtag'] = config('tracking.ga');
}
if (!empty(config('tracking.gtm'))) {
    $cookietracking['gtm'] = config('tracking.gtm');
}
@endphp
<div id="cookieconsent"
     class="hidden"
     data-api="{{ route('cookieconsent.country') }}"
     data-country="{{ $countryService->getCountry() }}"
     data-setup='{{ json_encode($cookieconsent) }}'
     data-tracking='{{ json_encode($cookietracking) }}'></div>

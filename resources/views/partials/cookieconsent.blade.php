@inject('countryService', 'App\Services\CountryService')
<div
    id="cookieconsent"
    class="hidden"
    data-country="{{ $countryService->getCountry() }}"
@if (!empty(config('tracking.ga'))) data-gtag="{{ config('tracking.ga') }}" @endif
@if (!empty(config('tracking.gtm'))) data-gtm="{{ config('tracking.gtm') }}" @endif
></div>

@vite(['resources/js/cookieconsent.js'])

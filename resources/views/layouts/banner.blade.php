{{--@if (\Carbon\Carbon::create(2023, 11, 28)->isFuture())--}}
{{--    <x-tutorial code="ft" type="warning" :auth="false">--}}
{{--        <p>--}}
{{--            Kanka will be undergoing scheduled maintenance on Tuesday 21st of May 2024. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/bff36b39" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:30 UTC</a> to 16:00 UTC. Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}

{{--@if (\Carbon\Carbon::create(2023, 11, 28)->isFuture())--}}
{{--    <x-tutorial code="banner_bf2024" type="warning">--}}
{{--        <p>--}}
{{--            <a href="{{ route('settings.subscription') }}" class="block">--}}
{{--                {!! __('banners.blackfriday24', ['code' => '<code>BF2024</code>']) !!}--}}
{{--            </a>--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}

@inject('countryService', 'App\Services\CountryService')
@if (auth()->check() && $countryService->getCountry() === 'BR')
    <x-tutorial code="brl" type="info">
        <p>
            As assinaturas do Kanka agora estão disponíveis em reais e mais baratas do que em dólares!
        </p>
        <p>
            <a href="{{ route('settings.subscription') }}" class="block">
                {{ __('front/newsletter.actions.learn_more') }}
            </a>
        </p>
    </x-tutorial>
@endif

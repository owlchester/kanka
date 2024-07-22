@if ((auth()->guest() || (auth()->check() && !auth()->user()->settings()->get('banner_bf2023'))) && \Carbon\Carbon::create(2023, 11, 28)->isFuture())
    <x-tutorial code="ft" type="warning">
        <p>
            Kanka will be undergoing scheduled maintenance on Tuesday 21st of May 2024. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/bff36b39" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:30 UTC</a> to 16:00 UTC. Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.
        </p>
    </x-tutorial>
@endif

@if ((auth()->guest() || (auth()->check() && !auth()->user()->settings()->get('banner_bf2023'))) && \Carbon\Carbon::create(2023, 11, 28)->isFuture())
    <x-tutorial code="banner_bf2023" type="warning">
        <p>
            <a href="{{ route('settings.subscription') }}" class="block">
                {!! __('banners.blackfriday23', ['code' => '<code>BF2023</code>']) !!}
            </a>        
        </p>
    </x-tutorial>
@endif

@if (auth()->check() && in_array(app()->currentLocale(), ['nl']) && !auth()->user()->settings()->get('banner_translators_2024'))
    <x-tutorial code="banner_translators_2024" type="info">
        <p>
            Kanka is community translated into <strong>{{ app()->currentLocale() === 'nl' ? 'Dutch' : 'Italian' }}</strong>, and is in need of new translators before April 2024. If you want to help keep Kanka available in Dutch, message us on <a href="{{ config('social.discord') }}" target="_blank">Discord</a>!   
        </p>
    </x-tutorial>
@endif

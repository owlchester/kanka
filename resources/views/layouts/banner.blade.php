{{--@if (\Carbon\Carbon::create()->between(\Carbon\Carbon::create('2024-11-27'), \Carbon\Carbon::create('2024-12-02')))--}}
{{--    <x-tutorial code="ft" type="warning" :auth="false">--}}
{{--        <p>--}}
{{--            Kanka will be undergoing scheduled maintenance on Tuesday 21st of May 2024. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/bff36b39" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:30 UTC</a> to 16:00 UTC. Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.--}}
{{--        </p>--}}
{{--    </x-tutorial>--}}
{{--@endif--}}

@if (auth()->check() && auth()->user()->subscriptions()->count() === 0 && \Carbon\Carbon::now()->between(\Carbon\Carbon::create('2024-11-29'), \Carbon\Carbon::create('2024-12-02')))
    <x-tutorial code="bf2024" type="warning">
        <p>
            <a href="{{ route('settings.subscription') }}" class="block text-warning-content">
                {!! __('banners.blackfriday24', ['code' => '<code>BF2024</code>']) !!}
            </a>
        </p>
    </x-tutorial>
@endif

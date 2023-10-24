@if (false && auth()->check() && !auth()->user()->settings()->get('banner_5yearpromo') && \Carbon\Carbon::create(2022, 10, 31)->isFuture())
    <div class="bg-primary banner-notification p-2">
        <span>
            <a href="{{ route('settings.subscription') }}">
                {!! __('banners.kanka4years', ['code' => '<code>KANKA5YEAR</code>']) !!}
            </a>
        </p>
    </div>
@endif

@if (false)
<div class="bg-orange banner-notification p-2">
    <span>
        @if (auth()->check())
        <button type="button" class="close banner-notification-dismiss" data-dismiss="banner-notification" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'das_migration']) }}">×</button>
        @endif

        Kanka will be undergoing scheduled maintenance on Wednesday 19th of October 2022. This will result in Kanka being unavailable from <a href="https://everytimezone.com/s/fce7c091" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:00 UTC</a> to 16:00 UTC. <br />Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.
    </span>
</div>
@endif

@if (auth()->check() && in_array(app()->currentLocale(), ['nl']) && !auth()->user()->settings()->get('banner_translators_2023'))
<div class="alert alert-info p-2 flex gap-2" id="banner-notification">
    <div class="grow">
        Kanka is community translated into <strong>{{ app()->currentLocale() === 'nl' ? 'Dutch' : 'Italian' }}</strong>, and is in need of new translators to help keep it up to date. If you want to help keep Kanka available in your language, message us on <a href="{{ config('social.discord') }}" target="_blank">Discord</a>!
    </div>
    <button type="button" class="close p-2 banner-notification-dismiss" data-dismiss="#banner-notification" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'translators_2023']) }}">×</button>
</div>
@endif

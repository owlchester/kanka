@if (false && auth()->check() && !auth()->user()->settings()->get('banner_5yearpromo') && \Carbon\Carbon::create(2022, 10, 31)->isFuture())
    <div class="bg-primary banner-notification p-2">
        <span>
            <a href="{{ route('settings.subscription') }}">
                {!! __('banners.kanka4years', ['code' => '<code>KANKA5YEAR</code>']) !!}
            </a>

            <button type="button" class="float-right text-xl" data-dismiss="alert" aria-hidden="true" id="banner-notification-dismiss" data-url="{{ route('settings.banner', ['code' => '5yearpromo']) }}">×</button>
        </span>
    </div>
@endif

@if (auth()->check() && !auth()->user()->settings()->get('kanka_v20'))
<div class="alert alert-warning p-2 flex gap-2 banner-notification " id="banner-notification">
    <div class="grow">
        Kanka will be undergoing scheduled maintenance on Wednesday 1st of November 2023. As a result, Kanka will be unavailable from <a href="https://everytimezone.com/s/5e116456" target="_blank" style="text-decoration: underline"><i class="fa-solid fa-external-link"></i> 14:30 UTC</a> to 18:30 UTC. Join us on <a href="{{ config('social.discord') }}" target="_blank"  style="text-decoration: underline">Discord</a> to get updates.
    </div>
    @if (auth()->check())
        <button type="button" class="close p-2 banner-notification-dismiss" data-dismiss="banner-notification" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'kanka_v20']) }}">×</button>
    @endif
</div>
@endif

@if (auth()->check() && in_array(app()->currentLocale(), ['it', 'nl']) && !auth()->user()->settings()->get('banner_translators_2023'))
<div class="bg-blue banner-notification p-2">
    <span>
        <button type="button" class="close banner-notification-dismiss" data-dismiss="banner-notification" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'translators_2023']) }}">×</button>

        Kanka is community translated into <strong>{{ app()->currentLocale() === 'nl' ? 'Dutch' : 'Italian' }}</strong>, and is in need of new translators to help keep it up to date. If you want to help keep Kanka available in your language, message us on <a href="{{ config('social.discord') }}" target="_blank">Discord</a>!
    </span>
</div>
@endif

@if (false && auth()->check() && !auth()->user()->settings()->get('banner_4yearpromo') && \Carbon\Carbon::create(2021, 11, 1)->isFuture())
    <div class="bg-primary banner-notification">
        <span>
            <a href="{{ route('settings.subscription') }}">
                {!! __('banners.kanka4years', ['code' => '<code>KANKA4YEAR</code>']) !!}
            </a>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" id="banner-notification-dismiss" data-url="{{ route('settings.banner', ['code' => '4yearpromo']) }}">×</button>
        </span>
    </div>
@endif

@if (true)
<div class="bg-orange banner-notification">
    <span>
        Kanka will be unvailable from <a href="https://everytimezone.com/?t=62785980,31b" target="_blank" class="text-light-blue">13:15 UTC</a> to about 14:00 UTC. Please save what you are working on before then.<br />Join us on <a href="{{ config('social.discord') }}" target="_blank" class="text-light-blue">Discord</a> for more info.
    </span>
</div>
@endif

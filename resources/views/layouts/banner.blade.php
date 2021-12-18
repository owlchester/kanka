@if (auth()->check() && !auth()->user()->settings->get('banner_4yearpromo') && \Carbon\Carbon::create(2021, 11, 1)->isFuture())
    <div class="bg-primary banner-notification">
        <span>
            <a href="{{ route('settings.subscription') }}">
                {!! __('banners.kanka4years', ['code' => '<code>KANKA4YEAR</code>']) !!}
            </a>

            <button type="button" class="close" data-dismiss="alert" aria-hidden="true" id="banner-notification-dismiss" data-url="{{ route('settings.banner', ['code' => '4yearpromo']) }}">×</button>
        </span>
    </div>
@endif

<div class="bg-danger banner-notification">
    <span>
        Kanka will be unavailable on Monday 20th of December at <strong><a href="https://everytimezone.com/s/9c5cae60" target="_blank">4PM UTC</a></strong> for about 60 minutes while we do some maintenance work.
    </span>
</div>

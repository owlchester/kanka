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
<div class="bg-danger banner-notification">
    <span>
        Kanka will be undergoing server maintenance on Tuesday the 19th of April at <strong><a href="https://everytimezone.com/s/5d4c9c76" target="_blank">2:00PM UTC</a></strong> for about two hours. Access to your campaigns and data will be limited during the maintenance.
    </span>
</div>
@endif

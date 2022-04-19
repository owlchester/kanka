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
    <p>

        Kanka is currently undergoing server maintenance, which we expect to last until <strong><a href="https://everytimezone.com/s/b41937bc" target="_blank">4:00PM UTC</a></strong>. Some pages might load slowly or not at all.<br />Join us on <a href="{{ config('social.discord') }}" target="_blank">Discord</a> to get updates.
    </p>
</div>
@endif

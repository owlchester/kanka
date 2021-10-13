@if (auth()->check() && auth()->user()->subscribed('kanka') && !auth()->user()->settings->get('banner_4yearpromo'))
    <div class="bg-orange banner-notification">
                <span>
                    Use promo code <code>KANKA4YEARS</code> to get 20% off your first yearly <a href="{{ route('settings.subscription') }}">subscription</a>!

                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" id="banner-notification-dismiss" data-url="{{ route('settings.banner', ['code' => '4yearpromo']) }}">×</button>
                </span>
    </div>
@endif

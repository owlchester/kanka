<div class="row pricing mt-3">
    <div class="col-lg-3 col-md-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-kobold @nowebp webpfallback @endnowebp"></div>
                <div class="card-title text-muted text-uppercase text-center">Kobold</div>
                <div class="card-price text-center">{{ __('front.pricing.tier.free') }}</div>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-times"></i></span>
                        <a href="{{ route('front.pricing', ['#boost']) }}" target="_blank">
                            <strong>{{ __('front.pricing.benefits.no_boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.unlimited') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.core') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.updates') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.pricing.benefits.higher_uploads') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.pricing.benefits.boosters') }}--}}
{{--                    </li>--}}
                </ul>
                @if(config('auth.register_enabled'))
                <a href="{{ route('register') }}" class="btn btn-block btn-primary text-uppercase">
                    {{ __('front.second_block.call_to_action') }}
                </a>@endif
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-owlbear @nowebp webpfallback @endnowebp"></div>
                <div class="card-title text-muted text-uppercase text-center">Owlbear</div>
                <div class="card-price text-center">$5<span class="period">/{{ __('front.pricing.tier.month') }}</span></div>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span>
                        <a href="{{ route('front.pricing', ['#boost']) }}" target="_blank">
                            <strong>3 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.big_maps', ['size' => '10 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.discord') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" target="_blank" class="btn btn-block btn-primary text-uppercase">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-wyvern @nowebp webpfallback @endnowebp"></div>
                <div class="card-title text-muted text-uppercase text-center">Wyvern</div>
                <div class="card-price text-center">$10<span class="period">/{{ __('front.pricing.tier.month') }}</span></div>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span>
                        <a href="{{ route('front.pricing', ['#boost']) }}" target="_blank">
                            <strong>6 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.bigger_maps', ['size' => '20 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.discord') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fas fa-times"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" target="_blank" class="btn btn-block btn-primary text-uppercase">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
    <div class="offset-md-4 offset-lg-0 col-lg-3 col-md-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-elemental @nowebp webpfallback @endnowebp"></div>
                <div class="card-title text-muted text-uppercase text-center">Elementals</div>
                <div class="card-price text-center">$25<span class="period">/{{ __('front.pricing.tier.month') }}</span></div>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span>
                        <a href="{{ route('front.pricing', ['#boost']) }}" target="_blank">
                            <strong>10 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.huge_maps', ['size' => '50 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.discord') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.curation') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.impact') }}
                    </li>
                </ul>

                <a href="{{ route('settings.subscription') }}" target="_blank" class="btn btn-block btn-primary text-uppercase">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
</div>

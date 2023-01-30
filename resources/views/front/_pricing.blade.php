<div class="text-center pricing-toggle" aria-hidden="true">
    <label data-pricing="monthly" class="text-bold cursor">
        Monthly
    </label>
    <span data-pricing="toggle" class="pricing-monthly"></span>
    <label data-pricing="yearly">
        Yearly (save 10%)
    </label>
</div>

<div class="row pricing mt-5 pt-5 pricing-monthly">
    <div class="col-lg-3 col-md-4 ">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body d-flex flex-column">
                <div class="card-image subscription-kobold"></div>
                <div class="text-center align-self-stretch">
                    <div class="card-title text-muted text-uppercase mb-0">Kobold</div>
                    <div class="card-price">{{ __('front.pricing.tier.free') }}</div>
                    <hr>
                </div>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-danger"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>{{ __('front.pricing.benefits.no_boosters') }}</strong>
                        </a>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.unlimited') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.core') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.updates') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.pricing.benefits.higher_uploads') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.pricing.benefits.boosters') }}--}}
{{--                    </li>--}}
                </ul>
                @if(config('auth.register_enabled'))
                <a href="{{ route('register') }}" class="mt-auto btn btn-block btn-primary text-uppercase btn-kobold">
                    {{ __('front.second_block.call_to_action') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body d-flex flex-column">
                <div class="card-image subscription-owlbear"></div>
                <div class="text-center align-self-stretch">
                    <div class="card-title text-muted text-uppercase mb-0">Owlbear</div>
                    <div class="card-price price-monthly">$5<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="card-price price-yearly" aria-hidden="true">$4.58<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="price-yearly small mb-2" aria-hidden="true">{!! __('front.pricing.billed_yearly', ['amount' => '<strong>$55</strong>']) !!}</div>
                    <div class="card-ribbon card-most-popular text-center">{{ __('tiers.ribbons.popular') }}</div>
                    <hr class="hr-ribbon" />
                </div>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>3 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.big_maps', ['size' => '10 MB']) }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" class="mt-auto btn btn-block btn-primary text-uppercase btn-owlbear">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body d-flex flex-column">
                <div class="card-image subscription-wyvern"></div>
                <div class="text-center align-self-stretch">
                    <div class="card-title text-muted text-uppercase mb-0">Wyvern</div>
                    <div class="card-price price-monthly">$10<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="card-price price-yearly" aria-hidden="true">$9.16<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="price-yearly small mb-2" aria-hidden="true">{!! __('front.pricing.billed_yearly', ['amount' => '<strong>$110</strong>']) !!}</div>
                    <div class="card-ribbon card-best-value">{{ __('tiers.ribbons.best-value') }}</div>
                    <hr class="hr-ribbon" />
                </div>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>6 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.bigger_maps', ['size' => '20 MB']) }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" class="mt-auto btn btn-block btn-primary text-uppercase btn-wyvern">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
    <div class="offset-md-4 offset-lg-0 col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body d-flex flex-column">
                <div class="card-image subscription-elemental"></div>
                <div class="text-center align-self-stretch">
                    <div class="card-title text-muted text-uppercase mb-0">Elemental</div>
                    <div class="card-price price-monthly">$25<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="card-price price-yearly" aria-hidden="true">$22.91<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    <div class="price-yearly small mb-2" aria-hidden="true">{!! __('front.pricing.billed_yearly', ['amount' => '<strong>$275</strong>']) !!}</div>
                    <hr class="ribbon">
                </div>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>10 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.huge_maps', ['size' => '50 MB']) }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>
                    <li class="small">
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.impact') }}
                    </li>
                </ul>

                <a href="{{ route('settings.subscription') }}" class="mt-auto btn btn-block btn-primary text-uppercase btn-elemental">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
</div>

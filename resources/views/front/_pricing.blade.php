

<div class="row pricing mt-5 pt-5">
    <div class="col-lg-3 col-md-4 ">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="flex">
                    <div class="flex-none card-image subscription-kobold"></div>
                    <div class="flex-initial">
                        <div class="card-title text-muted text-uppercase">Kobold</div>
                        <div class="card-price ">{{ __('front.pricing.tier.free') }}</div>
                    </div>
                </div>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-danger"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>{{ __('front.pricing.benefits.no_boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.unlimited') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.core') }}
                    </li>
                    <li>
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
                <a href="{{ route('register') }}" class="btn btn-block btn-primary text-uppercase btn-kobold">
                    {{ __('front.second_block.call_to_action') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body">
                <div class="flex">
                    <div class="flex-none card-image subscription-owlbear"></div>
                    <div class="flex-initial">
                        <div class="card-title text-muted text-uppercase ">Owlbear</div>
                        <div class="card-price">$5<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                        <div class="card-ribbon card-most-popular text-center ab-testing-b">{{ __('tiers.ribbons.popular') }}</div>
                    </div>
                </div>

                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>3 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.big_maps', ['size' => '10 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" target="_blank" class="btn btn-block btn-primary text-uppercase btn-owlbear">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body">
                <div class="flex">
                    <div class="flex-none card-image subscription-wyvern"></div>
                    <div class="flex-initial">
                        <div class="card-title text-muted text-uppercase">Wyvern</div>
                        <div class="card-price">$10<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                        <div class="card-ribbon card-best-value text-center ab-testing-b">{{ __('tiers.ribbons.best-value') }}</div>
                    </div>
                </div>

                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>6 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.bigger_maps', ['size' => '20 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>

{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.curation') }}--}}
{{--                    </li>--}}
{{--                    <li class="text-muted">--}}
{{--                        <span class="fa-li"><i class="fa-regular fa-circle-xmark text-red"></i></span> {{ __('front.features.patreon.impact') }}--}}
{{--                    </li>--}}
                </ul>

                <a href="{{ route('settings.subscription') }}" target="_blank" class="btn btn-block btn-primary text-uppercase btn-wyvern">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
    <div class="offset-md-4 offset-lg-0 col-lg-3 col-md-4">
        <div class="card mb-5 mb-lg-0 mt-5 mt-md-0">
            <div class="card-body">
                <div class="flex">
                    <div class="flex-none card-image subscription-elemental"></div>
                    <div class="flex-initial">
                        <div class="card-title text-muted text-uppercase">Elemental</div>
                        <div class="card-price">$25<span class="period"> / {{ __('front.pricing.tier.month') }}</span></div>
                    </div>
                </div>

                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fa-regular fa-check-circle"></i></span>
                        <a href="{{ route('front.boosters') }}">
                            <strong>10 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.pricing.benefits.huge_maps', ['size' => '50 MB']) }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.no_ads') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fa-solid fa-check"></i></span> {{ __('front.features.patreon.impact') }}
                    </li>
                </ul>

                <a href="{{ route('settings.subscription') }}" class="btn btn-block btn-primary text-uppercase btn-elemental">
                    {{ __('front.pricing.actions.subscribe') }}
                </a>
            </div>
        </div>
    </div>
</div>

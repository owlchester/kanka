<div class="row pricing mt-3">
    <div class="col-lg-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-kobold @nowebp webpfallback @endnowebp"></div>
                <h5 class="card-title text-muted text-uppercase text-center">Kobold</h5>
                <h6 class="card-price text-center">{{ __('front.pricing.tier.free') }}</h6>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-times"></i></span>
                        <a href="{{ route('front.features', ['#boost']) }}" target="_blank">
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

    <div class="col-lg-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-owlbear @nowebp webpfallback @endnowebp"></div>
                <h5 class="card-title text-muted text-uppercase text-center">Owlbear</h5>
                <h6 class="card-price text-center">$5<span class="period">/{{ __('front.pricing.tier.month') }}</span></h6>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span>
                        <a href="{{ route('front.features', ['#boost']) }}" target="_blank">
                            <strong>3 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.higher_uploads') }} (8mb)
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.discord') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.default_image') }}
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


    <div class="col-lg-4 mb-5">
        <div class="card mb-5 mb-lg-0">
            <div class="card-body">
                <div class="card-image subscription-elemental @nowebp webpfallback @endnowebp"></div>
                <h5 class="card-title text-muted text-uppercase text-center">Elementals</h5>
                <h6 class="card-price text-center">$25<span class="period">/{{ __('front.pricing.tier.month') }}</span></h6>
                <hr>
                <ul class="fa-ul">
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span>
                        <a href="{{ route('front.features', ['#boost']) }}" target="_blank">
                            <strong>10 {{ __('front.pricing.benefits.boosters') }}</strong>
                        </a>
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.pricing.benefits.huge_uploads') }} (25mb)
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.monthly_vote') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.discord') }}
                    </li>
                    <li>
                        <span class="fa-li"><i class="fas fa-check"></i></span> {{ __('front.features.patreon.default_image') }}
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

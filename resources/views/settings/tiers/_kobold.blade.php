
    <div class="flex gap-2 items-center mb-5">
        <div class="flex-0">
            <img class="img-circle  w-24 h-24" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/kobold-325.png" alt="Kobold">
        </div>
        <div class="grow">
            <h3>Kobold</h3>
            <h5>{{ auth()->user()->currencySymbol() }}1 / {{ __('front.pricing.tier.month') }}</h5>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-3 w-fit mb-5">

        <div class="">{{ __('front.features.patreon.upload_limit') }}</div>
        <div class="">8 mb</div>

        <div class="">{{ __('front.features.patreon.upload_limit_map') }}</div>
        <div class="">10 mb</div>

        <div class="">{!! __('front.features.patreon.discord', ['discord' => link_to(config('social.discord'), 'Discord', ['target' => '_blank'])]) !!}</div>
        <div class=""><i class="fa-solid fa-check-circle"></i></div>
    </div>


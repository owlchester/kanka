
    <div class="flex gap-2 items-center">
        <div class="flex-0">
            <img class="w-16 h-16" src="https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/kobold-128.png" alt="Kobold">
        </div>
        <div class="grow">
            <h3>Kobold</h3>
            <h5>{{ auth()->user()->currencySymbol() }}1 / {{ __('front.pricing.tier.month') }}</h5>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-3 w-fit">

        <div class="">{{ __('front.features.patreon.upload_limit') }}</div>
        <div class="">8 MiB</div>

        <div class="">{{ __('front.features.patreon.upload_limit_map') }}</div>
        <div class="">10 MiB</div>

        <div class="">{!! __('front.features.patreon.discord', ['discord' => '<a href="https://kanka.io/go/discord">Discord</a>']) !!}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
    </div>


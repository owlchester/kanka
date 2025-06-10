
    <div class="flex gap-2 items-center">
        <div class="flex-0">
            <img class="w-16 h-16" src="https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/elemental-128.png" alt="Elemental">
        </div>
        <div class="grow">
            <h3>Elemental</h3>
            <h5>{{ auth()->user()->currencySymbol() }}25 / {{ __('front.pricing.tier.month') }}</h5>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-3 w-fit">

        <div class="">{{ __('front.features.patreon.upload_limit') }}</div>
        <div class="">25 MiB</div>
        <div class="">{{ __('front.features.patreon.upload_limit_map') }}</div>
        <div class="">50 MiB</div>
        <div class="">{!! __('front.features.patreon.discord', ['discord' => '<a href="https://kanka.io/go/discord">Discord</a>']) !!}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.default_image') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{!! __('front.features.patreon.hall_of_fame', ['link' => '<a href="https://kanka.io/hall-of-fame">' . __('front/hall-of-fame.title') . '</a>']) !!}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.api_calls') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.pagination') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.monthly_vote') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.boosts') }}</div>
        <div class="">10</div>


        <div class="">{{ __('front.features.patreon.curation') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
        <div class="">{{ __('front.features.patreon.impact') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>
    </div>


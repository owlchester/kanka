    <div class="flex gap-2 items-center">
        <div class="flex-0">
            <img class="w-16 h-16" src="https://d3a4xjr8r2ldhu.cloudfront.net/app/tiers/goblin-128.png" alt="Goblin">
        </div>
        <div class="grow">
            <h3 class="text-xl">Goblin</h3>
            <h5>{{ auth()->user()->currencySymbol() }}3 / {{ __('front.pricing.tier.month') }}</h5>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-3 w-fit">

        <div class="">{{ __('front.features.patreon.upload_limit') }}</div>
        <div class="">8 MiB</div>

        <div class="">{{ __('front.features.patreon.upload_limit_map') }}</div>
        <div class="">10 MiB</div>

        <div class="">{!! __('front.features.patreon.discord', ['discord' => '<a href="https://kanka.io/go/discord" class="text-link">Discord</a>']) !!}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{{ __('front.features.patreon.default_image') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{!! __('front.features.patreon.hall_of_fame', ['link' => '<a href="https://kanka.io/hall-of-fame" class="text-link">' . __('front/hall-of-fame.title') . '</a>']) !!}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{{ __('front.features.patreon.api_calls') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{{ __('front.features.patreon.pagination') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{{ __('front.features.patreon.monthly_vote') }}</div>
        <div class=""><x-icon class="fa-solid fa-check-circle" /></div>

        <div class="">{{ __('front.features.patreon.boosts') }}</div>
        <div class="">1</div>
    </div>


<div class="flex gap-1 text-base">
    <div class="w-8 shrink-0 text-center">
        @if (auth()->user()->hasBoosterNomenclature())
            <x-icon class="fa-regular fa-rocket text-boost" />
        @else
            <x-icon class="fa-regular fa-gem text-boost" />
        @endif
    </div>
    <a href="https://kanka.io/premium?utm_source=subscription&utm_medium=referral&utm_campaign=owlbear" class="text-link">
        @if (auth()->user()->hasBoosterNomenclature())
            3 {{ __('tiers.features.boosters') }}
        @else
            1 {{ __('concept.premium-campaigns') }}
        @endif
    </a>
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-image" />
    </div>
    {{ __('tiers.features.file_size', ['size' => config('limits.filesize.image.owlbear') . ' MiB']) }}
</div>
<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="check" />
    </div>
    {{ __('tiers.features.no_ads') }}
</div>

<hr class="my-4" />

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-grid" />
    </div>
    {{ __('tiers.features.pagination', ['amount' => 100]) }}
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-webhook" />
    </div>
    <a href="{{ route('larecipe.index') }}" class="text-link">
        {{ __('tiers.features.api_requests', ['amount' => config('limits.api.throttle.subscriber')]) }}
    </a>
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <div>
        {!! __('tiers.features.discord', ['discord' => '<a href="https://kanka.io/go/discord" class="text-link">Discord</a>',]) !!}
    </div>
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="check" />
    </div>
    {{ __('tiers.features.nice_image') }}
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <a href="{{ route('roadmap', ['utm_source' => 'subscription', 'utm_campaign' => 'owlbear']) }}" class="text-link">{{ __('tiers.features.roadmap') }}</a>
</div>

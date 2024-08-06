<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        @if (auth()->user()->hasBoosterNomenclature())
            <x-icon class="fa-regular fa-rocket text-boost" />
    </div>
    <a href="https://kanka.io/premium" target="_blank">3 {{ __('tiers.features.boosters') }}</a>
    @else
        <x-icon class="fa-regular fa-gem text-boost" />
</div>
<a href="https://kanka.io/premium" target="_blank">1 {{ __('concept.premium-campaigns') }}</a>
@endif
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-image" />
    </div>
    {{ __('tiers.features.file_size', ['size' => '8 MB']) }}
</div>
<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-map" />
    </div>
    {{ __('tiers.features.map_size', ['size' => '10 MB']) }}
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-grid" />
    </div>
    {{ __('tiers.features.pagination', ['amount' => 100]) }}
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-webhook" />
    </div>
    <a href="{{ route('larecipe.index') }}" target="_blank">
        {{ __('tiers.features.api_requests', ['amount' => 90]) }}
    </a>
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    {{ __('tiers.features.no_ads') }}
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <div>
        {!! __('tiers.features.discord', ['discord' => '<a href="' . config('social.discord') . '" target="_blank">Discord</a>',]) !!}
    </div>
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <div>
    {!! __('tiers.features.hall_of_fame', ['hall-of-fame' => '<a href="https://kanka.io/hall-of-fame">' . __('front/hall-of-fame.title') . '</a>']) !!}
    </div>
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    {{ __('tiers.features.nice_image') }}
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <a href="{{ route('roadmap') }}">{{ __('tiers.features.roadmap') }}</a>
</div>

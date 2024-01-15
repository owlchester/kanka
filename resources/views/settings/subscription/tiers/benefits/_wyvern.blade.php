<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-image" />
    </div>
    {{ __('tiers.features.file_size', ['size' => '15 MB']) }}
</div>
<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="fa-regular fa-map" />
    </div>
    {{ __('tiers.features.map_size', ['size' => '20 MB']) }}
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
        @if (auth()->user()->hasBoosterNomenclature())
            <x-icon class="fa-regular fa-rocket text-boostd" />
    </div>
    {!! link_to('https://kanka.io/premium', 6 . ' ' . __('tiers.features.boosters'), '', ['target' => '_blank']) !!}
    @else
        <x-icon class="fa-regular fa-gem text-boost" />
</div>
{!! link_to('https://kanka.io/premium', 3 . ' ' . __('concept.premium-campaigns'), '', ['target' => '_blank']) !!}
@endif
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
    {!! __('tiers.features.discord', ['discord' => link_to('https://kanka.io/go/discord', 'Discord')]) !!}
    </div>
</div>

<div class="flex gap-1">
    <div class="w-8 flex-shrink-0 text-center">
        <x-icon class="check" />
    </div>
    <div>
    {!! __('tiers.features.hall_of_fame', ['hall-of-fame' => link_to('https://kanka.io/go/discord', __('front/hall-of-fame.title'))]) !!}
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
    {!! link_to('https://kanka.io/votes', __('tiers.features.community_vote'), null, ['target' => '_blank']) !!}
</div>

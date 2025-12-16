<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-image" />
    </div>
    {{ __('tiers.features.file_size', ['size' => '1 MiB']) }}
</div>
<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-map" />
    </div>
    {{ __('tiers.features.map_size', ['size' => '3 MiB']) }}
</div>
<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-grid" />
    </div>
    {{ __('tiers.features.pagination', ['amount' => 45]) }}
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-webhook" />
    </div>
    <a href="{{ route('larecipe.index') }}" class="text-link">
        {{ __('tiers.features.api_requests', ['amount' => config('limits.api.throttle.standard')]) }}
    </a>
</div>

<div class="flex gap-1 text-base">
    <div class="w-8 shrink-0 text-center">
        @if (auth()->user()->hasLegacyBoosterNomenclature())
            <x-icon class="fa-regular fa-rocket text-boost" />
        @else
            <x-icon class="fa-regular fa-gem text-boost" />
        @endif
    </div>
    <div class="flex flex-col gap-0.5">
        <a href="https://kanka.io/premium?utm_source=subscription&utm_medium=referral&utm_campaign=wyvern" class="text-link" target="_blank" rel="noopener noreferrer">
            @if (auth()->user()->hasLegacyBoosterNomenclature())
                6 {{ __('tiers.features.boosters') }}
            @else
                3 {{ __('concept.premium-campaigns') }}
            @endif
        </a>

        <span class="text-xs text-neutral-content">
            {{ __('tiers.features.premium', ['storage' => config('limits.gallery.wyvern') / 1024 / 1024, 'modules' => config('limits.campaigns.modules.wyvern')]) }}
        </span>
    </div>
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-image" />
    </div>
    {{ __('tiers.features.file_size', ['size' => config('limits.filesize.image.wyvern') . ' MiB']) }}
</div>

<hr class="my-2" />

<div class="text-xs font-semibold uppercase tracking-wide text-neutral-content">
    {{ __('tiers.includes.owlbear') }}
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-upload" />
    </div>
    <a href="https://docs.kanka.io/en/latest/features/campaigns/import.html" class="text-link" target="_blank" rel="noopener noreferrer">
        {{ __('tiers.features.import') }}
    </a>
</div>

<div class="flex gap-1">
    <div class="w-8 shrink-0 text-center">
        <x-icon class="fa-regular fa-plug" />
    </div>
    <a href="{{ route('mcp.help') }}" class="text-link" target="_blank" rel="noopener noreferrer">
        {{ __('tiers.features.mcp') }}
    </a>
</div>

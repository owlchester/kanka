@php
    $user = auth()->user();
    $canToggle = $user && ($isChampioned ? $user->can('unchampion', $feature) : $user->can('champion', $feature));
    $needsSwitchConfirm = ! $isChampioned && $activeFeatureId && $activeFeatureId !== $feature->id;
@endphp

<div class="inline-flex items-center">
    @if ($canToggle)
        <button
            type="button"
            wire:click="toggle"
            @if ($needsSwitchConfirm)
                wire:confirm="{{ __('roadmap.champion.confirm_switch', ['feature' => $activeFeatureName]) }}"
            @endif
            title="{{ $isChampioned ? __('roadmap.champion.remove_tooltip') : __('roadmap.champion.tooltip') }}"
            class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium transition cursor-pointer {{ $isChampioned ? 'bg-amber-400/20 text-amber-300 ring-1 ring-amber-300/60 hover:bg-amber-400/30' : 'bg-white/10 text-white/80 hover:bg-white/20 hover:text-white' }}"
        >
            <i class="{{ $isChampioned ? 'fa-solid' : 'fa-regular' }} fa-gem" aria-hidden="true"></i>
            <span>{{ $isChampioned ? __('roadmap.champion.active') : __('roadmap.champion.action') }}</span>
            @if ($count > 0)
                <span>{{ \Illuminate\Support\Number::format($count) }}</span>
            @endif
        </button>
    @elseif ($count > 0)
        <span
            title="{{ trans_choice('roadmap.champion.count', $count, ['count' => $count]) }}"
            class="inline-flex items-center gap-1.5 rounded-full bg-amber-400/20 px-2.5 py-1 text-xs font-medium text-amber-200"
        >
            <i class="fa-solid fa-gem" aria-hidden="true"></i>
            <span>{{ \Illuminate\Support\Number::format($count) }}</span>
        </span>
    @endif
</div>

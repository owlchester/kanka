<?php /** @var \App\Models\Feature $idea **/ ?>
<div>
    <div class="flex items-center mb-5 gap-2">
        <input type="text" wire:model.live.debounce.200ms="search" class="block-input grow" placeholder="Name of an idea">
    </div>

    @if ($activeChampion?->feature)
        <div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-purple/10 px-4 py-3 text-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-gem text-purple" aria-hidden="true"></i>
                <span>{{ __('roadmap.champion.current_banner') }}</span>
                <button
                    type="button"
                    wire:click="open({{ $activeChampion->feature_id }})"
                    class="font-semibold underline hover:opacity-80 cursor-pointer"
                >
                    {{ $activeChampion->feature->name }}
                </button>
            </div>
            <button
                type="button"
                wire:click="unchampionActive"
                class="rounded-full bg-purple/15 px-3 py-1 text-xs font-medium hover:bg-purple/25 cursor-pointer"
            >
                {{ __('roadmap.champion.remove') }}
            </button>
        </div>
    @endif

    <div class="flex flex-col gap-5">
        @foreach ($ideas as $idea)
            <div class="rounded-2xl overflow-hidden flex" wire:key="idea-block-{{ $idea->id }}">
                <div class="flex-none w-40 py-5 bg-purple text-white flex flex-col items-center justify-center gap-3">
                    <div class="flex gap-2 align-center items-center justify-center text-md">
                        @livewire('roadmap.upvote', ['feature' => $idea], key("idea-{$idea->id}"))
                    </div>
                    @livewire('roadmap.champion', [
                        'feature' => $idea,
                        'count' => (int) ($idea->champions_count ?? 0),
                        'isChampioned' => (bool) $idea->userChampion,
                        'activeFeatureId' => $activeChampion?->feature_id,
                        'activeFeatureName' => $activeChampion?->feature?->name,
                    ], key("idea-champion-{$idea->id}-" . ((int) ($idea->champions_count ?? 0)) . '-' . ($activeChampion?->feature_id ?? 0)))
                </div>
                <div class="bg-gray-200 p-5 grow flex flex-col gap-5 cursor-pointer hover:bg-light transition-all duration-300" wire:click="open({{ $idea }})">
                    <h2 class="text-md">{{ $idea->name }}</h2>
                    {!! $idea->cleanDescription() !!}
                </div>
            </div>
        @endforeach

        {{ $ideas->links('livewire.front-pagination', data: ['scrollTo' => '#ideas']) }}
    </div>
</div>

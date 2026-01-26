@php
    use \Illuminate\Support\Arr;
@endphp
<div class="achievement shadow-xs hover:shadow-md rounded-xl bg-base-100 w-full sm:w-80 md:w-96 flex flex-col gap-2 md:gap-3 p-5 level-{{ $stat['level'] }}" data-achievement="{{ $key }}">

    <div class="achievement-header flex gap-2 items-center">
        <div class="grow text-xl">
            {{  __('campaigns/achievements.titles.' . $key) }}
        </div>
        @if ($key !== 'spotlighted')
        <div class="flex-none bg-base-200 rounded-lg p-2">
            {{  __('campaigns/achievements.level', ['number' => Arr::get($stat, 'level', 0)]) }}
        </div>
        @endif
    </div>

    <div class="achievement-motivation flex gap-2 md:gap-6 grow">
        <div class="flex-none w-20 h-20 rounded-full  text-4xl flex items-center justify-center
            @if ($key === 'spotlighted' && !$campaign->isPublic()) bg-base-300 text-neutral-content' @else bg-primary text-primary-content @endif">
            <x-icon class="{{ $stat['icon'] }}" />
        </div>
        <div class="grow flex flex-col">
            @if ($key === 'spotlighted')
                @if ($campaign->isPublic())
                    <x-helper>
                        <p>{{ __('campaigns/achievements.spotlight.public.helper') }}</p>
                    </x-helper>
                    <a href="{{ route('spotlights.application', ['campaign' => $campaign]) }}" class="text-link">
                        {{ __('campaigns/achievements.spotlight.public.cta') }}
                    </a>
                @else
                    <x-helper>
                        <p>{{ __('campaigns/achievements.spotlight.private.helper') }}</p>
                    </x-helper>
                    @can('update', $campaign)

                        <a href="{{ route('campaigns.edit', ['campaign' => $campaign]) }}" class="text-link">
                            {{ __('campaigns/achievements.spotlight.private.cta') }}
                        </a>
                    @endif
                @endif
            @else
                <div class="text-2xl">
                    @php
                        $remaining = Arr::get($stat, 'target', 0) - Arr::get($stat, 'amount', 0);
                    @endphp
                    {{ $remaining }}
                </div>
                <div class="text-neutral-content">
                    {{  __('campaigns/achievements.remaining.generic') }}
                </div>
            @endif
        </div>
    </div>

    <div class="flex gap-2 w-full items-end">
        <div class="grow flex flex-col gap-2">
            <div class="achievement-progress rounded-xl bg-primary-content h-2 w-full" role="progressbar">
                <div class="h-2 bg-primary rounded-xl" style="width: {{ Arr::get($stat, 'progress', 0) }}%"></div>
            </div>
            <div class="flex gap-2 text-neutral-content text-xs">
                <div class="grow">
                    {{ trans_choice('campaigns/achievements.' . Arr::get($stat, 'history', 'created'), Arr::get($stat, 'amount', 0), [
'singular' => Arr::get($stat, 'module.singular', 'Forgot singular'),
'plural' => Arr::get($stat, 'module.plural', 'Forgot plural'),
'amount' => number_format(Arr::get($stat, 'amount', 0))
]) }}
                </div>
                <div class="flex-none">
                    {{  __('campaigns/achievements.goal', ['number' => number_format(Arr::get($stat, 'target', 0))]) }}
                </div>
            </div>
        </div>
        <div class="flex-none text-2xl text-primary mb-2">
            @if ($stat['level'] === 0)
                <x-icon class="fa-duotone fa-coin" />
            @elseif ($stat['level'] === 1)
                <x-icon class="fa-duotone fa-coins" />
            @elseif ($stat['level'] === 2)
                <x-icon class="fa-duotone fa-gem" />
            @elseif ($stat['level'] === 3)
                <x-icon class="fa-duotone fa-treasure-chest" />
            @elseif ($stat['level'] === 4)
                <x-icon class="fa-duotone fa-crown" />
            @endif
        </div>
    </div>
</div>


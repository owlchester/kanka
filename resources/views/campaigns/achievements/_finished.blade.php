@php
    use \Illuminate\Support\Arr;
@endphp
<div class="achievement shadow-xs hover:shadow-md rounded-xl bg-base-100 w-full sm:w-80 md:w-96 flex flex-col gap-2 md:gap-3 p-5 md:p-5 level-{{ $stat['level'] }}" data-achievement="{{ $key }}">

    <div class="flex gap-2 md:gap-5 items-center grow">
        <div class="flex-none text-accent text-4xl border-accent border-opacity-20 rounded-full border-4 flex items-center justify-center w-20 h-20">
            <x-icon class="fa-duotone fa-crown" />
        </div>
        <div class="grow">
            <p class="text-neutral-content">
                {{  __('campaigns/achievements.congratulations') }}
            </p>
            <p class="text-lg">
                {{  __('campaigns/achievements.goal_reached') }}
            </p>
            <p class="text-accent text-xl">
                {{  __('campaigns/achievements.titles.' . $key) }}
            </p>
        </div>
    </div>

    <div class="achievement-progress rounded-xl bg-accent h-2 w-full" role="progressbar"></div>

    <div class="text-center text-neutral-content text-xs">

        {{ trans_choice('campaigns/achievements.' . Arr::get($stat, 'history', 'created'), Arr::get($stat, 'amount', 0), [
'singular' => Arr::get($stat, 'module.singular', 'Forgot singular'),
'plural' => Arr::get($stat, 'module.plural', 'Forgot plural'),
'amount' => number_format(Arr::get($stat, 'amount', 0)) . ' / ' . number_format(Arr::get($stat, 'target', 0))
]) }}
    </div>
</div>


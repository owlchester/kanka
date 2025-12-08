
<a href="//docs.kanka.io/en/latest/entities/dice-rolls.html" class="btn2">
    <x-icon class="fa-regular fa-book"></x-icon>
    <span class="hidden lg:inline">
        {{ __('general.learn-more') }}
    </span>
</a>

<a href="{{ route('dice_rolls.results', $campaign) }}" class="btn2">
    <x-icon class="fa-regular fa-list"></x-icon>
    <span class="hidden lg:inline">
        {{ __('dice_rolls.index.actions.results') }}
    </span>
</a>

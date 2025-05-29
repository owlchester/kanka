<div class="rounded-xl bg-box p-6 flex flex-col gap-4 shadow-xs">
    <h2 class="text-2xl">
        @isset ($title)
            {{ $title }}
        @elseif ($legacy)
            @if ($superboosted)
                {{ __('callouts.booster.titles.superboosted') }}
            @else
                {{ __('callouts.booster.titles.boosted') }}
            @endif
        @else
            <x-icon class="premium" />
            {{ __('callouts.premium.title') }}
        @endif
    </h2>
    <div class="max-w-2xl">
        <x-helper>
            {!! $slot !!}
        </x-helper>
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <a href="https://kanka.io/premium" class="btn2 btn-outline">
            {!! __('callouts.premium.learn-more') !!}
        </a>
        <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 bg-boost text-white">
            {{ __('callouts.actions.subscription') }}
        </a>
    </div>
</div>

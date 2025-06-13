<div class="rounded-xl bg-box p-6 flex flex-col gap-4 shadow-xs">
    <h2 class="text-2xl">
        @isset ($title)
            {{ $title }}
        @elseif ($legacy)
            @if ($premium)
                {{ __('callouts.premium.title') }}
            @elseif ($superboosted)
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

    <x-premium-cta-footer :campaign="$campaign" />
</div>

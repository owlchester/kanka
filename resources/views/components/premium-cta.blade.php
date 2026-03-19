<div class="rounded-xl bg-box p-4 md:p-6 flex flex-col gap-4 shadow-xs mx-auto max-w-2xl">
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
            {{ __('callouts.premium.title') }}
        @endif
    </h2>
    <x-grid type="1/1">
        <x-helper>
            {!! $slot !!}
        </x-helper>
        @if (isset($doc))
            <p>
                <a
                    href="https://docs.kanka.io/en/latest/{{ $doc }}" class="link text-link">
                    <x-icon class="fa-regular fa-book" />
                    {{ __('general.documentation') }}
                </a>
            </p>
        @endif
    </x-grid>


    <x-premium-cta-footer :campaign="$campaign" />
</div>

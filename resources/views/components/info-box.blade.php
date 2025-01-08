<x-box css="flex items-center gap-5">
    <div class="rounded {{ $background }} w-12 h-12 flex items-center justify-center">
        <x-icon class="{{ $icon }}" />
    </div>
    <div class="flex flex-col gap-0 grow">
        <span>{!! $title !!}</span>
        @if (isset($subtitle))
            <span class="{{ $subtitleColour }}">{!! $subtitle !!}</span>
        @endif
    </div>
    @if ($url)
        @if ($ajax)
            <div class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer" data-target="{{ $target }}" data-url="{{ $url }}" data-toggle="dialog-ajax">
                <x-icon class="fa-solid fa-angle-right" />
            </div>
        @else
            <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer" href="{{ $route }}" >
                <x-icon class="fa-solid fa-angle-right" />
            </a>
        @endif
    @elseif ($premium && !$campaign->boosted())
        <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer neutral-link" href="{{ route('settings.premium', ['campaign' => $campaign->id]) }}" data-tooltip data-title="{{ __('settings/premium.actions.unlock') }}">
            <x-icon class="fa-solid fa-gem" />
        </a>
    @endif
</x-box>

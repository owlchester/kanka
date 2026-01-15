<x-box class="flex items-center gap-5 rounded-xl shadow-xs justify-between">
    <div class="flex gap-5">
        <div class="rounded {{ $background }} w-12 h-12 text-xl flex items-center justify-center flex-none">
            <x-icon class="{{ $icon }}" />
        </div>
        <div class="flex flex-col gap-1">
            <span>{!! $title !!}</span>
            @if (isset($subtitle))
                <span class="{{ $subtitleColour }}">{!! $subtitle !!}</span>
            @endif
        </div>
    </div>
    @if ($url)
        @if ($ajax)
            <div class="{{ $attributes->get('urlButton', 'border-base-300') }} rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer hover:bg-base-200 flex-none " data-target="{{ $target }}" data-url="{{ $url }}" data-toggle="dialog" @if ($urlTooltip) data-tooltip data-title="{{ $urlTooltip }}" @endif>
                <x-icon class="{{ $urlIcon }}"/>
            </div>
        @else
            <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer hover:bg-base-200 flex-none" href="{{ $route }}" @if ($urlTooltip) data-tooltip data-title="{{ $urlTooltip }}" @endif >
                <x-icon class="{{ $urlIcon }}" />
            </a>
        @endif
    @elseif ($premium && !$campaign->boosted())
        <a class="rounded-full border h-12 w-12 flex items-center justify-center cursor-pointer neutral-link flex-none" href="{{ route('settings.premium', ['campaign' => $campaign->id]) }}" data-tooltip data-title="{{ __('settings/premium.actions.unlock') }}">
            <x-icon class="premium" />
        </a>
    @endif
</x-box>

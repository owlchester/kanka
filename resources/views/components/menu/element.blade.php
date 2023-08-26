<li class="relative w-full flex items-center rounded overflow-hidden  @if ($active) active @endif ">
    <a href="{{ $route }}" class="block max-h-14 grow select-none gap-2 py-2 px-2 transition-all duration-150 cursor-pointer truncate text-inherit"
        @if (!empty($ajax)) data-toggle="ajax-modal" data-target="#large-modal" data-url="{{ $ajax }}" @endif
        @if (!empty($id)) id="{{ $id }}" @endif
    >

        @if ($badge > 0)
            <x-badge css="float-right">
                {{ number_format($badge) }}
            </x-badge>
        @endif
        {!! $slot !!}
    </a>
    @if (!empty($button))
        <a href="{{ $button['url'] }}" class="icon py-2 px-2 text-inherit" @if(!empty($button['tooltip'])) data-title="{{ $button['tooltip'] }}" data-toggle="tooltip" @endif>
            <i class="{{ $button['icon'] }}" aria-hidden="true"></i>
            <span class="sr-only">{{ !empty($button['tooltip']) ? $button['tooltip'] : 'Helper icon' }}</span>
        </a>
    @endif
</li>

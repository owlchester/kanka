<li class="relative w-full flex items-center rounded overflow-hidden  @if ($active) active @endif ">
    <a href="{{ $route }}" class="flex justify-between max-h-14 grow select-none gap-2 py-2 px-2 transition-all duration-150 cursor-pointer text-inherit items-center overflow-hidden group"
        @if (!empty($ajax)) data-toggle="dialog" data-url="{{ $ajax }}" @endif
        @if (!empty($id)) id="{{ $id }}" @endif
    >
        <span class="truncate block">
        {!! $slot !!}
        </span>

        @if ($badge > 0)
            <div class="text-neutral-content bg-base-200 group-hover:bg-base-100 rounded-lg px-2 py-0.5 text-xs flex items-center justify-center">
                {{ number_format($badge) }}
            </div>
        @endif
    </a>
    @if (!empty($button))
        <a href="{{ $button['url'] }}" class="icon py-2 px-2 text-neutral-content" @if(!empty($button['tooltip'])) data-title="{{ $button['tooltip'] }}" data-toggle="tooltip"  aria-label="{{ $button['tooltip'] }}" @else aria-label="" @endif>
            <i class="{{ $button['icon'] }}" aria-hidden="true"></i>
            <span class="sr-only">{{ !empty($button['tooltip']) ? $button['tooltip'] : 'Helper icon' }}</span>
        </a>
    @endif
</li>

<a
    href="{{ $link }}"
    @if (isset($target)) target="_blank" @endif
    class="{{ $css }} group px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 transition-all duration-150 text-xs @if ($active) pointer-events-none @else text-base-content @endif "
    @if (isset($dialog)) data-toggle="dialog" data-url="{{ $dialog }}" @endif
    @if (isset($popup)) data-toggle="dialog" data-target="{{ $popup }}" @endif
    @if (isset($dataProperties))
        @foreach ($dataProperties as $key => $prop)
            data-{{ $key }}="{{ $prop }}"
        @endforeach
    @endif
>
    <div class="flex gap-2 justify-between w-full">
        <div class="flex gap-1">
            @if (isset($icon))
                <span class="shrink-0 w-6 text-neutral-content text-center flex-none">
                    <x-icon :class="$icon" />
                </span>
            @endif
            <span class="@if ($active) text-neutral-content  @endif">
            {!! $slot !!}
            </span>
        </div>
        @if ($active)
            <x-icon class="fa-regular fa-check" />
        @endif
        @if (!empty($shortcut))
            <span class="text-neutral-content hidden md:inline-block px-1" data-title="Keyboard shortcut" data-tooltip>
                {!! $shortcut !!}
            </span>
        @endif
    </div>
</a>

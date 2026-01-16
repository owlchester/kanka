<a
    href="{{ $link }}"
    @if (isset($target)) target="_blank" @endif
    class="{{ $css }} px-2 py-2 hover:bg-base-200 rounded-xl flex items-center gap-1.5 text-sm text-base-content transition-all duration-150 @if ($active) pointer-events-none text-accent @endif "
    @if (isset($dialog)) data-toggle="dialog" data-url="{{ $dialog }}" @endif
    @if (isset($popup)) data-toggle="dialog" data-target="{{ $popup }}" @endif
    @if (isset($keyboard)) data-keyboard="{{ $keyboard }}" @endif
    @if (isset($dataProperties))
        @foreach ($dataProperties as $key => $prop)
            data-{{ $key }}="{{ $prop }}"
        @endforeach
    @endif
>
    @if (isset($icon))
        <span class="shrink-0 w-4 text-center flex-none">
            <x-icon :class="$icon" />
        </span>
    @endif
    {!! $slot !!}
</a>

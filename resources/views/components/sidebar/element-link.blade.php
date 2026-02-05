<a href="{{ $url }}" class="px-2 py-1.5 flex items-center gap-2 rounded text-sm {{ $class }}" title="{{ $text }}">
    @if (!empty($icon))
    <span class="w-5 text-center">
        <i class="shrink-0 text-sm {{ $icon }}"></i>
    </span>
    @endif
    <span class="truncate">{!! $text !!}</span>
</a>

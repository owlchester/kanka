<a
    href="{{ $link }}"
    @if (isset($target)) target="_blank" @endif
    class="p-1 hover:bg-base-200 rounded flex items-center gap-2 text-sm text-base-content {{ $css }}"
    @if (isset($dialog)) data-toggle="dialog" data-target="primary-dialog" data-url="{{ $dialog }}" @endif
    @if (isset($popup)) data-toggle="dialog" data-target="{{ $popup }}" @endif
    @if (isset($keyboard)) data-keyboard="{{ $keyboard }}" @endif
    @if (isset($dataProperties))
        @foreach ($dataProperties as $key => $prop)
            data-{{ $key }}="{{ $prop }}"
        @endforeach
    @endif
>
    {!! $slot !!}
</a>

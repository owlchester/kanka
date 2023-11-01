<div class="badge flex gap-1 items-center {{ $colour }} {{ $css }}" @if ($title) data-toggle="tooltip" data-title="{!! $title !!}" @endif
>
    {!! $slot !!}
</div>

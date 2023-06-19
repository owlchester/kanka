<div class="grid mb-2 gap-2 md:gap-4 md:mb-4
@if ($type === '3/4') grid-cols-4
@elseif ($type === '3/3') md:grid-cols-3
@elseif ($type === '1/1') grid-cols-1
@else grid-cols-1 md:grid-cols-2 flex-col @endif
{{ $css }}
@if ($hidden) hidden @endif"
@if ($id) id="{{ $id }}" @endif
>
    {!! $slot !!}
</div>

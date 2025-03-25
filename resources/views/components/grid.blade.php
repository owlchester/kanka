<div class="flex flex-col @if ($type !== '1/1') md:grid @endif gap-4 w-full
@if ($type === '3/4') grid-cols-4
@elseif ($type === '3/3') md:grid-cols-3
@elseif ($type !== '1/1') grid-cols-1 md:grid-cols-2 @endif
{{ $class ?? null }}
@if ($hidden) hidden @endif"
@if ($id) id="{{ $id }}" @endif
>
    {!! $slot !!}
</div>

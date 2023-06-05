<div class="grid @if ($type === '3/4') grid-cols-4 @else grid-cols-1 md:grid-cols-2 flex-col @endif gap-2 md:gap-4 {{ $css }}
@if ($hidden) hidden @endif"
@if ($id) id="{{ $id }}" @endif
>
    {!! $slot !!}
</div>

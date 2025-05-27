<?php /** @var \Illuminate\View\ComponentAttributeBag $attributes */?>
<div class="flex flex-col @if ($type !== '1/1') md:grid @endif gap-4 md:gap-6 xl:gap-8 w-full
@if ($type === '3/4') grid-cols-4
@elseif ($type === '3/3') md:grid-cols-3
@elseif ($type !== '1/1') grid-cols-1 md:grid-cols-2 @endif
{{ $attributes->get('class') }}
@if ($hidden) hidden @endif"
@if ($id) id="{{ $id }}" @endif
>
    {!! $slot !!}
</div>

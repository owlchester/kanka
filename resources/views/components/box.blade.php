<div class="rounded @if($padding) p-4 @endif shadow-xs bg-box mb-5 {{ $css }} w-full transition-all duration-150" @if(!empty($id)) id="{{ $id }}" @endif
@if ($url) data-url="{{ $url }}" @endif
@if ($href) href="{{ $href }}" @endif
>
    {!! $slot !!}
</div>

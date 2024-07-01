<div class="rounded @if($padding) p-4 @endif shadow-xs bg-box {{ $css }} w-full transition-all duration-150"
@if(!empty($id)) id="{{ $id }}" @endif
@if ($url) data-url="{{ $url }}" @endif
@if ($href) href="{{ $href }}" @endif
@foreach ($extra as $k => $v) data-{{ $k }}="{{ $v }}" @endforeach
>
    {!! $slot !!}
</div>

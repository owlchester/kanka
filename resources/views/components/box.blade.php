<div {{ $attributes->merge(['class' => 'rounded ' . ($padding ? 'p-4' : ''). ' shadow-xs bg-box w-full transition-all duration-150']) }}
@if(!empty($id)) id="{{ $id }}" @endif
@if ($url) data-url="{{ $url }}" @endif
@if ($href) href="{{ $href }}" @endif
@foreach ($extra as $k => $v) data-{{ $k }}="{{ $v }}" @endforeach
>
    @if (isset($title))
        <div class="text-2xl mb-6 font-light">{{ $title }}</div>
    @endif
    {!! $slot !!}
</div>

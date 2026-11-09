@if ($url)
    <a href="{{ $url }}" {{ $attributes->merge(['class' => 'block px-4 py-1.5 text-xs font-semibold uppercase tracking-wider']) }} title="{{ $text }}">
        {{ $text }}
    </a>
@else
    <div {{ $attributes->merge(['class' => 'px-4 py-1.5 text-xs font-semibold uppercase tracking-wider']) }}>
        {{ $text }}
    </div>
@endif

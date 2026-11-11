@props(['status', 'compact' => true])
@if ($status->isCustom() || $status->icon)
<span {{ $attributes->class(['inline-flex items-center gap-1']) }}>
    @if ($status->icon)
        <i class="{{ $status->icon() }}" aria-hidden="true" title="{{ $status->name() }}"></i>
    @endif
    <span @class(['sr-only' => $compact && $status->icon])>{{ $status->name() }}</span>
</span>
@endif

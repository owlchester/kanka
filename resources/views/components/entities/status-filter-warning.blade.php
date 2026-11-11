@props(['filters'])
@php
    if (is_string($filters)) {
        parse_str($filters, $filters);
    }
    $deletedStatus = str_contains(json_encode($filters['status_id'] ?? null), 'deleted:');
@endphp
@if ($deletedStatus)
    <p role="status" {{ $attributes->class(['text-warning text-sm']) }}>{{ __('A selected status was deleted. Edit the filters to restore this list; no entries are shown until the filter is repaired.') }}</p>
@endif

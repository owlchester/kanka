<?php /** @var \Carbon\Carbon $date */?>
<span data-toggle="tooltip" data-title="{{ $formatted }}@if ($withTime) UTC @endif" {{ $attributes->merge(['class' => "text-xs text-neutral-content elapsed"]) }} data-date="{{ $date }}">
    {{ $elapsed() }}
</span>

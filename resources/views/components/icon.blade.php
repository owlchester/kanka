@if ($tooltip) <span data-title="{{ $title }}" data-toggle="tooltip" data-html="true" @if (request()->ajax()) data-append="parent" @endif>@endif
<i class="{{ $class ?? null }} {{ $size }}" aria-hidden="true"
@if (!$tooltip && $title) title="{{ $title }}" @endif
@if ($label) aria-label="{{ $label }}" @endif
@if ($show) x-show="{{ $show }}" @endif
></i>
@if ($tooltip) </span> @endif

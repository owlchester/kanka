@if ($tooltip) <span data-title="{{ $title }}" data-toggle="tooltip" data-html="true" @if (request()->ajax()) data-append="parent" @endif>@endif
<i class="{{ $class }} {{ $size }}" aria-hidden="true"
    @if (!$tooltip && $title) title="{{ $title }}" @endif
></i>
@if ($tooltip) </span> @endif

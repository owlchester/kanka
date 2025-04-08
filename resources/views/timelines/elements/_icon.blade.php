<?php
if (!isset($absolute)) {
    $absolute = true;
}
$min = $absolute ? 'absolute top-0 text-center w-8 h-8 rounded-full' : 'rounded-full';
?>

@if (!empty($element->icon))
    @if (Illuminate\Support\Str::startsWith($element->icon, '<i class='))
        {!! str_replace('<i class="', '<i class="bg-' . $element->colour . ' ' . $min . ' ', $element->icon) !!}
    @else
        <i class="bg-{{ $element->colour }} {{ $element->icon }} {{ $min }}" aria-hidden="true"></i>
    @endif
@else
    <i class="fa fa-solid fa-hourglass-half bg-{{ $element->colour }} {{ $min }}" aria-hidden="true"></i>
@endif

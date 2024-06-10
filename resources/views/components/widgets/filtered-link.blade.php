@if ($isLink)
    <a href="{{ $url }}">{!! $title !!}</a>
@else
    {!! $title !!}
@endif

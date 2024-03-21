@if ($isLink)
    {!! link_to($url, $title) !!}
@else
    {!! $title !!}
@endif

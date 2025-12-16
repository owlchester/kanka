@if ($isLink)
    <a href="{{ $url }}" class="text-link">{!! $title !!}</a>
@else
    {!! $title !!}
@endif

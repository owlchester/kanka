@if ($point->hasTarget())
    @if (Auth::check())
        @can('view', $point->target)
            {!! $point->makePin() !!}
        @endcan
    @else
        @if (!empty($point->target()->acl(null)->first()))
            {!! $point->makePin() !!}
        @endif
    @endif
@else
    {!! $point->makePin() !!}
@endif
@if ($point->hasTarget())
    @if ($point->targetEntity->child && EntityPermission::canView($point->targetEntity, $point->location->campaign))
         {!! $point->makePin() !!}
    @endif
@else
    {!! $point->makePin() !!}
@endif
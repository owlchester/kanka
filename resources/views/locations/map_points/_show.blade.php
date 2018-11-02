
<div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="title">
            @if (!$mapPoint->hasTarget())
                {{ $mapPoint->name }}
            @else
                <a href="{{ $mapPoint->target->getLink('show') }}">{{ $mapPoint->target->name }}</a>
            @endif
        </h4>
    </div>
    <div class="panel-body">
        @if ($mapPoint->hasTarget())
            {!! $mapPoint->target->tooltip(500) !!}
        @endif
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="title entity-title">
            @if (!$mapPoint->hasTarget())
                {{ $mapPoint->name }}
            @else
                <a href="{{ $mapPoint->target->getLink('show') }}">
                    <span class="entity-image" style="background-image: url('{{ $mapPoint->target->getImageUrl(true) }}')"></span>
                    <span class="entity-name">{{ $mapPoint->target->name }}</span>
                </a>

                @if ($mapPoint->target->is_private)
                    <span class="pull-right help-block">
                        <i class="fa fa-lock"></i>
                    </span>
                @endif
            @endif
        </h3>
    </div>
    <div class="panel-body">
        @if ($mapPoint->hasTarget())
            <div class="entity-entry">
            {!! $mapPoint->target->entry !!}
            </div>

    </div>
    <div class="panel-footer">
            <a href="{{ $mapPoint->target->getLink() }}">{{ __('crud.actions.go_to', ['name' => $mapPoint->target->name]) }}</a>

            @if ($mapPoint->target->getEntityType() == 'location' && !empty($mapPoint->target->map))
                <a href="{{ $mapPoint->target->getLink('map') }}" class="pull-right"><i class="fa fa-map"></i> {{ __('locations.show.tabs.map') }}</a>
            @endif
        @else
            <p class="help-block">{{ __('locations.map.helpers.label') }}</p>
        @endif
    </div>
</div>
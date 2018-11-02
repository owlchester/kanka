
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="title entity-title">
            @if (!$mapPoint->hasTarget())
                {{ $mapPoint->name }}
            @else
                <a href="{{ $mapPoint->targetEntity->child->getLink('show') }}">
                    <span class="entity-image" style="background-image: url('{{ $mapPoint->targetEntity->child->getImageUrl(true) }}')"></span>
                    <span class="entity-name">{{ $mapPoint->targetEntity->name }}</span>
                </a>

                @if ($mapPoint->targetEntity->child->is_private)
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
            {!! $mapPoint->targetEntity->child->entry !!}
            </div>
    </div>
    <div class="panel-footer">
            <a href="{{ $mapPoint->targetEntity->child->getLink() }}">{{ __('crud.actions.go_to', ['name' => $mapPoint->targetEntity->name]) }}</a>

            @if ($mapPoint->targetEntity->type == 'location' && !empty($mapPoint->targetEntity->child->map))
                <a href="{{ $mapPoint->targetEntity->child->getLink('map') }}" class="pull-right"><i class="fa fa-map"></i> {{ __('locations.show.tabs.map') }}</a>
            @endif
        @else
            <p class="help-block">{{ __('locations.map.helpers.label') }}</p>
        @endif
    </div>
</div>
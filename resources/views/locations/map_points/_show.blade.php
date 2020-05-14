
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="title entity-title">
            <i class="fa fa-times pull-right fa-xs entity-close" title="{{ __('crud.click_modal.close') }}"></i>

            @if ($mapPoint->hasTarget() && $mapPoint->targetEntity->child->is_private)
                <span class="pull-right fa-xs margin-r-5">
                    <i class="fas fa-lock"></i>
                </span>
            @endif
            @if (!$mapPoint->hasTarget())
                {{ $mapPoint->name }}
            @else
                <a href="{{ $mapPoint->targetEntity->child->getLink('show') }}">
                    <span class="entity-image" style="background-image: url('{{ $mapPoint->targetEntity->child->getImageUrl(40) }}')"></span>
                    <span class="entity-name">{{ $mapPoint->targetEntity->name }}</span>
                </a>
            @endif

        </h3>
    </div>
    <div class="panel-body">
        @if ($mapPoint->hasTarget())
            <div class="entity-entry">
            {!! $mapPoint->targetEntity->child->entry() !!}
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

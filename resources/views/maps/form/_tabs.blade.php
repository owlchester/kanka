
<li class="{{ (request()->get('tab') == 'form-layers' ? ' active' : '') }}">
    <a href="#form-layers" title="{{ trans('maps.panels.layers') }}" data-toggle="tooltip">
        {{ trans('maps.panels.layers') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-markers' ? ' active' : '') }}">
    <a href="#form-markers" title="{{ trans('maps.panels.markers') }}" data-toggle="tooltip">
        {{ trans('maps.panels.markers') }}
    </a>
</li>

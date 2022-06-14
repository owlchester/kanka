
<li class="{{ (request()->get('tab') == 'form-settings' ? ' active' : '') }}">
    <a href="#form-settings" title="{{ __('maps.panels.settings') }}" data-toggle="tooltip">
        {{ __('maps.panels.settings') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-layers' ? ' active' : '') }}">
    <a href="#form-layers" title="{{ __('maps.panels.layers') }}" data-toggle="tooltip">
        {{ __('maps.panels.layers') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-groups' ? ' active' : '') }}">
    <a href="#form-groups" title="{{ __('maps.panels.groups') }}" data-toggle="tooltip">
        {{ __('maps.panels.groups') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-markers' ? ' active' : '') }}">
    <a href="#form-markers" title="{{ __('maps.panels.markers') }}" data-toggle="tooltip">
        {{ __('maps.panels.markers') }}
    </a>
</li>

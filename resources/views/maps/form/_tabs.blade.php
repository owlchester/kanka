
<li class="{{ (request()->get('tab') == 'form-settings' ? ' active' : '') }}">
    <a href="#form-settings" title="{{ __('maps.panels.settings') }}" data-toggle="tooltip">
        {{ __('maps.panels.settings') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-markers' ? ' active' : '') }}">
    <a href="#form-markers" title="{{ __('maps.panels.markers') }}" data-toggle="tooltip">
        {{ __('maps.panels.markers') }}
    </a>
</li>

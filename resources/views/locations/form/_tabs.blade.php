@if (isset($model) && !empty($model->map) && auth()->user()->can('map', $model))
    <li class="{{ (request()->get('tab') == 'form-map' ? ' active' : '') }}">
        <a href="#form-map" title="{{ __('locations.panels.map') }}" data-toggle="tooltip">
            {{ __('locations.panels.map') }}
        </a>
    </li>
@endif

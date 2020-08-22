@if (isset($model) && !empty($model->map) && auth()->user()->can('map', $model))
    <li class="{{ (request()->get('tab') == 'form-map' ? ' active' : '') }}">
        <a href="#form-map" title="{{ trans('locations.panels.map') }}" data-toggle="tooltip">
            {{ trans('locations.panels.map') }}
        </a>
    </li>
@endif

@if (isset($model) && !empty($model->map) && auth()->user()->can('map', $model))
<div class="tab-pane {{ (request()->get('tab') == 'form-map' ? ' active' : '') }}" id="form-map">
    @include('locations.form._map', ['source' => null])
</div>
@endif

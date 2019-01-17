<div class="form-group">
    <label>{{ trans('locations.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('locations.placeholders.type'), 'class' => 'form-control', 'maxlength' => 45]) !!}
</div>
<div class="form-group">
    {!! Form::select2(
        'parent_location_id',
        (isset($model) && $model->parentLocation ? $model->parentLocation : $formService->prefillSelect('parentLocation', $source)),
        App\Models\Location::class,
        false,
        'crud.fields.location',
        'locations.find',
        'locations.placeholders.location'
    ) !!}
</div>
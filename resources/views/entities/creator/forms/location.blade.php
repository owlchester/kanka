@include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])

<div class="form-group">
    {!! Form::select2(
        'parent_location_id',
        (isset($model) && $model->parentLocation ? $model->parentLocation : FormCopy::field('parentLocation')->select()),
        App\Models\Location::class,
        false,
        'locations.fields.location',
        'locations.find',
        'locations.placeholders.location'
    ) !!}
</div>

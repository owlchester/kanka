<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
    </div>
    <div class="col-sm-6">
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
    </div>
</div>


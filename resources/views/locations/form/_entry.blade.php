<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'locations'])
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
        <div class="form-group">
            {!! Form::select2(
                'parent_location_id',
                (isset($model) && $model->parentLocation ? $model->parentLocation : FormCopy::field('parentLocation')->select(true, \App\Models\Location::class)),
                App\Models\Location::class,
                true,
                'locations.fields.location',
                'locations.find',
                'locations.placeholders.location'
            ) !!}
        </div>
        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>

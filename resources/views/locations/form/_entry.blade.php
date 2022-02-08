<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'locations'])
    </div>
    <div class="col-md-6">
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::foreignSelect(
                'parent_location_id',
                [
                    'preset' => (isset($model) && $model->parentLocation ? $model->parentLocation : FormCopy::field('parentLocation')->select(true, \App\Models\Location::class)),
                    'class' => App\Models\Location::class,
                    'quickCreator' => true,
                    'labelKey' => 'locations.fields.location',
                    'placeholderKey' => 'locations.placeholders.location',
                    'from' => isset($model) ? $model : null,
                ],
            ) !!}
        </div>
    </div>
</div>
@include('cruds.fields.entry2')

<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.image')
    </div>
</div>
@include('cruds.fields.private2')

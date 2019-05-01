<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ trans('locations.fields.name') }}</label>
            {!! Form::text('name', $formService->prefill('name', $source), ['placeholder' => trans('locations.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])
        <div class="form-group">
            {!! Form::select2(
                'parent_location_id',
                (isset($model) && $model->parentLocation ? $model->parentLocation : $formService->prefillSelect('parentLocation', $source)),
                App\Models\Location::class,
                true,
                'crud.fields.location',
                'locations.find',
                'locations.placeholders.location'
            ) !!}
        </div>
        @include('cruds.fields.tags')
        @include('cruds.fields.attribute_template')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>
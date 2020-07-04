
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'maps'])
        @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])
        @include('cruds.fields.map', ['parent' => true])
        @include('cruds.fields.location')
        <hr />

        <div class="form-group">
            <label>{{ trans('maps.fields.grid') }}</label>
            {!! Form::text(
                'grid',
                FormCopy::field('grid')->string(),
                [
                    'placeholder' => trans('maps.placeholders.grid'),
                    'class' => 'form-control',
                    'maxlength' => 4
                ]
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

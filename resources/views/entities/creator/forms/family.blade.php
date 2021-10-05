<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::select2(
                'family_id',
                (isset($model) && $model->family ? $model->family : FormCopy::field('family')->select()),
                App\Models\Family::class,
                false,
                'families.fields.family'
            ) !!}
        </div>
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.location')
    </div>
</div>

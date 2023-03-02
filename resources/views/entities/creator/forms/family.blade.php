
@include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'families'])
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            {!! Form::select2(
                'family_id',
                (isset($model) && $model->family ? $model->family : FormCopy::field('family')->select()),
                App\Models\Family::class,
                false,
                'families.fields.family',
                null,
                null,
                null,
                request()->ajax() ? '#entity-modal' : null,
            ) !!}
        </div>
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.location')
    </div>
</div>

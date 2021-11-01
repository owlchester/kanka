
@include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])


<div class="row">
    <div class="col-lg-6">
        <div class="form-group">
            {!! Form::select2(
                'organisation_id',
                (isset($model) && $model->organisation ? $model->organisation : FormCopy::field('organisation')->select()),
                App\Models\Organisation::class,
                false,
                'organisations.fields.organisation'
            ) !!}
        </div>
    </div>
    <div class="col-lg-6">
        @include('cruds.fields.location')
    </div>
</div>

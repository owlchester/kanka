@include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])
<div class="form-group">
    {!! Form::select2(
        'organisation_id',
        (isset($model) && $model->organisation ? $model->organisation : FormCopy::field('organisation')->select()),
        App\Models\Organisation::class,
        false,
        'organisations.fields.organisation'
    ) !!}
</div>

@include('cruds.fields.location')
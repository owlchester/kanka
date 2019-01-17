<div class="form-group">
    <label>{{ trans('organisations.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('organisations.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
<div class="form-group">
    {!! Form::select2(
        'organisation_id',
        (isset($model) && $model->organisation ? $model->organisation : $formService->prefillSelect('organisation', $source)),
        App\Models\Organisation::class,
        false,
        'organisations.fields.organisation'
    ) !!}
</div>

@include('cruds.fields.location')
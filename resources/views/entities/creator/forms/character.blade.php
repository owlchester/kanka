<div class="form-group">
    <label>{{ trans('characters.fields.title') }}</label>
    {!! Form::text('title', $formService->prefill('title', $source), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
@include('cruds.fields.family')
@include('cruds.fields.race')
@include('cruds.fields.location')

<div class="form-group">
    <label>{{ trans('characters.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('characters.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
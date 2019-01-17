<div class="form-group">
    <label>{{ trans('events.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('events.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
<div class="form-group">
    <label>{{ trans('events.fields.date') }}</label>
    {!! Form::text('date', $formService->prefill('date', $source), ['placeholder' => trans('events.placeholders.date'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
@include('cruds.fields.location')
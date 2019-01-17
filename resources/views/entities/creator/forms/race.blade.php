
<div class="form-group">
    <label>{{ trans('races.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('races.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
@include('cruds.fields.race')
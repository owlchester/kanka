<div class="form-group">
    <label>{{ trans('items.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('items.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

@include('cruds.fields.location')
@include('cruds.fields.character')
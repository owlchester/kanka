<div class="form-group">
    <label>{{ trans('notes.fields.type') }}</label>
    {!! Form::text('type', $formService->prefill('type', $source), ['placeholder' => trans('notes.placeholders.type'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', $formService->prefill('history', $source), ['class' => 'form-control']) !!}
</div>
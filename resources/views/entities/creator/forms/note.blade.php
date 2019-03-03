@include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])

<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', $formService->prefill('history', $source), ['class' => 'form-control']) !!}
</div>
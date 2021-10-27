@include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])

<div class="form-group">
    {!! Form::select2(
        'note_id',
        (isset($model) && $model->note ? $model->note : FormCopy::field('note')->select()),
        App\Models\Note::class,
        false,
        'notes.fields.note',
        'notes.find',
        'notes.placeholders.note'
    ) !!}
</div>

<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control']) !!}
</div>

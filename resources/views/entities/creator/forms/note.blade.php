@include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])

<div class="form-group">
    <label>{{ trans('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control']) !!}
</div>
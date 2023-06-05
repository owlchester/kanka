<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    @include('cruds.fields.note', ['isParent' => true])
</x-grid>
<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control resize-y', 'rows' => 5]) !!}
</div>


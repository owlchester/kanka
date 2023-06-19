<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    @include('cruds.fields.note', ['isParent' => true])

    <div class="field-entry col-span-2">
        <label>{{ __('crud.fields.entry') }}</label>
        {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control resize-y', 'rows' => 5]) !!}
    </div>
</x-grid>



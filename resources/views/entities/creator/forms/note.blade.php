<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    @include('cruds.fields.note', ['isParent' => true])

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">
        {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => ' resize-y', 'rows' => 5]) !!}
    </x-forms.field>
</x-grid>



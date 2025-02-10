<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Note::class, 'trans' => 'notes'])
    @include('cruds.fields.note', ['isParent' => true, 'dynamicNew' => true])

    <x-forms.field field="entry" css="col-span-2" :label="__('crud.fields.entry')">

            <textarea name="entry"
                      class="resize-y"
                      rows="5"
            >{!! FormCopy::field('entry')->string() !!}</textarea>
    </x-forms.field>
</x-grid>



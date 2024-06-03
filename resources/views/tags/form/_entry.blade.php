<x-grid>
    @include('cruds.fields.name', ['trans' => 'tags'])
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])
    @include('cruds.fields.colour')

    @include('cruds.fields.entry2')

    <x-forms.field field="auto-apply" :label="__('tags.fields.is_auto_applied')">
        <input type="hidden" name="is_auto_applied" value="0" />
        <x-checkbox :text="__('tags.hints.is_auto_applied')">
            {!! Form::checkbox('is_auto_applied', 1, $model->is_auto_applied ?? '' )!!}
        </x-checkbox>
    </x-forms.field>
    <x-forms.field field="hidden" :label="__('tags.fields.is_hidden')">
        <input type="hidden" name="is_hidden" value="0" />
        <x-checkbox :text="__('tags.hints.is_hidden')">
            {!! Form::checkbox('is_hidden', 1, $model->is_hidden ?? '' )!!}
        </x-checkbox>
    </x-forms.field>
    @include('cruds.fields.image')

</x-grid>

<x-grid>
    @include('cruds.fields.name', ['trans' => 'items'])
    @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

    @include('cruds.fields.item', ['isParent' => true])
    @include('cruds.fields.price', ['trans' => 'items'])

    <x-forms.field
        field="size"
        :label="__('items.fields.size')">
        {!! Form::text(
            'size',
            FormCopy::field('size')->string(),
            [
                'placeholder' => __('items.placeholders.size'),
                'maxlength' => 191
            ]
        ) !!}
    </x-forms.field>

    @include('cruds.fields.location')

    @include('cruds.fields.character', ['label' => __('items.fields.character'), 'name' => 'character_id'])

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>

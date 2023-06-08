<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

    @include('cruds.fields.item', ['isParent' => true])

    @include('cruds.fields.location')

    @include('cruds.fields.character', ['label' => __('items.fields.character')])
</x-grid>

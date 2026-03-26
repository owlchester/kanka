<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.parent')

    @include('cruds.fields.colour_picker', ['dropdownParent' => '#primary-dialog'])
</x-grid>

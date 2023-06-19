<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

    @include('cruds.fields.tag', ['isParent' => true])

    @include('cruds.fields.colour')
</x-grid>

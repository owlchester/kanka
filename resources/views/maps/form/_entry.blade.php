<x-grid>
    @include('cruds.fields.entity-name')

    @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])

    @include('cruds.fields.map', ['isParent' => true, 'from' => $model ?? null])

    @include('cruds.fields.location')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image', ['size' => 'map'])
</x-grid>

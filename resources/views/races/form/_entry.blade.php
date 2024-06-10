<x-grid>
    @include('cruds.fields.name', ['trans' => 'races'])
    @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])

    @include('cruds.fields.race', ['isParent' => true])
    @include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>

<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])

    @include('cruds.fields.race', ['isParent' => true])
</x-grid>

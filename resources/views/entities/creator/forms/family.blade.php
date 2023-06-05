<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'families'])
    @include('cruds.fields.family', ['isParent' => true])
    @include('cruds.fields.location')
</x-grid>

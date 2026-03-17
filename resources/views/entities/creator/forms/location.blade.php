<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])

    @include('cruds.fields.parent')
</x-grid>


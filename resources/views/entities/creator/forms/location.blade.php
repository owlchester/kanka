<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])

    @include('cruds.fields.location', ['isParent' => true, 'dynamicNew' => true])
</x-grid>


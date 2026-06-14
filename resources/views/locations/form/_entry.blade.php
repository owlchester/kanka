<x-grid>
    @include('cruds.fields.title')

    @include('cruds.fields.type', ['base' => \App\Models\Location::class, 'trans' => 'locations'])

    @include('cruds.fields.parent')

    @include('cruds.fields.entry2')

    @include('cruds.fields.status')

    @include('cruds.fields.tags')
</x-grid>

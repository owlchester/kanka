<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])
    @include('cruds.fields.organisation', ['isParent' => true])
    @include('cruds.fields.locations')
</x-grid>

<x-grid>
    @include('cruds.fields.name', ['trans' => 'journals'])
    @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])

    @include('cruds.fields.journal', ['isParent' => true])
    @include('cruds.fields.date')

    @include('cruds.fields.author')
    @include('cruds.fields.location')

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>

<hr />
@include('cruds.forms._calendar', ['source' => $source])


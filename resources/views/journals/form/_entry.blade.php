@include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])

@include('cruds.fields.parent')

@include('cruds.fields.author')
@include('cruds.fields.locations', ['from' => $model ?? null, 'quickCreator' => true])

@include('cruds.fields.date')

<div class="col-span-2">
    @include('cruds.forms._calendar', ['source' => $source])
</div>

@include('cruds.fields.entry2')

@include('cruds.fields.tags')

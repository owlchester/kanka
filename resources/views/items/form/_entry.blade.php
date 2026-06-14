@include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

@include('cruds.fields.parent')
@include('cruds.fields.price', ['trans' => 'items'])
@include('cruds.fields.size', ['trans' => 'items'])
@include('cruds.fields.weight', ['trans' => 'items'])

@include('cruds.fields.location')

@include('cruds.fields.creators')

@include('cruds.fields.entry2')

@include('cruds.fields.status')

@include('cruds.fields.tags')

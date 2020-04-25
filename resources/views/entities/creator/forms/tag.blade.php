
@include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])
@include('cruds.fields.colour')
@include('cruds.fields.tag', ['parent' => true])

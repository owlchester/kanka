<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'tags'])
        @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])

        @include('cruds.fields.colour')
        @include('cruds.fields.tag', ['parent' => true])
@include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>

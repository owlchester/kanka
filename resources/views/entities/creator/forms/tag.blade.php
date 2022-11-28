<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Tag::class, 'trans' => 'tags'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.tag', ['parent' => true])
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.colour')
    </div>
</div>

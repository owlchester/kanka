@include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

@include('cruds.fields.item', ['parent' => true, 'quickCreator' => true])

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.location', ['quickCreator' => true])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.character', ['quickCreator' => true])
    </div>
</div>

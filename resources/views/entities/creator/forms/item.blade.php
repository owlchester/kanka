@include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

@include('cruds.fields.item', ['parent' => true])

<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.location')
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.character')
    </div>
</div>

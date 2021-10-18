@include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

<div class="row">
    <div class="col-lg-6">
@include('cruds.fields.location')
    </div>
    <div class="col-lg-6">
@include('cruds.fields.character')
    </div>
</div>

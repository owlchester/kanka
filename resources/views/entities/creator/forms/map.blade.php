
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])

    @include('cruds.fields.map', ['isParent' => true])
</div>

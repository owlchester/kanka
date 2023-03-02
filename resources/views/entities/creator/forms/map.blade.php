
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])

    <div class="form-group">
        {!! Form::select2(
            'map_id',
            null,
            App\Models\Map::class,
            false,
            'maps.fields.map',
            null,
            null,
            null,
            request()->ajax() ? '#entity-modal' : null,
        ) !!}
    </div>
</div>

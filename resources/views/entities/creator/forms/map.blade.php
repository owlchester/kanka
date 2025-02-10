
<div class="grid grid-cols-2 gap-5">
    @include('cruds.fields.type', ['base' => \App\Models\Map::class, 'trans' => 'maps'])

    @include('cruds.fields.map', ['isParent' => true, 'dynamicNew' => true])
    @include('cruds.fields.location', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])
</div>

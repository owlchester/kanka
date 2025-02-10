<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Race::class, 'trans' => 'races'])
    @include('cruds.fields.race', ['isParent' => true, 'dynamicNew' => true])
    @include('cruds.fields.locations', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])]])
</x-grid>

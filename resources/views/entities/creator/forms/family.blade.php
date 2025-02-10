<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Timeline::class, 'trans' => 'families'])
    @include('cruds.fields.family', ['isParent' => true, 'dynamicNew' => true])
    @include('cruds.fields.location', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])
</x-grid>

<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Organisation::class, 'trans' => 'organisations'])
    @include('cruds.fields.organisation', ['isParent' => true, 'dynamicNew' => true])
    @include('cruds.fields.locations', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])
</x-grid>

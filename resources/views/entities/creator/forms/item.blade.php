<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Item::class, 'trans' => 'items'])

    @include('cruds.fields.item', ['isParent' => true, 'dynamicNew' => true])

    @include('cruds.fields.price', ['trans' => 'items'])
    @include('cruds.fields.size', ['trans' => 'items'])
    @include('cruds.fields.weight', ['trans' => 'items'])

    @include('cruds.fields.location', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])

    @include('cruds.fields.creator')

</x-grid>

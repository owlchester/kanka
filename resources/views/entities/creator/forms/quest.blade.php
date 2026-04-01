@include('cruds.fields.type', ['base' => \App\Models\Quest::class, 'trans' => 'quests'])
<x-grid>
    @include('cruds.fields.parent')
    @include('cruds.fields.instigator')
    @include('cruds.fields.location', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])
</x-grid>

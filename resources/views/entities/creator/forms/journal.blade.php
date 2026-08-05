
<div class="grid gap-5 grid-cols-1 md:grid-cols-2">
    @include('cruds.fields.type', ['base' => \App\Models\Journal::class, 'trans' => 'journals'])
    @include('cruds.fields.parent')
    @include('cruds.fields.locations', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])
</div>

@include('cruds.fields.author')

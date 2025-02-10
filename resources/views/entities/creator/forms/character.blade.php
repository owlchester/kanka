<x-grid>
    @include('cruds.fields.title')

    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.families', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.family'))->first(), $campaign])])

    @include('cruds.fields.races', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.race'))->first(), $campaign])])

    @include('cruds.fields.location', ['dynamicNew' => auth()->user()->can('create', [$campaign->getEntityTypes()->where('id', config('entities.ids.location'))->first(), $campaign])])

    @include('cruds.fields.sex', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.age', ['trans' => 'characters'])
</x-grid>



<input type="hidden" name="is_personality_visible" value="{{ $campaign->entity_personality_visibility ? 0 : 1 }}" />

<x-grid>
    @include('cruds.fields.title')

    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.families')

    @include('cruds.fields.races')

    @include('cruds.fields.location', ['allowNew' => true, 'dynamicNew' => true])

    @include('cruds.fields.sex', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.age', ['trans' => 'characters'])
</x-grid>



<input type="hidden" name="is_personality_visible" value="{{ $campaign->entity_personality_visibility ? 0 : 1 }}" />

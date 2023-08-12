<x-grid>
    @include('cruds.fields.title')

    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.families')

    @include('cruds.fields.races')

    @include('cruds.fields.location')

    @include('cruds.fields.sex', ['base' => \App\Models\Character::class, 'trans' => 'characters'])

    @include('cruds.fields.age', ['trans' => 'characters'])
</x-grid>



{!! Form::hidden('is_personality_visible', $campaign->entity_personality_visibility ? 0 : 1) !!}

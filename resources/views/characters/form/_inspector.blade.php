<section class="flex flex-col gap-4" aria-labelledby="character-identity-heading">
    <h2 id="character-identity-heading" class="text-sm font-semibold">{{ __('entries/workspace.identity') }}</h2>
    @include('cruds.fields.type', ['base' => \App\Models\Character::class, 'trans' => 'characters'])
    @include('cruds.fields.title')
    @include('cruds.fields.status')
    @include('characters.form._age')
    @include('cruds.fields.sex')
    @include('cruds.fields.pronouns')
</section>

<section class="entry-workspace-inspector-section entry-workspace-traits flex flex-col gap-4 pt-6" aria-labelledby="character-traits-heading">
    <h2 id="character-traits-heading" class="text-sm font-semibold">{{ __('characters.fields.traits') }}</h2>
    @include('characters.form._traits', ['compactTraits' => true])
</section>

<section class="entry-workspace-inspector-section flex flex-col gap-4 pt-6" aria-labelledby="character-connections-heading">
    <h2 id="character-connections-heading" class="text-sm font-semibold">{{ __('entries/workspace.connections') }}</h2>
    @include('cruds.fields.families', ['quickCreator' => true])
    @include('cruds.fields.locations', ['from' => $entity ?? null, 'quickCreator' => true, 'model' => $entity ?? $source ?? null])
    @include('cruds.fields.races', ['quickCreator' => true])
</section>

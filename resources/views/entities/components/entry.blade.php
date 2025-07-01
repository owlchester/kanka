@if ($entity->hasEntry())
    <article class="bg-box rounded box-entity-entry">
    <div class="p-4 entity-content overflow-x-auto" data-word-count="{{ $entity->words }}">
        @if (auth()->check())
            @can('update', [$entity])
                <div class="float-right ml-2 mb-2">
                    <a href="{{ route('entities.entry.edit', [$campaign, $entity]) }}" data-title="{{ __('crud.edit') }}" role="button" class="" data-toggle="tooltip">
                        <x-icon class="edit" />
                        <span class="sr-only">{{ __('crud.edit') }}</span>
                    </a>
                </div>
            @endcan
        @endif
        {!! $entity->parsedEntry() !!}
        <x-word-count :count="$entity->words" />
    </div>
</article>
@endif

@includeWhen($entity->isCharacter() && $entity->child->is_appearance_pinned, 'characters.panels._appearance')
@includeWhen($entity->isCharacter() && $entity->child->is_personality_pinned, 'characters.panels._personality')



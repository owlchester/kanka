<a href="{{ route('entities.entity_abilities.reorder', [$campaign, $entity]) }}" class="btn2 btn-sm">
    <x-icon class="fa-solid fa-sort"></x-icon>
    <span class="hidden md:inline">{{ __('entities/abilities.show.reorder') }}</span>
    <span class="md:hidden">{{ __('sidebar.campaign_switcher.reorder') }}</span>
</a>
<a href="{{ route('entities.entity_abilities.reset', [$campaign, $entity]) }}" class="btn2 btn-sm">
    <x-icon class="fa-solid fa-redo"></x-icon>
    <span class="hidden md:inline">{{ __('entities/abilities.actions.reset') }}</span>
    <span class="md:hidden">{{ __('crud.actions.reset') }}</span>
</a>
@if ($entity->isCharacter())
    <a href="{{ route('entities.entity_abilities.import', [$campaign, $entity, 'from' => 'race']) }}" class="btn2 btn-sm">
        <x-icon :class="config('entities.icons.race')"></x-icon>
        <span class="hidden md:inline">{{ __('entities/abilities.actions.import_from_race') }}</span>
        <span class="md:hidden">{{ __('entities/abilities.actions.import_from_race_mobile') }}</span>
    </a>
@endif
<a href="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}" class="btn2 btn-sm btn-accent"
    data-toggle="dialog" data-target="abilities-dialog" data-url="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}">
    <x-icon class="plus"></x-icon>
    <span class="hidden md:inline">{{ __('entities/abilities.actions.add') }}</span>
    <span class="md:hidden">{{ __('crud.add') }}</span>
</a>

<div class="join flex items-center">
    <!-- Main add button -->
    <a href="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}" class="btn2 btn-sm join-item"
        data-toggle="dialog" data-target="abilities-dialog" data-url="{{ route('entities.entity_abilities.create', [$campaign, $entity]) }}">
        <x-icon class="plus" />
        <span class="hidden md:inline">{{ __('entities/abilities.actions.add') }}</span>
        <span class="md:hidden">{{ __('crud.add') }}</span>
    </a>

    <!-- Dropdown using the entity-actions style -->
    <div class="dropdown entity-actions-dropdown flex items-center join-item">

        <div data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="abilities-submenu" class="btn2 btn-sm join-item entity-actions-button">
            <x-icon class="fa-solid fa-caret-down" />
        </div>

        <div class="dropdown-menu hidden" role="menu" id="abilities-submenu">
            @if ($entity->isCharacter())
                @php $raceModule = \App\Models\EntityType::default()->where('code', 'race')->first(); @endphp
                <x-dropdowns.item
                    link="#"
                    :dialog=" route('entities.entity_abilities.import.confirm', [$campaign, $entity]) "
                    icon="{{ $raceModule->icon() }}"
                    data-toggle="dialog" data-target="abilities-dialog" data-url="{{ route('entities.entity_abilities.import.confirm', [$campaign, $entity]) }}" data-title="{{ __('entities/abilities.helpers.sync') }}" data-toggle="tooltip"
                >
                    <span class="hidden md:inline">{{ __('entities/abilities.actions.sync') }}</span>
                </x-dropdowns.item>
            @endif

            <x-dropdowns.item :link="route('entities.entity_abilities.reset', [$campaign, $entity])" icon="fa-regular fa-redo">
                <span class="grow">{{ __('entities/abilities.actions.reset') }}</span>
            </x-dropdowns.item>

            <x-dropdowns.item :link="route('entities.entity_abilities.reorder', [$campaign, $entity])"
                              icon="fa-regular fa-arrow-up-arrow-down">
                <span class="grow">{{ __('entities/abilities.show.reorder') }}</span>
            </x-dropdowns.item>
            
            <x-dropdowns.divider />

            <x-dropdowns.item :link="'https://docs.kanka.io/en/latest/entities/abilities.html#entity-abilities'" icon="fa-regular fa-book">
                <span class="grow">{{ __('general.learn-more') }}</span>
            </x-dropdowns.item>
        </div>
    </div>
</div>

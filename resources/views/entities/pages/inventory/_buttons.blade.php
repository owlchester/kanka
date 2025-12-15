<div class="dropdown entity-actions-dropdown flex items-center join-item">
    <div data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="inventories-submenu" class="btn2 btn-sm join-item entity-actions-button">
        <x-icon class="fa-solid fa-plus" />
        {{ __('crud.add') }}
        <x-icon class="fa-solid fa-caret-down" />
    </div>

    <div class="dropdown-menu hidden" role="menu" id="inventories-submenu">
        <x-dropdowns.item
            link="#"
            :dialog="route('entities.inventories.create', [$campaign, $entity])"
            icon="plus"
            data-toggle="dialog" data-target="inventories-dialog" data-url="{{ route('entities.inventories.create', [$campaign, $entity]) }}" data-title="{{ __('entities/inventories.actions.create') }}" data-toggle="tooltip"
        >
            <span class="hidden md:inline">{{ __('entities/inventories.actions.add') }}</span>
        </x-dropdowns.item>

        <x-dropdowns.item
            link="#"
            :dialog="route('entities.inventory.generate', [$campaign, $entity])"
            icon="fa-regular fa-dice"
            data-toggle="dialog" data-target="inventories-dialog" data-url="{{ route('entities.inventory.generate', [$campaign, $entity]) }}" data-title="{{ __('entities/inventories.actions.generate') }}" data-toggle="tooltip"
        >
            <span class="hidden md:inline">{{ __('entities/inventories.actions.generate') }}</span>
        </x-dropdowns.item>

        <x-dropdowns.item
            link="#"
            :dialog="route('entities.inventory.copy', [$campaign, $entity])"
            icon="fa-regular fa-copy"
            data-toggle="dialog" data-target="inventories-dialog" data-url="{{ route('entities.inventory.copy', [$campaign, $entity]) }}" data-title="{{ __('entities/inventories.actions.copy_from') }}" data-toggle="tooltip"
        >
            <span class="hidden md:inline">{{ __('entities/inventories.actions.copy_from_entity') }}</span>
        </x-dropdowns.item>

        <x-dropdowns.divider />

        <x-dropdowns.item :link="'https://docs.kanka.io/en/latest/features/inventory.html'" icon="fa-regular fa-book">
            <span class="grow">{{ __('general.learn-more') }}</span>
        </x-dropdowns.item>
    </div>
</div>
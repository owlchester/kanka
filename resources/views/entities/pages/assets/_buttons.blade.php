<div class="dropdown entity-actions-dropdown flex items-center">
    <div data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="assets-submenu" class="btn2 btn-sm join-item entity-actions-button">
        <x-icon class="fa-solid fa-plus" />
        {{ __('crud.add') }}
        <x-icon class="fa-solid fa-caret-down" />
    </div>
    <div class="dropdown-menu hidden" role="menu" id="assets-submenu">
        <x-dropdowns.item link="#" icon="fa-regular fa-masks-theater" :dialog="route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::alias])">
            <span class="hidden md:inline">{{ __('entities/assets.actions.alias') }}</span>
        </x-dropdowns.item>

        <x-dropdowns.item link="#" icon="fa-regular fa-file" :dialog="route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::file])">
            <span class="hidden md:inline">{{ __('entities/assets.actions.file') }}</span>
        </x-dropdowns.item>

        <x-dropdowns.item link="#" icon="fa-regular fa-link" :dialog="route('entities.entity_assets.create', [$campaign, $entity, 'type' => \App\Enums\EntityAssetType::link])">
            <span class="hidden md:inline">{{ __('entities/assets.actions.link') }}</span>
        </x-dropdowns.item>
        <x-dropdowns.divider />

        <x-dropdowns.item :link="'https://docs.kanka.io/en/latest/features/assets.html'" icon="fa-regular fa-book">
            <span class="grow">{{ __('general.learn-more') }}</span>
        </x-dropdowns.item>
    </div>
</div>
<h3 id="features">{{ __('campaigns/modules.sections.features')}}</h3>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">

    <div class="cell col-span-1 flex">
        @include('campaigns.modules.box', ['icon' => 'fa-regular fa-suitcase', 'module' => 'inventories'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.modules.box', ['icon' => 'fa-regular fa-table', 'module' => 'entity_attributes'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.modules.box', ['icon' => 'fa-regular fa-folder', 'module' => 'assets'])
    </div>
</div>

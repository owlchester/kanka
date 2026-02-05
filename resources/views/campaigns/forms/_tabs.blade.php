<?php /** @var \App\Models\Campaign $model */?>
<div class="flex gap-2 items-center justify-between ">
    <div class="overflow-x-auto">
        <ul class="nav-tabs flex items-stretch w-full" role="tablist">
            <x-tab.tab target="entry" :default="true" :title="__('crud.tabs.overview')"></x-tab.tab>
            <x-tab.tab target="public" :title="__('campaigns.panels.sharing')" />
            <x-tab.tab target="ui" :title="__('campaigns.panels.ui')" />
            <x-tab.tab target="dashboard" :title="__('campaigns.panels.dashboard')" />
        </ul>
    </div>
    @include('cruds.fields.save', ['disableCopy' => true, 'disableNew' => true, 'disableCancel' => true, 'target' => 'entity-form', 'entityType' => 'campaign'])
</div>

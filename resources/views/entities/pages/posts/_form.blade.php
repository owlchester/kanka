<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $model
 */
?>
<div class="nav-tabs-custom">
    <div class="flex gap-2 items-center ">
        <div class="grow overflow-x-auto">
            <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                <x-tab.tab target="entry" :default="true" :title="__('crud.fields.entry')"></x-tab.tab>
                @can('permissions', $entity)
                    <x-tab.tab target="permissions" :title="__('entities/notes.show.advanced')"></x-tab.tab>
                @endcan
                @if (auth()->user()->can('useTemplates', $campaign) && !empty($templates))
                    <x-tab.tab target="templates" :title="__('entities/attributes.template.load.title')"></x-tab.tab>
                @endif
            </ul>
        </div>
        @include('entities.pages.posts.forms._save-options')
    </div>
    <div class="tab-content bg-base-100 p-4 rounded-bl rounded-br">
        @include('entities.pages.posts.forms._main')
        @includeWhen(auth()->user()->can('permissions', $entity), 'entities.pages.posts.forms._permissions')
        @includeWhen(auth()->user()->can('useTemplates', $campaign) && !empty($templates), 'entities.pages.posts.forms._templates')
    </div>
</div>

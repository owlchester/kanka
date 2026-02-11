<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $model
 */
?>
<div class="nav-tabs-custom bg-base-100 p-4 rounded-xl flex flex-col gap-6 relative">
    <div class="flex gap-2 items-center justify-between sticky top-12 bg-base-100 z-10">
        <div class="overflow-x-auto">
            <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                <x-tab.tab target="entry" :default="true" :title="__('fields.description.label')"></x-tab.tab>
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
    <div class="tab-content">
        @include('entities.pages.posts.forms._main')
        @includeWhen(auth()->user()->can('permissions', $entity), 'entities.pages.posts.forms._permissions')
        @includeWhen(auth()->user()->can('useTemplates', $campaign) && !empty($templates), 'entities.pages.posts.forms._templates')
    </div>
</div>

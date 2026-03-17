<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Post $model
 */
?>
<div class="nav-tabs-custom flex flex-col gap-6 relative bg-base-100 p-4 rounded-xl">
    <div class="flex flex-col gap-2 z-10 ">
        <div class="flex gap-2 items-center w-full">
            <input
                class="grow min-w-0"
                type="text"
                name="name"
                placeholder="{{ __('entities/notes.placeholders.name') }}"
                value="{!! htmlspecialchars(old('name', str_replace('&amp;', '&', $model->name ?? ''))) !!}"
                maxlength="191"
                data-live-disabled="1"
                data-1p-ignore="true" />
            <div class="shrink-0">
                @include('entities.pages.posts.forms._visibility')
            </div>
            <div class="shrink-0">
                @include('entities.pages.posts.forms._save-options')
            </div>
        </div>
        <div class="overflow-x-auto">
            <ul class="nav-tabs flex items-stretch w-full" role="tablist">
                <x-tab.tab target="entry" :default="true" :title="__('articles.tabs.main')"></x-tab.tab>
                <x-tab.tab target="layout" :title="__('articles.tabs.layout')"></x-tab.tab>
                @can('permissions', $entity)
                    <x-tab.tab target="permissions" :title="__('crud.tabs.permissions')"></x-tab.tab>
                @endcan
                @if (auth()->user()->can('useTemplates', $campaign) && !empty($templates))
                    <x-tab.tab target="templates" :title="__('posts/templates.tab')"></x-tab.tab>
                @endif
            </ul>
        </div>
    </div>
    <div class="tab-content">
        @include('entities.pages.posts.forms._main')
        @include('entities.pages.posts.forms._layout')
        @includeWhen(auth()->user()->can('permissions', $entity), 'entities.pages.posts.forms._permissions')
        @includeWhen(auth()->user()->can('useTemplates', $campaign) && !empty($templates), 'entities.pages.posts.forms._templates')
    </div>
</div>

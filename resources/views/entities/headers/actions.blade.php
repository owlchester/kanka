<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Campaign $campaign
 * */?>

@can('update', $model)
    <a href="{{ $model->getLink('edit') }}" class="btn2 btn-sm ">
        <x-icon class="pencil" />
        {{ __('crud.edit') }}
    </a>
@endcan


<div class="dropdown entity-actions-dropdown flex items-center">
    <div role="button" tabindex="0" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="entity-submenu" class="btn2 btn-sm entity-actions-button">
        <span class="sr-only">{{ __('entities/permissions.quick.screen-reader') }}</span>
        <x-icon class="fa-solid fa-ellipsis-h" />
    </div>
    <div class="dropdown-menu hidden" role="menu" id="entity-submenu">
        @can('update', $model)
            <x-dropdowns.item :link="route($entity->pluralType() . '.edit', [$campaign, $model->id])" keyboard="edit">
                <x-icon class="pencil" />
                <span class="grow">{{ __('crud.edit') }}</span>

                <span class="keyboard-shortcut"  title="{!! __('crud.keyboard-shortcut', ['code' => '[E]']) !!}" data-html="true">E</span>
            </x-dropdowns.item>
        @endcan
        @can('create', $model)
            <x-dropdowns.item :link="route($entity->pluralType() . '.create', $campaign)">
                <x-icon class="fa-regular fa-plus" />
                {{ __('crud.actions.new') }}
            </x-dropdowns.item>
            @if (method_exists($model, 'getParentKeyName'))
                <x-dropdowns.item :link="route($entity->pluralType() . '.create', [$campaign, $model->entity, 'parent_id' => $model->id])">
                    <x-icon class="fa-regular fa-plus" />
                    {{ __('crud.actions.new_child') }}
                </x-dropdowns.item>
            @endif
            <x-dropdowns.item link="{{ route($entity->pluralType() . '.create', [$campaign, 'copy' => $model->id]) }}">
                <x-icon class="fa-regular fa-copy" />
                {{ __('crud.actions.copy') }}
            </x-dropdowns.item>
        @endcan

        @if ($model->entity)
            @if(auth()->check())
                @can('update', $model)
                    @if ($model instanceof \App\Models\Timeline)
                        <x-dropdowns.item :link="route('timelines.reorder', [$campaign, $model])">
                            <x-icon class="fa-solid fa-list-ol" />
                            {{ __('timelines.show.tabs.reorder-elements') }}
                        </x-dropdowns.item>
                    @endif
                @endcan

                <x-dropdowns.item link="#" :data="['title' => $model->getEntityType() . ':' . $model->entity->id, 'toggle' => 'tooltip', 'clipboard' => '[' . $model->getEntityType() . ':' . $model->entity->id .']', 'toast' => __('crud.alerts.copy_mention')]">
                    <x-icon class="fa-solid fa-link" />
                    {{ __('crud.actions.copy_mention') }}
                </x-dropdowns.item>
                @can('setTemplates', $campaign)
                    <x-dropdowns.item :link="route('entities.template', [$campaign, $entity])">
                        @if($entity->isTemplate())
                            <x-icon class="fa-regular fa-star" />
                            {{ __('entities/actions.templates.unset') }}
                        @else
                            <x-icon class="fa-solid fa-star" />
                            {{ __('entities/actions.templates.set') }}
                        @endif
                    </x-dropdowns.item>
                @endcan
                <hr class="m-0" />

                @can('post', [$model, 'add'])
                    <x-dropdowns.item :link="route('entities.posts.create', [$campaign, $model->entity])">
                        <x-icon class="plus" />
                        {{ __('crud.actions.new_post') }}
                    </x-dropdowns.item>
                @endcan
                @can('update', $model)

                    <x-dropdowns.item :link="route('entities.story.reorder', [$campaign, $model->entity->id])">
                        <x-icon class="fa-solid fa-list-ol" />
                        {{ __('entities/story.reorder.icon_tooltip') }}
                    </x-dropdowns.item>

                    <x-dropdowns.item link="{{ route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table']) }}" :dialog="route('entities.relations.create', [$campaign, 'entity' => $model->entity, 'mode' => 'table'])">
                        <x-icon class="fa-solid fa-people-arrows" />
                        {{ __('entities/relations.create.new_title') }}
                    </x-dropdowns.item>
                @endcan
            @endif
        @endif
        @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && auth()->check() && auth()->user()->hasOtherCampaigns($model->campaign_id))
            <hr class="m-0" />
            <x-dropdowns.item link="{{ route('entities.move', [$campaign, $entity->id]) }}">
                <x-icon class="fa-regular fa-clone" />
                @can('update', $model)
                    {{ __('crud.actions.move') }}
                @else
                    {{ __('crud.actions.copy') }}
                @endcan
            </x-dropdowns.item>
        @endif

        @if ((empty($disableMove) || !$disableMove) && auth()->check() && auth()->user()->can('move', $model))
            <x-dropdowns.item link="{{ route('entities.transform', [$campaign, $entity->id]) }}">
                <x-icon class="fa-solid fa-exchange-alt" />
                {{ __('crud.actions.transform') }}
            </x-dropdowns.item>
        @endif

        @if ($model->entity)
                <hr class="m-0" />
            <x-dropdowns.item link="{{ route('entities.html-export', [$campaign, $entity]) }}">
                <x-icon class="fa-solid fa-print" />
                {{ __('crud.actions.print') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="{{ route('entities.json.export', [$campaign, $entity]) }}">
                <x-icon class="fa-solid fa-download" />
                {{ __('crud.actions.json-export') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="{{ route('entities.markdown.export', [$campaign, $entity]) }}">
                <x-icon class="fa-solid fa-download" />
                {{ __('crud.actions.markdown-export') }}
            </x-dropdowns.item>
        @endif

        @can('delete', $model)
            @php
                $url = route('confirm-delete', [$campaign, 'route' => route($entity->pluralType() . '.destroy', [$campaign, $model->id]), 'name' => $entity->name]);
            @endphp
            <hr class="m-0" />
            <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]">
                <x-icon class="trash" />
                {{ __('crud.remove') }}
            </x-dropdowns.item>
        @endcan
    </div>
</div>

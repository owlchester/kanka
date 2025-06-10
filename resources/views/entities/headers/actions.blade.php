<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * */
?>

@if (!isset($edit) || $edit !== false)
@can('update', $entity)
    <a href="{{ $entity->url('edit') }}" class="btn2 btn-sm ">
        <x-icon class="pencil" />
        {{ __('crud.edit') }}
    </a>
@endcan
@endif


<div class="dropdown entity-actions-dropdown flex items-center">
    <div role="button" tabindex="0" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="entity-submenu" class="btn2 btn-sm entity-actions-button">
        <span class="sr-only">{{ __('Open action menu') }}</span>
        <x-icon class="fa-regular fa-ellipsis-h" />
    </div>
    <div class="dropdown-menu hidden" role="menu" id="entity-submenu">
        @can('update', $entity)
            <x-dropdowns.item :link="route('entities.edit', [$campaign, $entity])" keyboard="edit" icon="pencil">
                <span class="grow">{{ __('crud.edit') }}</span>

                <span class="keyboard-shortcut"  title="{!! __('crud.keyboard-shortcut', ['code' => '[E]']) !!}" data-html="true">E</span>
            </x-dropdowns.item>
        @endcan
        @can('create', [$entity->entityType, $campaign])
            <x-dropdowns.item :link="$entity->entityType->createRoute($campaign)" icon="fa-regular fa-plus">
                {{ __('crud.actions.new') }}
            </x-dropdowns.item>
            @if ($entity->entityType->isSpecial() || (!$entity->entityType->isSpecial() && method_exists($entity->child, 'getParentKeyName')))
                <x-dropdowns.item :link="$entity->entityType->createRoute($campaign, ['parent_id' => $entity->entityType->isSpecial() ? $entity->id : $entity->child->id])" icon="fa-regular fa-plus">
                    {{ __('crud.actions.new_child') }}
                </x-dropdowns.item>
            @endif
            <x-dropdowns.item link="{{ $entity->entityType->createRoute($campaign, ['copy' => $entity->id]) }}" icon="fa-regular fa-copy">
                {{ __('crud.actions.copy') }}
            </x-dropdowns.item>
        @endcan

        @if ($entity)
            @if(auth()->check())
                @can('update', $entity)
                    @if ($entity->isTimeline())
                        <x-dropdowns.item :link="route('timelines.reorder', [$campaign, $entity->child])" icon="fa-regular fa-list-ol">
                            {{ __('timelines.show.tabs.reorder-elements') }}
                        </x-dropdowns.item>
                    @endif
                @endcan

                <x-dropdowns.item link="#" :data="['title' => $entity->entityType->code . ':' . $entity->id, 'toggle' => 'tooltip', 'clipboard' => '[' . $entity->entityType->code . ':' . $entity->id .']', 'toast' => __('crud.alerts.copy_mention')]" icon="fa-regular fa-at">
                    {{ __('crud.actions.copy_mention') }}
                </x-dropdowns.item>
                @can('setTemplates', $campaign)
                    <x-dropdowns.item :link="route('entities.template', [$campaign, $entity])" :icon="$entity->isTemplate() ? 'fa-regular fa-star' : 'fa-solid fa-star'">
                        @if($entity->isTemplate())
                            {{ __('entities/actions.templates.unset') }}
                        @else
                            {{ __('entities/actions.templates.set') }}
                        @endif
                    </x-dropdowns.item>
                @endcan
                <x-dropdowns.divider />

                @can('post', [$entity])
                    <x-dropdowns.item :link="route('entities.posts.create', [$campaign, $entity])" icon="fa-regular fa-pen-to-square">
                        {{ __('crud.actions.new_post') }}
                    </x-dropdowns.item>
                @endcan
                @can('update', $entity)

                    <x-dropdowns.item :link="route('entities.story.reorder', [$campaign, $entity])" icon="fa-regular fa-list-ol">
                        {{ __('entities/story.reorder.icon_tooltip') }}
                    </x-dropdowns.item>

                    <x-dropdowns.item link="{{ route('entities.relations.create', [$campaign, 'entity' => $entity, 'mode' => 'table']) }}" :dialog="route('entities.relations.create', [$campaign, 'entity' => $entity, 'mode' => 'table'])" icon="fa-regular fa-people-arrows">
                        {{ __('entities/relations.create.new_title') }}
                    </x-dropdowns.item>
                @endcan
            @endif
        @endif
        @if ((empty($disableCopyCampaign) || !$disableCopyCampaign) && auth()->check() && auth()->user()->hasOtherCampaigns($entity->campaign_id))
            @php /** todo: the option should be visible even if a user has no other campaigns to show that its possible, and the page should then warn the user about them not having another campaign */ @endphp
            <x-dropdowns.divider />
            <x-dropdowns.item link="{{ route('entities.move', [$campaign, $entity]) }}" icon="fa-regular fa-clone">
                @can('update', $entity)
                    {{ __('crud.actions.move') }}
                @else
                    {{ __('crud.actions.copy') }}
                @endcan
            </x-dropdowns.item>
        @endif

        @if ((empty($disableMove) || !$disableMove) && auth()->check() && auth()->user()->can('move', $entity))
            <x-dropdowns.item link="{{ route('entities.transform', [$campaign, $entity]) }}" icon="fa-regular fa-exchange-alt">
                {{ __('crud.actions.transform') }}
            </x-dropdowns.item>
        @endif

        @if ($entity)
            <x-dropdowns.divider />
            <x-dropdowns.item link="{{ route('entities.html-export', [$campaign, $entity]) }}" icon="fa-regular fa-print">
                {{ __('crud.actions.print') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="{{ route('entities.json.export', [$campaign, $entity]) }}" icon="fa-regular fa-download">
                {{ __('crud.actions.json-export') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="{{ route('entities.markdown.export', [$campaign, $entity]) }}" icon="fa-regular fa-download">
                {{ __('crud.actions.markdown-export') }}
            </x-dropdowns.item>
        @endif

        @can('delete', $entity)
            @php
                $url = route('confirm-delete', [$campaign, 'route' => route('entities.destroy', [$campaign, $entity]), 'name' => $entity->name]);
            @endphp
            <x-dropdowns.divider />
            <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]" icon="trash">
                {{ __('crud.remove') }}
            </x-dropdowns.item>
        @endcan
    </div>
</div>

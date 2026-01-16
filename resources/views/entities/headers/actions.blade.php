<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Campaign $campaign
 * */
$create = false;
$manage = false;
$system = false;
$data = false;

?>

@if (!isset($edit) || $edit !== false)
@can('update', $entity)
    <a href="{{ $entity->url('edit') }}" class="btn2 btn-sm" data-tooltip data-title="<div class='flex gap-3 items-center'><span>{{ __('entities/actions.tooltips.edit') }}</span><span class='inline-block rounded border-base-300 border px-1'>E</span></div>" data-html="true">
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
        <!-- Create & Link section -->
        @can('create', [$entity->entityType, $campaign])
            @php $create = true; @endphp
            <x-dropdowns.item :link="$entity->entityType->createRoute($campaign)" icon="fa-regular fa-plus">
                {{ __('crud.actions.new') }}
            </x-dropdowns.item>
            @if ($entity->entityType->isCustom() || ($entity->entityType->isStandard() && method_exists($entity->child, 'getParentKeyName')))
                <x-dropdowns.item :link="$entity->entityType->createRoute($campaign, ['parent_id' => $entity->entityType->isCustom() ? $entity->id : $entity->child->id])" icon="fa-regular fa-plus">
                    {{ __('crud.actions.new_child') }}
                </x-dropdowns.item>
            @endif
        @endcan
        @if ($entity && auth()->check())
            @can('post', [$entity])
                @php $create = true; @endphp
                <x-dropdowns.item :link="route('entities.posts.create', [$campaign, $entity])" icon="fa-regular fa-pen-to-square">
                    {{ __('crud.actions.new_post') }}
                </x-dropdowns.item>
            @endcan

            @can('update', $entity)
                @php $create = true; @endphp
                <x-dropdowns.item link="{{ route('entities.relations.create', [$campaign, 'entity' => $entity, 'mode' => 'table']) }}" :dialog="route('entities.relations.create', [$campaign, 'entity' => $entity, 'mode' => 'table'])" icon="fa-regular fa-people-arrows">
                    {{ __('entities/relations.create.new_title') }}
                </x-dropdowns.item>
            @endcan
        @endif

        @if ($create) <x-dropdowns.divider /> @endif

        <!-- Manage section -->
        @can('create', [$entity->entityType, $campaign])
            @php $manage = true; @endphp
            <x-dropdowns.item link="{{ $entity->entityType->createRoute($campaign, ['copy' => $entity->id]) }}" icon="fa-regular fa-copy">
                {{ __('crud.actions.copy') }}
            </x-dropdowns.item>
        @endcan
        @auth
            @php $manage = true; @endphp
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


            @can('update', $entity)
                <x-dropdowns.item :link="route('entities.story.reorder', [$campaign, $entity])" icon="fa-regular fa-list-ol">
                    {{ __('entities/story.reorder.icon_tooltip') }}
                </x-dropdowns.item>
            @endcan

            @can('update', $entity)
                @if ($entity->isTimeline())
                    <x-dropdowns.item :link="route('timelines.reorder', [$campaign, $entity->child])" icon="fa-regular fa-list-ol">
                        {{ __('timelines.show.tabs.reorder-elements') }}
                    </x-dropdowns.item>
                @endif
            @endcan
        @endif

        @if ($manage) <x-dropdowns.divider /> @endif


        <!-- System section -->
        @auth
            @if ((empty($disableCopyCampaign) || !$disableCopyCampaign))
                @php /** todo: the option should be visible even if a user has no other campaigns to show that its possible, and the page should then warn the user about them not having another campaign */ @endphp
                @php $system = true; @endphp
                @can('update', $entity)
                    <x-dropdowns.item link="{{ route('entities.move', [$campaign, $entity]) }}" icon="fa-regular fa-share-from-square">
                        {{ __('entities/actions.transfer') }}
                    </x-dropdowns.item>
                @else
                    <x-dropdowns.item link="{{ route('entities.move', [$campaign, $entity]) }}" icon="copy">
                        {{ __('entities/actions.copy-campaign') }}
                    </x-dropdowns.item>
                @endcan
            @endif

            @if ((empty($disableMove) || !$disableMove) && auth()->user()->can('move', $entity))
                @php $system = true; @endphp
                <x-dropdowns.item link="{{ route('entities.transform', [$campaign, $entity]) }}" icon="fa-regular fa-arrows-rotate">
                    {{ __('entities/actions.convert') }}
                </x-dropdowns.item>
            @endif

            @can('update', $entity)
                @php $system = true; @endphp
                <x-dropdowns.item :link="route('entities.archive', [$campaign, $entity])" icon="fa-regular fa-archive">
                    @if ($entity->archived_at)
                        {{ __('entities/actions.unarchive.title') }}
                    @else
                        {{ __('entities/actions.archive.title') }}
                    @endif
                </x-dropdowns.item>
            @endcan
        @endauth

        @if ($system) <x-dropdowns.divider /> @endif


        <!-- Data/Export section -->
        <x-dropdowns.item link="{{ route('entities.html-export', [$campaign, $entity]) }}" icon="fa-regular fa-print">
            {{ __('crud.actions.print') }}
        </x-dropdowns.item>
        @auth
            <x-dropdowns.item link="{{ route('entities.json.export', [$campaign, $entity]) }}" icon="fa-regular fa-download">
                {{ __('entities/actions.json-export') }}
            </x-dropdowns.item>
            <x-dropdowns.item link="{{ route('entities.markdown.export', [$campaign, $entity]) }}" icon="fa-brands fa-markdown">
                {{ __('entities/actions.markdown-export') }}
            </x-dropdowns.item>
        @endauth


        @can('delete', $entity)
            <x-dropdowns.divider />
            @php
                $url = route('confirm-delete', [$campaign, 'route' => route('entities.destroy', [$campaign, $entity]), 'name' => $entity->name]);
            @endphp
            <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :data="['toggle' => 'dialog', 'target' => 'primary-dialog', 'url' => $url]" icon="trash">
                {{ __('crud.remove') }}
            </x-dropdowns.item>
        @endcan
    </div>
</div>

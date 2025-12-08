<?php
$allMembers = false;
$addEntityUrl = route('tags.entity-add', [$campaign, $entity->child]);
$datagridOptions = [];

if (!empty($onload)) {
    $routeOptions = [
        $campaign,
        $entity->child,
        'init' => 1,
    ];
    if (request()->get('m') == \App\Enums\Descendants::All->value || (!request()->has('m') && $campaign->defaultDescendantsMode() === \App\Enums\Descendants::All)) {
        $routeOptions['m'] = \App\Enums\Descendants::All;
        $allMembers = true;
    }
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('tags.children', $routeOptions)]
    ;
}

$all = $entity->child->allChildren()->count();
$direct = $entity->child->entities()->count();
?>
<div class="flex flex-col xl:flex-row gap-2 justify-between items-center">
    <h3 class="text-xl">
        {{ __('tags.show.tabs.children') }}
    </h3>
    <div class="gap-2 flex-wrap overflow-auto">
        <button data-url="{{ route('tags.transfer', [$campaign, $entity->child]) }}" data-toggle="dialog" class="btn2 btn-sm">
            <x-icon class="fa-regular fa-arrow-right"/>
            <span class="hidden xl:inline">{{ __('tags.transfer.transfer') }}</span>
        </button>

        @if (!$allMembers)
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.filtered', ['count' => $direct]) }}
                </span>
                <span class="xl:hidden">
                    {{ $direct  }}
                </span>
            </a>
        @endif

        @if ($all > 0)
            @can('update', $entity)
                <a href="{{ $addEntityUrl }}" class="btn2 btn-primary btn-sm"
                   data-toggle="dialog" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus" />
                    <span class="hidden xl:inline">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        @endif
    </div>
</div>
@if ($all === 0)
<div class="" id="tag-children">
    <x-box>
        <x-helper>
            <p>{{ __('tags.helpers.no_children') }}</p>
        </x-helper>
        @can('update', $entity)
            <a href="{{ $addEntityUrl }}" class="btn2 btn-primary btn-sm"
                data-toggle="dialog" data-url="{{ $addEntityUrl }}">
                <x-icon class="plus" />
                <span class="hidden xl:inline">{{ __('tags.children.actions.add') }}</span>
            </a>
        @endcan
    </x-box>
</div>
@else
<div class="overflow-x-auto" id="tag-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
@endif

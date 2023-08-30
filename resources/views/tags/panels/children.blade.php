<?php
/**
 * @var \App\Models\Tag $model
 */
$allMembers = true;
$addEntityUrl = route('tags.entity-add', [$campaign, $model]);
$datagridOptions = [];

if (!empty($onload)) {
    $routeOptions = [
        $campaign,
        $model,
        'init' => 1,
    ];
    if (request()->has('tag_id')) {
        $routeOptions['tag_id'] = (int) $model->id;
        $allMembers = true;
    }
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('tags.children', $routeOptions)]
    ;
}

$existing = $model->allChildren()->count();
?>
<div class="flex flex-col xl:flex-row gap-2 items-center">
    <h3 class="grow">
        {{ __('tags.show.tabs.children') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        <button data-url="{{ route('tags.transfer', [$campaign, $model->id]) }}" data-toggle="dialog" data-target="primary-dialog" class="btn2 btn-sm">
            <x-icon class="fa-solid fa-arrow-right"/>
            <span class="hidden md:inline">{{ __('tags.transfer.transfer') }}</span>
        </button>

        @if (request()->has('tag_id'))
            <a href="{{ route('tags.show', [$campaign, $model, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allChildren()->count() }})
            </a>
        @else
            <a href="{{ route('tags.show', [$campaign, $model, 'tag_id' => $model->id, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->entities()->count() }})
            </a>
        @endif

        @if ($existing > 0)
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn2 btn-primary btn-sm"
                   data-toggle="dialog" data-target="primary-dialog" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus"></x-icon>
                    <span class="hidden xl:inline">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        @endif
    </div>
</div>
@if ($existing === 0)
<div class="" id="tag-children">
    <x-box>
        <p class="help-block">
            {{ __('tags.helpers.no_children') }}
        </p>
        @can('update', $model)
            <a href="{{ $addEntityUrl }}" class="btn2 btn-primary btn-sm"
                data-toggle="dialog" data-target="primary-dialog" data-url="{{ $addEntityUrl }}">
                <x-icon class="plus"></x-icon> <span class="hidden lg:inline">{{ __('tags.children.actions.add') }}</span>
            </a>
        @endcan
    </x-box>
</div>
@else
<div class="" id="tag-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
@endif

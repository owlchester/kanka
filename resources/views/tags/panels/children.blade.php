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
<div class="flex gap-2 items-center mb-2">
    <h3 class="grow">
        {{ __('tags.show.tabs.children') }}
    </h3>
    <div>
        <a href="#" class="btn2 btn-sm btn-ghost" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>

        <a href="{{ route('tags.transfer', [$campaign, $model->id]) }}" class="btn2 btn-sm">
            <x-icon class="fa-solid fa-arrow-right"/>
            <span class="hidden md:inline">{{ __('tags.transfer.transfer') }}</span>
        </a>

        @if (request()->has('tag_id'))
            <a href="{{ route('tags.show', [$campaign, $model, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.all') }}</span>
                ({{ $model->allChildren()->count() }})
            </a>
        @else
            <a href="{{ route('tags.show', [$campaign, $model, 'tag_id' => $model->id, '#tag-children']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden md:inline">{{ __('crud.filters.direct') }}</span>
                ({{ $model->entities()->count() }})
            </a>
        @endif

        @if ($existing > 0)
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn2 btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus"></x-icon> <span class="hidden md:inline">{{ __('tags.children.actions.add') }}</span>
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
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus"></x-icon> <span class="hidden md:inline">{{ __('tags.children.actions.add') }}</span>
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


@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('tags.hints.children')
        ]
    ])
@endsection

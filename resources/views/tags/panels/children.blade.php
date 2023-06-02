<?php
/**
 * @var \App\Models\Tag $model
 */
$allMembers = true;
$addEntityUrl = route('tags.entity-add', $model);
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('tag_id')) {
    $datagridOptions['tag_id'] = (int) $model->id;
    $allMembers = true;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);

$existing = $model->allChildren()->count();
?>
<div class="flex gap-2 items-center mb-2">
    <h3 class="grow m-0">
        {{ __('tags.show.tabs.children') }}
    </h3>
    <div>
        <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>

        @if (request()->has('tag_id'))
            <a href="{{ route('tags.show', [$model, '#tag-children']) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allChildren()->count() }})
            </a>
        @else
            <a href="{{ route('tags.show', [$model, 'tag_id' => $model->id, '#tag-children']) }}" class="btn btn-default btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->entities()->count() }})
            </a>
        @endif

        @if ($existing > 0)
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus"></x-icon> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        @endif
    </div>
</div>
<div class="" id="tag-children">
    @if ($existing === 0)
        <x-box>
            <p class="help-block">
                {{ __('tags.helpers.no_children') }}
            </p>
            @can('update', $model)
                <a href="{{ $addEntityUrl }}" class="btn btn-primary"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ $addEntityUrl }}">
                    <x-icon class="plus"></x-icon> <span class="hidden-sm hidden-xs">{{ __('tags.children.actions.add') }}</span>
                </a>
            @endcan
        </x-box>
    @else
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('tags.children', $datagridOptions)])
    </div>
    @endif
</div>


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

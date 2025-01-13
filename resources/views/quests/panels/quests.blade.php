<?php
$datagridOptions = [
    $campaign,
    $entity->child,
    'init' => 1
];
if (request()->has('parent_id')) {
    $datagridOptions['parent_id'] = (int) request()->get('parent_id');
}
$datagridOptions = Datagrid::initOptions($datagridOptions);

$direct = $entity->child->children()->has('parent')->count();
$all = $entity->child->descendants()->has('parent')->count();
?>
<div class="flex gap-2 items-center">
    <h3 class="grow">
        {!! \App\Facades\Module::plural(config('entities.ids.quest'), __('entities.quests')) !!}
    </h3>
    <div class="flex-none flex gap-2 flex-wrap">
        <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question" /> {{ __('crud.actions.help') }}
        </a>
        @if (request()->has('parent_id'))
            <a href="{{ $entity->url() }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.filtered', ['count' => $direct]) }}
                </span>
                <span class="xl:hidden">
                    {{ $direct  }}
                </span>
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'parent_id' => $entity->child->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @endif
    </div>
</div>
<div class="quest-subquests" id="subquests">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('quests.quests', $datagridOptions)])
    </div>
</div>

@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('quests.hints.quests')
        ]
    ])
@endsection

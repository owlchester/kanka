<?php
/**
 * @var \App\Models\Family $model
 * @var \App\Models\Character $member
 */
$allMembers = true;
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('family_id')) {
    $allMembers = false;
    $datagridOptions['family_id'] = (int) $model->id;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>
<div class="flex gap-2 items-center mb-2">
    <h3 class="grow m-0">
        {{ __('families.show.tabs.members') }}
    </h3>
    <div>
        @if (!$allMembers)
            <a href="{{ route('families.show', [$model]) }}" class="btn2 btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allMembers()->count() }})
            </a>
        @else
            <a href="{{ route('families.show', [$model, 'family_id' => $model->id]) }}" class="btn2 btn-sm">
                <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->members()->count() }})
            </a>
        @endif
        @can('update', $model)
            <a href="{{ route('families.members.create', ['family' => $model->id]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('families.members.create', $model->id) }}">
                <x-icon class="plus"></x-icon> <span class="hidden-sm hidden-xs">{{ __('organisations.members.actions.add') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="family-members">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

<?php
/**
 * @var \App\Models\Family $model
 * @var \App\Models\Character $member
 */
$allMembers = true;
$datagridOptions = [
    $campaign,
    $model,
    'init' => 1
];
if (request()->has('family_id')) {
    $allMembers = false;
    $datagridOptions['family_id'] = (int) $model->id;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>
<div class="flex gap-2 items-center">
    <h3 class="grow ">
        {{ __('families.show.tabs.members') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ route('families.show', [$campaign, $model]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.all') }}</span> ({{ $model->allMembers()->count() }})
            </a>
        @else
            <a href="{{ route('families.show', [$campaign, $model, 'family_id' => $model->id]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden lg:inline">{{ __('crud.filters.direct') }}</span> ({{ $model->members()->count() }})
            </a>
        @endif
        @can('update', $model)
            <a href="{{ route('families.members.create', [$campaign, 'family' => $model->id]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('families.members.create', [$campaign, $model->id]) }}">
                <x-icon class="plus"></x-icon>
                <span class="hidden lg:inline">{{ __('organisations.members.actions.add') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="family-members">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

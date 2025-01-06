<?php
/**
 * @var \App\Models\Family $model
 * @var \App\Models\Character $member
 */
$allMembers = false;
$datagridOptions = [
    $campaign,
    $model,
    'init' => 1
];
if (request()->get('m') == \App\Enums\Descendants::All->value || (!request()->has('m') && $campaign->defaultDescendantsMode() === \App\Enums\Descendants::All)) {
    $allMembers = true;
    $datagridOptions['m'] = \App\Enums\Descendants::All;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>
<div class="flex gap-2 items-center">
    <h3 class="grow ">
        {{ __('families.show.tabs.members') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span> ({{ $model->allMembers()->count() }})
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span> ({{ $model->members()->count() }})
            </a>
        @endif
        @can('update', $model)
            <a href="{{ route('families.members.create', [$campaign, 'family' => $model->id]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('families.members.create', [$campaign, $model->id]) }}">
                <x-icon class="plus" />
                <span class="hidden xl:inline">{{ __('organisations.members.actions.add') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="family-members" class="overflow-auto">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

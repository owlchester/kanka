<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $member
 */
$allMembers = false;
$datagridOptions = [
    $campaign,
    $entity->child,
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
                <span class="hidden xl:inline">{{ __('crud.filters.all') }}</span> ({{ $entity->child->allMembers()->count() }})
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">{{ __('crud.filters.direct') }}</span> ({{ $entity->child->members()->count() }})
            </a>
        @endif
        @can('update', $entity)
            <a href="{{ route('families.members.create', [$campaign, 'family' => $entity->child]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('families.members.create', [$campaign, $entity->child]) }}">
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

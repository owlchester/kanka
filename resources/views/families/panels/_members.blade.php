<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 * @var \App\Models\Family $model
 * @var \App\Models\Character $member
 */
$allMembers = false;
$model = $entity->child;
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
$direct = number_format($model->members()->has('entity')->count());
$all = number_format($model->allMembers()->count());
?>
<div class="flex gap-2 items-center justify-between flex-wrap">
    <h3 class="members-title text-xl">
        {{ __('organisations.fields.members') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm"data-toggle="tooltip" data-title="{{ __('crud.filters.lists.paginated') }}">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm" data-toggle="tooltip" data-title="{{ __('crud.filters.lists.paginated') }}">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.filtered', ['count' => $direct]) }}
                </span>
                <span class="xl:hidden">
                    {{ $direct  }}
                </span>
            </a>
        @endif
        @can('update', $entity)
            <a href="{{ route('families.members.create', [$campaign, 'family' => $model]) }}" class="btn2 btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('families.members.create', [$campaign, $model]) }}">
                <x-icon class="plus" />
                <span class="hidden lg:inline">{{ __('organisations.members.actions.add_multiple') }}</span>
            </a>
        @endcan
    </div>
</div>
<div id="family-members" class="overflow-x-auto">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

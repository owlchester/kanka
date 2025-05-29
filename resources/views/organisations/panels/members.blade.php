<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$allMembers = false;
$datagridOptions = [
    $campaign,
    $entity->child->id,
    'init' => 1,
];
if (request()->get('m') == \App\Enums\Descendants::All->value || (!request()->has('m') && $campaign->defaultDescendantsMode() === \App\Enums\Descendants::All)) {
    $datagridOptions['m'] = \App\Enums\Descendants::All;
    $allMembers = true;
}
$datagridOptions = Datagrid::initOptions($datagridOptions);

$datagridCall = ['datagridUrl' => route('organisations.members', $datagridOptions)];
if (!empty($rows)) {
    $datagridCall = [];
}
$direct = $entity->child->members()->has('character')->count();
$all = $entity->child->allMembers()->has('character')->count();
?>
<div class="flex gap-2 items-center">
    <h3 class="grow">
        {{ __('organisations.fields.members') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All, '#organisation-members']) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @else
            <a href="{{ route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct, '#organisation-members']) }}" class="btn2 btn-sm">
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
            <a href="{{ route('organisations.organisation_members.create', [$campaign, 'organisation' => $entity->child->id]) }}" class="btn2 btn-primary btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('organisations.organisation_members.create', [$campaign, $entity->child->id]) }}">
                <x-icon class="plus" />
                <span class="hidden lg:inline">
                    {{ __('organisations.members.actions.add_multiple') }}
                </span>
            </a>
        @endcan
    </div>
</div>
<div id="organisation-members" class="overflow-auto">
    @if ($direct === 0 && !$allMembers)
        <x-box>
            <x-helper>
                <p>{{ __('organisations.members.helpers.' . ($allMembers ? 'all_' : null) . 'members') }}</p>
            </x-helper>
        </x-box>
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table', $datagridCall)
        </div>
    @endif

</div>

@section('modals')
    @parent
    <div id="datagrid-delete-forms"></div>
@endsection

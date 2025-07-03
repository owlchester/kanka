<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 * @var \App\Models\Organisation $model
 */
$allMembers = false;
$model = $model ?? $entity->child;
$datagridOptions = [
    $campaign,
    $model->id,
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
$direct = number_format($model->members()->has('character')->count());
$all = number_format($model->allMembers()->count());
?>
<div class="flex gap-2 items-center justify-between flex-wrap">
    <h3 class="members-title">
        {{ __('organisations.fields.members') }}
    </h3>
    <div class="flex gap-2 flex-wrap overflow-auto">
        @if (!$allMembers)
            <a href="{{ isset($from) && $from === 'overview' ? route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::All, '#organisation-members']) : route('organisations.members', [$campaign, $model, 'm' => \App\Enums\Descendants::All]) }}" class="btn2 btn-sm">
                <x-icon class="filter" />
                <span class="hidden xl:inline">
                    {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                </span>
                <span class="xl:hidden">
                    {{ $all }}
                </span>
            </a>
        @else
            <a href="{{ isset($from) && $from === 'overview' ? route('entities.show', [$campaign, $entity, 'm' => \App\Enums\Descendants::Direct, '#organisation-members']) : route('organisations.members', [$campaign, $model, 'm' => \App\Enums\Descendants::Direct]) }}" class="btn2 btn-sm">
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
            <a href="{{ route('organisations.organisation_members.create', [$campaign, 'organisation' => $model->id]) }}" class="btn2 btn-sm"
               data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('organisations.organisation_members.create', [$campaign, $model->id]) }}">
                <x-icon class="plus" />
                <span class="hidden lg:inline">
                    {{ __('organisations.members.actions.add_multiple') }}
                </span>
            </a>
        @endcan
    </div>
</div>
<div id="organisation-members" class="overflow-x-auto">
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

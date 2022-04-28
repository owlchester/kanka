<?php
/**
 * @var \App\Models\Organisation $model
 */
$allMembers = false;
$datagridOptions = [
    $model,
    'init' => 1
];
if (request()->has('all')) {
    $datagridOptions['all'] = 1;
    $allMembers = true;
}
$datagridCall = ['datagridUrl' => route('organisations.members', $datagridOptions)];
if (!empty($rows)) {
    $datagridCall = [];
}
$direct = $model->members()->has('character')->count();
$all = $model->allMembers()->has('character')->count();
?>
<div class="box box-solid" id="organisation-members">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('organisations.fields.members') }}</h3>

        <div class="box-tools">
            @if (!$allMembers)
                <a href="{{ route('organisations.show', [$model, 'all' => true, '#organisation-members']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i>
                    <span class="hidden-xs hidden-sm">
                        {{ __('crud.filters.lists.desktop.all', ['count' => $all]) }}
                    </span>
                    <span class="visible-xs-inline visible-sm-inline">
                        {{ __('crud.filters.lists.mobile.all', ['count' => $all]) }}
                    </span>
                </a>
            @else
                <a href="{{ route('organisations.show', [$model, '#organisation-members']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i>

                    <span class="hidden-xs hidden-sm">
                        {{ __('crud.filters.lists.desktop.filtered', ['count' => $direct]) }}
                    </span>
                    <span class="visible-xs-inline visible-sm-inline">
                        {{ __('crud.filters.lists.mobile.filtered', ['count' => $direct]) }}
                    </span>
                </a>
            @endif

            @can('member', $model)
                <a href="{{ route('organisations.organisation_members.create', ['organisation' => $model->id]) }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('organisations.organisation_members.create', $model->id) }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('organisations.members.actions.add') }}</span>
                </a>
            @endcan
        </div>
    </div>

    @if ($direct === 0)
        <div class="box-body">

            <p class="help-block">
                {{ __('organisations.members.helpers.' . ($allMembers ? 'all_' : null) . 'members') }}
            </p>
        </div>
    @else

        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table', $datagridCall)
        </div>
    @endif

</div>

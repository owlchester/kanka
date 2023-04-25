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
<div class="box box-solid" id="family-members">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('families.show.tabs.members') }}
        </h3>
        <div class="box-tools pull-right">
            @if (!$allMembers)
                <a href="{{ route('families.show', [$model]) }}" class="btn btn-default btn-sm">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allMembers()->count() }})
                </a>
            @else
                <a href="{{ route('families.show', [$model, 'family_id' => $model->id]) }}" class="btn btn-default btn-sm">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->members()->count() }})
                </a>
            @endif
            @can('update', $model)
                <a href="{{ route('families.character_family.create', ['family' => $model->id]) }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('families.character_family.create', $model->id) }}">
                    <i class="fa-solid fa-plus" aria-hidden="true"></i> <span class="hidden-sm hidden-xs">{{ __('organisations.members.actions.add') }}</span>
                </a>
            @endcan
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

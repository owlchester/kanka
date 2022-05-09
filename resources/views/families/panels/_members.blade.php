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
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('families.members', $datagridOptions)])
    </div>
</div>

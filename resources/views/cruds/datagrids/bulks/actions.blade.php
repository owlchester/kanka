<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

@php
$dropdownActions = [];
if (auth()->check() && auth()->user()->isAdmin()) {
    if (!isset($datagrid) || !$datagrid instanceof \App\Datagrids\NoneDatagrid) {
        $dropdownActions[] = '
        <a href="#" class="bulk-edit" data-toggle="modal" data-target="#bulk-edit.modal" data-bulk-action="batch">
            <i class="fa-solid fa-edit"></i> ' . __('crud.bulk.actions.edit') . '
        </a>';
    }
    if (!isset($datagrid) || $datagrid->hasBulkPermissions()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-permissions" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' . route('bulk.modal', ['view' => 'permissions']) . '" data-bulk-action="ajax">
                <i class="fa-solid fa-cog" aria-hidden="true"></i> ' .  __('crud.actions.bulk_permissions') . '
            </a>';
    }
    if (isset($bulk) && (!isset($bulkTemplates) || $bulkTemplates)) {
        $dropdownActions[] = '
            <a href="#" class="bulk-templates" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' . route('bulk.modal', ['view' => 'templates']) . '" data-bulk-action="ajax">
                <i class="fa-solid fa-th-list" aria-hidden="true"></i> ' . __('crud.actions.bulk_templates') . '
            </a>';
    }
    if (!isset($datagrid) || $datagrid->hasBulkTransform()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' .  route('bulk.modal', ['view' => 'transform', 'type' => $name]) . '" data-bulk-action="ajax">
                <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i> ' .  __('crud.actions.transform') . '
            </a>';
    }
    if (!isset($datagrid) || $datagrid->hasBulkCopy()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' .  route('bulk.modal', ['view' => 'copy_campaign', 'type' => $name]) . '" data-bulk-action="ajax">
                <i class="fa-regular fa-clone" aria-hidden="true"></i> ' .  __('crud.actions.copy_to_campaign') . '
            </a>';
    }
}
if (!isset($datagrid) || $datagrid->hasBulkPrint()) {
    $dropdownActions[] = '
    <a href="#" class="bulk-print">
        <i class="fa-solid fa-print"></i> ' . __('crud.actions.print') . '
    </a>';
}
if (auth()->check() && auth()->user()->can('delete', $model)) {
    $dropdownActions[] = 'divider';
    $dropdownActions[] = '
        <a href="#" class="text-red bulk-delete" data-toggle="modal" data-target="#bulk-delete.modal" data-bulk-action="delete">
            <i class="fa-solid fa-trash"></i> ' . __('crud.remove') . '
        </a>';
}

@endphp

@if (!empty($dropdownActions))
<div class="datagrid-bulk-actions">
    <div class="btn-group">
        <a class="dropdown-toggle btn btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right">
            {{ __('crud.bulk.buttons.label') }}
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
            @foreach ($dropdownActions as $dropdownAction)
                @if ($dropdownAction === 'divider')
                    <li class="divider"></li>
                    @continue
                @endif
                <li class="dropdown-item">
                    {!! $dropdownAction !!}
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endif


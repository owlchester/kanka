<?php /** @var \App\Datagrids\Actions\DatagridActions $datagridActions */?>

@php
$dropdownActions = [];
if (auth()->check() && auth()->user()->isAdmin()) {
    if ($datagridActions->hasBulkEditing()) {
        $dropdownActions[] = '
        <a href="#" class="bulk-edit" data-toggle="dialog" data-target="bulk-edit" data-bulk-action="batch">
            <i class="fa-solid fa-pencil" aria-hidden="true"></i> ' . __('crud.bulk.actions.edit') . '
        </a>';
    }
    if ($datagridActions->hasBulkPermissions()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-permissions" data-toggle="dialog" data-target="primary-dialog" data-url="' . route('bulk.modal', [$campaign, 'view' => 'permissions']) . '" data-bulk-action="ajax">
                <i class="fa-solid fa-cog" aria-hidden="true"></i> ' .  __('crud.bulk.actions.permissions') . '
            </a>';
    }
    if ($datagridActions->hasBulkTemplate() && $campaign->enabled('entity_attributes')) {
    //if (isset($bulk) && (!isset($bulkTemplates) || $bulkTemplates)) {
        $dropdownActions[] = '
            <a href="#" class="bulk-templates" data-toggle="dialog" data-target="primary-dialog" data-url="' . route('bulk.modal', [$campaign, 'view' => 'templates']) . '" data-bulk-action="ajax">
                <x-icon class="fa-solid fa-th-list"></x-icon> ' . __('crud.bulk.actions.templates') . '
            </a>';
    }
    if ($datagridActions->hasBulkTransform()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="dialog" data-target="primary-dialog" data-url="' .  route('bulk.modal', [$campaign, 'view' => 'transform', 'type' => $name]) . '" data-bulk-action="ajax">
                <x-icon class="fa-solid fa-exchange-alt"></x-icon> ' .  __('crud.actions.transform') . '
            </a>';
    }
    if ($datagridActions->hasBulkCopy()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="dialog" data-target="primary-dialog" data-url="' .  route('bulk.modal', [$campaign, 'view' => 'copy_campaign', 'type' => $name]) . '" data-bulk-action="ajax">
                <x-icon class="fa-regular fa-clone"></x-icon> ' .  __('crud.actions.copy_to_campaign') . '
            </a>';
    }
}
if ($datagridActions->hasBulkPrint()) {
    $dropdownActions[] = '
    <a href="#" class="bulk-print">
        <x-icon class="fa-solid fa-print"></x-icon>
        ' . __('crud.actions.print') . '
    </a>';
}
if (auth()->check() && auth()->user()->can('delete', $model)) {
    $dropdownActions[] = 'divider';
    $dropdownActions[] = '
        <a href="#" class="text-red bulk-delete" data-toggle="dialog" data-target="bulk-delete" data-bulk-action="delete">
            <x-icon class="fa-regular fa-trash"></x-icon>
            ' . __('crud.remove') . '
        </a>';
}

@endphp

@if (!empty($dropdownActions))
<div class="datagrid-bulk-actions inline-block">
    <div class="dropdown">
        <button class="dropdown-toggle btn2" data-toggle="dropdown" aria-expanded="false" data-placement="right">
            {{ __('crud.bulk.buttons.label') }}
            <span class="caret"></span>
        </button>
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


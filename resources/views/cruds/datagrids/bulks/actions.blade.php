<?php /** @var \App\Datagrids\Actions\DatagridActions $datagridActions */
    $campaign = CampaignLocalization::getCampaign();
?>

@php
$dropdownActions = [];
if (auth()->check() && auth()->user()->isAdmin()) {
    if ($datagridActions->hasBulkEditing()) {
        $dropdownActions[] = '
        <a href="#" class="bulk-edit" data-toggle="modal" data-target="#bulk-edit.modal" data-bulk-action="batch">
            <x-icon class="edit"></x-icon> ' . __('crud.bulk.actions.edit') . '
        </a>';
    }
    if ($datagridActions->hasBulkPermissions()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-permissions" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' . route('bulk.modal', ['view' => 'permissions']) . '" data-bulk-action="ajax">
                <x-icon class="cog"></x-icon> ' .  __('crud.bulk.actions.permissions') . '
            </a>';
    }
    if ($datagridActions->hasBulkTemplate() && $campaign->enabled('entity_attributes')) {
    //if (isset($bulk) && (!isset($bulkTemplates) || $bulkTemplates)) {
        $dropdownActions[] = '
            <a href="#" class="bulk-templates" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' . route('bulk.modal', ['view' => 'templates']) . '" data-bulk-action="ajax">
                <x-icon class="fa-solid fa-th-list"></x-icon> ' . __('crud.bulk.actions.templates') . '
            </a>';
    }
    if ($datagridActions->hasBulkTransform()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' .  route('bulk.modal', ['view' => 'transform', 'type' => $name]) . '" data-bulk-action="ajax">
                <x-icon class="fa-solid fa-exchange-alt"></x-icon> ' .  __('crud.actions.transform') . '
            </a>';
    }
    if ($datagridActions->hasBulkCopy()) {
        $dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="ajax-modal" data-target="#bulk-ajax" data-url="' .  route('bulk.modal', ['view' => 'copy_campaign', 'type' => $name]) . '" data-bulk-action="ajax">
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
        <a href="#" class="text-red bulk-delete" data-toggle="modal" data-target="#bulk-delete.modal" data-bulk-action="delete">
            <x-icon class="fa-regular fa-trash"></x-icon>
            ' . __('crud.remove') . '
        </a>';
}

@endphp

@if (!empty($dropdownActions))
<div class="datagrid-bulk-actions inline-block">
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


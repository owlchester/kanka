<?php /** @var \App\Datagrids\Actions\DatagridActions $datagridActions */?>

@php
$dropdownActions = [];
if (auth()->check() && auth()->user()->isAdmin()) {
    if ($datagridActions->hasBulkEditing()) {
        $dropdownActions[] = [
            'data' => ['target' => 'bulk-edit', 'bulk-action' => 'batch', 'toggle' => 'dialog'],
            'class' => 'bulk-edit',
            'icon' => '<i class="fa-solid fa-pencil" aria-hidden="true"></i>',
            'text' => __('crud.bulk.actions.edit')
        ];
        /*'
        <a href="#" class="bulk-edit" data-toggle="dialog" data-target="bulk-edit" data-bulk-action="batch">
             ' .  . '
        </a>';*/
    }
    if ($datagridActions->hasBulkPermissions()) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.permissions', [$campaign, 'entity_type' => $entityTypeId])],
            'class' => 'bulk-permissions',
            'icon' => '<x-icon class="fa-solid fa-lock"></x-icon>',
            'text' => __('crud.bulk.actions.permissions')
        ];
        $dropdownActions[] = '
            <a href="#" class="bulk-permissions" data-toggle="dialog" data-target="primary-dialog" data-url="' . route('bulk.permissions', [$campaign, 'entity_type' => $entityTypeId]) . '" data-bulk-action="ajax">
                <i class="fa-solid fa-cog" aria-hidden="true"></i> ' .  __('crud.bulk.actions.permissions') . '
            </a>';
    }
    if ($datagridActions->hasBulkTemplate() && $campaign->enabled('entity_attributes')) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.templates', [$campaign, 'entity_type' => $entityTypeId])],
            'class' => 'bulk-templates',
            'icon' => '<x-icon class="fa-solid fa-th-list"></x-icon>',
            'text' => __('crud.bulk.actions.templates')
        ];
    }
    if ($datagridActions->hasBulkTransform()) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.transform', [$campaign, 'entity_type' => $entityTypeId])],
            'class' => 'bulk-transform',
            'icon' => '<x-icon class="fa-solid fa-exchange-alt"></x-icon>',
            'text' => __('crud.actions.transform')
        ];
    }
    if ($datagridActions->hasBulkCopy()) {
        $dropdownActions[] = [
            'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.copy-to-campaign', [$campaign, 'entity_type' => $entityTypeId])],
            'class' => 'bulk-copy-campaign',
            'icon' => '<x-icon class="fa-regular fa-clone"></x-icon>',
            'text' => __('crud.actions.copy_to_campaign')
        ];
        /*$dropdownActions[] = '
            <a href="#" class="bulk-copy-campaign" data-toggle="dialog" data-target="primary-dialog" data-url="' .  route('bulk.copy-to-campaign', [$campaign, 'entity_type' => $entityTypeId]) . '" data-bulk-action="ajax">
                <x-icon class="fa-regular fa-clone"></x-icon> ' .  __('crud.actions.copy_to_campaign') . '
            </a>';*/
    }
}
if ($datagridActions->hasBulkPrint()) {
        $dropdownActions[] = [
            'class' => 'bulk-print',
            'icon' => '<x-icon class="fa-solid fa-print"></x-icon>',
            'text' => __('crud.actions.print')
        ];
    /*$dropdownActions[] = '
    <a href="#" class="bulk-print">
        <x-icon class="fa-solid fa-print"></x-icon>
        ' . __('crud.actions.print') . '
    </a>';*/
}
if (auth()->check() && auth()->user()->can('delete', $model)) {
    $dropdownActions[] = 'divider';
    if ($model instanceof \App\Models\Relation) {
        $dropdownActions[] = [
            'data' => ['target' => 'primary-dialo', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.delete-relations', [$campaign])],
            'class' => 'text-red',
            'icon' => '<x-icon class="fa-regular fa-trash"></x-icon>',
            'text' => __('crud.remove')
        ];
    } else {
        $dropdownActions[] = [
            'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'route' => route('bulk.delete', [$campaign, 'entity_type' => $entityTypeId])],
            'class' => 'text-red',
            'icon' => '<x-icon class="fa-regular fa-trash"></x-icon>',
            'text' => __('crud.remove')
        ];
    }
}

@endphp

@if (!empty($dropdownActions))
<div class="datagrid-bulk-actions inline-block">
    <div class="dropdown">
        <a role="button" tabindex="0" class="dropdown-toggle btn2" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="batch-actions-submenu" aria-label="Batch actions">
            {{ __('crud.bulk.buttons.label') }}
            <span class="caret"></span>
        </a>
        <div class="dropdown-menu" role="menu" id="batch-actions-submenu">
            @foreach ($dropdownActions as $dropdownAction)
                @if ($dropdownAction === 'divider')
                    <hr class="m-0" />
                    @continue
                @elseif (!is_array($dropdownAction))
                    @continue
                @endif
                    <x-dropdowns.item link="#" :css="$dropdownAction['class']" :data="$dropdownAction['data'] ?? []" >
                        {!! $dropdownAction['icon'] !!}
                        {!! $dropdownAction['text'] !!}
                    </x-dropdowns.item>
            @endforeach
        </div>
    </div>
</div>
@endif


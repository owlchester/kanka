<?php /** @var \App\Datagrids\Actions\DatagridActions $datagridActions */?>

@php
$dropdownActions = [];
if (auth()->check() && auth()->user()->isAdmin()) {
    if ($datagridActions->hasBulkEditing()) {
        $dropdownActions[] = [
            'data' => ['target' => 'bulk-edit', 'bulk-action' => 'batch', 'toggle' => 'dialog'],
            'class' => 'bulk-edit',
            'icon' => 'edit',
            'text' => __('crud.bulk.actions.edit')
        ];
    }
    if ($datagridActions->hasBulkPermissions()) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.permissions', [$campaign, 'entity_type' => $entityType->id])],
            'class' => 'bulk-permissions',
            'icon' => 'lock',
            'text' => __('crud.bulk.actions.permissions')
        ];
    }
    if ($datagridActions->hasBulkTemplate() && $campaign->enabled('entity_attributes')) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.templates', [$campaign, 'entity_type' => $entityType->id])],
            'class' => 'bulk-templates',
            'icon' => 'fa-regular fa-th-list',
            'text' => __('crud.bulk.actions.kits')
        ];
    }
    if ($datagridActions->hasBulkTransform()) {
        $dropdownActions[] = [
             'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.transform', [$campaign, 'entity_type' => $entityType->id])],
            'class' => 'bulk-transform',
            'icon' => 'fa-regular fa-arrows-rotate',
            'text' => __('entities/actions.convert')
        ];
    }
    if ($datagridActions->hasBulkCopy()) {
        $dropdownActions[] = [
            'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.copy-to-campaign', [$campaign, 'entity_type' => $entityType->id])],
            'class' => 'bulk-copy-campaign',
            'icon' => 'fa-regular fa-clone',
            'text' => __('crud.actions.copy_to_campaign')
        ];
    }
}
if ($datagridActions->hasBulkPrint()) {
        $dropdownActions[] = [
            'class' => 'bulk-print',
            'icon' => 'fa-regular fa-print',
            'text' => __('crud.actions.print')
        ];
}
if ($model instanceof \App\Models\Relation && auth()->user()->can('delete', $model)) {
    $dropdownActions[] = 'divider';
    $dropdownActions[] = [
        'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.delete-relations', [$campaign])],
        'class' => 'text-error hover:bg-error hover:text-error-content',
        'icon' => 'trash',
        'text' => __('crud.remove')
    ];
} elseif (isset($entityType) && auth()->check() && auth()->user()->can('deleteEntities', [$entityType, $campaign])) {
    $dropdownActions[] = 'divider';
    $dropdownActions[] = [
        'data' => ['target' => 'primary-dialog', 'bulk-action' => 'ajax', 'toggle' => 'dialog', 'url' => route('bulk.delete', [$campaign, 'entity_type' => $entityType->id])],
        'class' => 'text-error hover:bg-error hover:text-error-content',
        'icon' => 'trash',
        'text' => __('crud.remove')
    ];
}


@endphp

@if (!empty($dropdownActions))
<div class="datagrid-bulk-actions inline-block">
    <div class="dropdown">
        <a role="button" tabindex="0" class="btn2" data-dropdown aria-expanded="false" aria-haspopup="menu" aria-controls="batch-actions-submenu" aria-label="Batch actions">
            <x-icon class="fa-solid fa-caret-down" />
            {{ __('crud.bulk.buttons.label') }}
        </a>
        <div class="dropdown-menu hidden" role="menu" id="batch-actions-submenu">
            @foreach ($dropdownActions as $dropdownAction)
                @if ($dropdownAction === 'divider')
                    <x-dropdowns.divider />
                    @continue
                @elseif (!is_array($dropdownAction))
                    @continue
                @endif
                    <x-dropdowns.item link="#" :css="$dropdownAction['class']" :data="$dropdownAction['data'] ?? []" :icon="$dropdownAction['icon']">
                        {!! $dropdownAction['text'] !!}
                    </x-dropdowns.item>
            @endforeach
        </div>
    </div>
</div>
@endif


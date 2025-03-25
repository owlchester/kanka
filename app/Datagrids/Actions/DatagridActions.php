<?php

namespace App\Datagrids\Actions;

/**
 * Datagrids
 *
 * This abstract class controls parameters that are available to the datagrid bulk actions.
 * For example, to disable the bulk setting of permissions, set $bulkPermissions to false.
 * You can also add custom fields in the bulk delete modal by then testing on
 *
 * @if (isset($datagrid) && $datagrid instanceof \App\Datagrids\RelationDatagrid)
 */
abstract class DatagridActions
{
    /** @var bool */
    public $bulkPermissions = true;

    /** @var bool */
    public $bulkCopyToCampaign = true;

    /** @var bool */
    public $bulkTransform = true;

    /** @var bool */
    public $bulkPrint = true;

    /** @var bool */
    public $bulkTemplate = true;

    /** @var bool */
    public $bulkEditing = true;

    /**
     * Determine if the datagrid has bulk permissions.
     */
    public function hasBulkPermissions(): bool
    {
        return $this->bulkPermissions;
    }

    /**
     * Determine if the datagrid has bulk permissions.
     */
    public function hasBulkEditing(): bool
    {
        return $this->bulkEditing;
    }

    /**
     * Determine if the datagrid has bulk copy to campaign.
     */
    public function hasBulkCopy(): bool
    {
        return $this->bulkCopyToCampaign;
    }

    /**
     * Determine if the datagrid has bulk transforming entities.
     */
    public function hasBulkTransform(): bool
    {
        return $this->bulkTransform;
    }

    /**
     * Determine if the datagrid has bulk transforming entities.
     */
    public function hasBulkTemplate(): bool
    {
        return $this->bulkTemplate;
    }

    /**
     * Determine if the datagrid has bulk entity printing.
     */
    public function hasBulkPrint(): bool
    {
        return $this->bulkPrint;
    }
}

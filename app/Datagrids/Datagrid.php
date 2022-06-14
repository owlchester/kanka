<?php

namespace App\Datagrids;

/**
 * Datagrids
 *
 * This abstract class controls parameters that are available to the datagrid bulk actions.
 * For example, to disable the bulk setting of permissions, set $bulkPermissions to false.
 * You can also add custom fields in the bulk delete modal by then testing on
 * @if (isset($datagrid) && $datagrid instanceof \App\Datagrids\RelationDatagrid)
 */
abstract class Datagrid
{
    /** @var bool */
    public $bulkPermissions = true;

    /** @var bool */
    public $bulkCopyToCampaign = true;

     /** @var bool */
    public $bulkTransform = true;

    /** @var bool */
    public $bulkPrint = true;

    /**
     * Determine if the datagrid has bulk permissions.
     * @return bool
     */
    public function hasBulkPermissions(): bool
    {
        return $this->bulkPermissions;
    }

    /**
     * Determine if the datagrid has bulk copy to campaign.
     * @return bool
     */
    public function hasBulkCopy(): bool
    {
        return $this->bulkCopyToCampaign;
    }

    /**
     * Determine if the datagrid has bulk transforming entities.
     * @return bool
     */
    public function hasBulkTransform(): bool
    {
        return $this->bulkTransform;
    }

    /**
     * Determine if the datagrid has bulk entity printing.
     * @return bool
     */
    public function hasBulkPrint(): bool
    {
        return $this->bulkPrint;
    }
}

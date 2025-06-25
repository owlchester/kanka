<?php

namespace App\Datagrids;

/**
 * Datagrids
 *
 * This abstract class controls parameters that are available to the datagrid bulk actions.
 * For example, to disable the bulk setting of permissions, set $bulkPermissions to false.
 * You can also add custom fields in the bulk delete modal by then testing on
 */
abstract class Datagrid
{
    /** The entities can have permissions applied to them */
    public bool $bulkPermissions = true;

    /** The entities can be copied to other campaigns */
    public bool $bulkCopyToCampaign = true;

    /** The entities can be transformed */
    public bool $bulkTransform = true;

    /** The entities can be printed */
    public bool $bulkPrint = true;

    /** The entities can have templates applied to them */
    public bool $bulkTemplate = true;

    /**
     * Determine if the datagrid has bulk permissions.
     */
    public function hasBulkPermissions(): bool
    {
        return $this->bulkPermissions;
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

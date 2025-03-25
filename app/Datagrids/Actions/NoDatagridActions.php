<?php

namespace App\Datagrids\Actions;

/**
 * Catch all datagrid that disabled everything.
 * Used by dice results interface
 */
class NoDatagridActions extends DatagridActions
{
    public $bulkCopyToCampaign = false;

    public $bulkTransform = false;

    public $bulkPermissions = false;

    public $bulkPrint = false;

    public $bulkEditing = false;
}

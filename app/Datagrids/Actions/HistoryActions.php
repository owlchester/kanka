<?php

namespace App\Datagrids\Actions;

/**
 * Relations heavily restrict options because they aren't entities.
 */
class HistoryActions extends DatagridActions
{
    public $bulkPermissions = false;

    public $bulkCopyToCampaign = false;

    public $bulkPrint = false;

    public $bulkTransform = false;

    public $bulkTemplate = false;
}

<?php

namespace App\Datagrids\Actions;

/**
 * Menu links aren't real entities, meaning that they don't get a lot of actions
 */
class BookmarkDatagridActions extends DatagridActions
{
    public $bulkPermissions = false;

    public $bulkCopyToCampaign = false;

    public $bulkTransform = false;

    public $bulkPrint = false;

    public $bulkTemplate = false;
}

<?php

namespace App\Datagrids\Actions;

/**
 * Relations heavily restrict options because they aren't entities.
 */
class RelationDatagridActions extends DatagridActions
{
    public $bulkPermissions = false;
    public $bulkCopyToCampaign = false;
    public $bulkPrint = false;
    public $bulkTransform = false;
    public $bulkTemplate = false;


    /**
     * Action called for bulk delete on the model's policy
     * @return string
     */
    public function bulkDeleteActionName(): string
    {
        return 'bulkDelete';
    }
}

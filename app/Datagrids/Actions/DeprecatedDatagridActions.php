<?php

namespace App\Datagrids\Actions;

/**
 * For conversations, we don't want to bulk copy them to other campaigns, nor transform
 * them into other entity types.
 */
class DeprecatedDatagridActions extends DatagridActions
{
    public $bulkCopyToCampaign = false;

    public $bulkTransform = false;
}

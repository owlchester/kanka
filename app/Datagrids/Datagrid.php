<?php


namespace App\Datagrids;


abstract class Datagrid
{
    /** @var bool */
    public $bulkPermissions = true;

    /** @var bool */
    public $bulkCopyToCampaign = true;
}

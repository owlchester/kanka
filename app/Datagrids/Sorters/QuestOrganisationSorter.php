<?php

namespace App\Datagrids\Sorters;

/**
 * Class QuestOrganisationSorter
 * @package App\Datagrids\Sorters
 */
class QuestOrganisationSorter extends DatagridSorter
{
    public $default = 'organisation.name';

    /**
     * @var array
     */
    public $options = [
        'organisation.name' => 'organisations.fields.name',
        'role' => 'quests.fields.role',
        'organisation.type' => 'organisations.fields.type',
    ];
}

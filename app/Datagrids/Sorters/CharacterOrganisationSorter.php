<?php

namespace App\Datagrids\Sorters;

/**
 * Class CharacterOrganisationSorter
 * @package App\Datagrids\Sorters
 */
class CharacterOrganisationSorter extends DatagridSorter
{
    /**
     * @var string
     */
    public $default = 'role';

    /**
     * @var array
     */
    public $options = [
        'organisation.name' => 'organisations.fields.name',
        'organisation.type' => 'organisations.fields.type',
        'role' => 'organisations.members.fields.role',
    ];
}

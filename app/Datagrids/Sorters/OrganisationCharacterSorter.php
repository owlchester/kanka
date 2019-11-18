<?php

namespace App\Datagrids\Sorters;

/**
 * Class OrganisationCharacterSorter
 * @package App\Datagrids\Sorters
 */
class OrganisationCharacterSorter extends DatagridSorter
{
    public $default = 'character.name';
    /**
     * @var array
     */
    public $options = [
        'character.name' => 'characters.fields.name',
        'organisation.name' => 'organisations.fields.organisation',
        'role' => 'organisations.members.fields.role'
    ];
}

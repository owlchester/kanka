<?php

namespace App\Datagrids\Sorters;

/**
 * Class OrganisationOrganisationSorter
 * @package App\Datagrids\Sorters
 */
class OrganisationOrganisationSorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'organisations.fields.name',
        'type' => 'organisations.fields.name',
        'organisation.name' => 'organisations.fields.organisation',
    ];
}

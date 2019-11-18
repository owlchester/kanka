<?php

namespace App\Datagrids\Sorters;

/**
 * Class FamilyFamilySorter
 * @package App\Datagrids\Sorters
 */
class FamilyFamilySorter extends DatagridSorter
{
    /**
     * @var array
     */
    public $options = [
        'name' => 'families.fields.name',
        'family.name' => 'families.fields.family',
        'location.name' => 'items.fields.location'
    ];
}

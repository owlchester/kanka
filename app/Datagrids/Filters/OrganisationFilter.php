<?php

namespace App\Datagrids\Filters;

use App\Models\Organisation;

class OrganisationFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->location()
            ->add([
                'field' => 'organisation_id',
                'label' => trans('crud.fields.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find'),
                'placeholder' =>  trans('crud.placeholders.organisation'),
                'model' => Organisation::class,
            ])
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}

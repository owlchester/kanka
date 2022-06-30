<?php

namespace App\Datagrids\Filters;

use App\Models\Organisation;

class OrganisationFilter extends DatagridFilter
{
    /**
     * Filters available for organisations
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->location()
            ->add([
                'field' => 'organisation_id',
                'label' => __('crud.fields.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find'),
                'placeholder' =>  __('crud.placeholders.organisation'),
                'model' => Organisation::class,
            ])
            ->add('is_defunct')
            ->isPrivate()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}

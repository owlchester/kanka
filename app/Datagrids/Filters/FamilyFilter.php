<?php

namespace App\Datagrids\Filters;

use App\Models\Family;

class FamilyFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'family_id',
                'label' => trans('crud.fields.family'),
                'type' => 'select2',
                'route' => route('families.find'),
                'placeholder' =>  trans('crud.placeholders.family'),
                'model' => Family::class,
            ])
            ->location()
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}

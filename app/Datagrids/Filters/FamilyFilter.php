<?php

namespace App\Datagrids\Filters;

use App\Models\Family;
use App\Models\Character;

class FamilyFilter extends DatagridFilter
{
    /**
     * Filters available for families
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('type')
            ->add([
                'field' => 'family_id',
                'label' => __('crud.fields.family'),
                'type' => 'select2',
                'route' => route('families.find'),
                'placeholder' =>  __('crud.placeholders.family'),
                'model' => Family::class,
            ])
            ->location()
            ->add([
                'field' => 'member_id',
                'label' => __('crud.fields.character'),
                'type' => 'select2',
                'route' => route('characters.find'),
                'placeholder' =>  __('crud.placeholders.character'),
                'model' => Character::class,
            ])
            ->isPrivate()
            ->template()
            ->hasImage()
            ->hasEntityNotes()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}

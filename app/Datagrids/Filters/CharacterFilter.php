<?php

namespace App\Datagrids\Filters;

use App\Models\Family;
use App\Models\Organisation;
use App\Models\Race;

class CharacterFilter extends DatagridFilter
{
    /**
     * Filters available for characters
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('title')
            ->add([
                'field' => 'family',
                'label' => __('crud.fields.family'),
                'type' => 'select2',
                'route' => route('families.find'),
                'placeholder' =>  __('crud.placeholders.family'),
                'model' => Family::class,
                'withChildren' => true,
            ])
            ->location()
            ->add([
                'field' => 'race',
                'label' => __('crud.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
                'withChildren' => true,
            ])
            ->add([
                'field' => 'organisation_member',
                'label' => __('crud.fields.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find'),
                'placeholder' =>  __('crud.placeholders.organisation'),
                'model' => Organisation::class,
                'withChildren' => true,

            ])
            ->add('type')
            ->add('age')
            ->add('sex')
            ->add('pronouns')
            ->add('is_dead')
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

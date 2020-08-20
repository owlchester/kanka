<?php

namespace App\Datagrids\Filters;

use App\Models\Family;
use App\Models\Organisation;
use App\Models\Race;

class CharacterFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add('name')
            ->add('title')
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
                'field' => 'race_id',
                'label' => __('crud.fields.race'),
                'type' => 'select2',
                'route' => route('races.find'),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
            ])
            ->add([
                'field' => 'organisation_member',
                'label' => __('crud.fields.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find'),
                'placeholder' =>  __('crud.placeholders.organisation'),
                'model' => Organisation::class,
            ])
            ->add('type')
            ->add('age')
            ->add('sex')
            ->add('is_dead')
            ->isPrivate()
            ->hasImage()
            ->tags()
        ;
    }
}

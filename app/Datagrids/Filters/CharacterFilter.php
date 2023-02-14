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
    public function build()
    {
        $this
            ->add('name')
            ->add('title')
            ->add([
                'field' => 'family_id',
                'label' => __('entities.family'),
                'type' => 'select2',
                'route' => route('families.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.family'),
                'model' => Family::class,
                'withChildren' => true,
            ])
            ->location()
            ->add([
                'field' => 'race_id',
                'label' => __('entities.race'),
                'type' => 'select2',
                'route' => route('races.find', $this->campaign),
                'placeholder' =>  __('crud.placeholders.race'),
                'model' => Race::class,
                'withChildren' => true,
            ])
            ->add([
                'field' => 'member_id',
                'label' => __('entities.organisation'),
                'type' => 'select2',
                'route' => route('organisations.find', $this->campaign),
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
            ->hasPosts()
            ->hasEntityFiles()
            ->hasAttributes()
            ->tags()
            ->attributes()
        ;
    }
}

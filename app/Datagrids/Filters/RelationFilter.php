<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;
use App\Models\MiscModel;

class RelationFilter extends DatagridFilter
{
    /**
     * CharacterFilter constructor.
     */
    public function __construct()
    {
        $this
            ->add([
                'field' => 'owner_id',
                'label' => __('entities/relations.fields.owner'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations'),
                'placeholder' =>  __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add([
                'field' => 'target_id',
                'label' => __('entities/relations.fields.target'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations'),
                'placeholder' =>  __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add('relation')
            ->add('attitude')
            ->add('is_star')
        ;
    }
}

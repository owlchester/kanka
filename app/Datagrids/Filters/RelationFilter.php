<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;

class RelationFilter extends DatagridFilter
{
    /**
     * Filters available for relations
     */
    public function build()
    {
        $this
            ->add([
                'field' => 'owner_id',
                'label' => __('entities/relations.fields.owner'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations', $this->campaign),
                'placeholder' => __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add([
                'field' => 'target_id',
                'label' => __('entities/relations.fields.target'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations', $this->campaign),
                'placeholder' => __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add('relation')
            ->add('attitude')
            ->add('is_pinned');
    }
}

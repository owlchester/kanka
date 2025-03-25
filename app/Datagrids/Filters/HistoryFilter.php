<?php

namespace App\Datagrids\Filters;

use App\Models\Entity;

class HistoryFilter extends DatagridFilter
{
    /**
     * Filters available for relations
     */
    public function build()
    {
        $this
            ->add([
                'field' => 'entity_id',
                'label' => __('crud.fields.entity'),
                'type' => 'select2',
                'route' => route('search.entities-with-relations', $this->campaign),
                'placeholder' => __('crud.placeholders.entity'),
                'model' => Entity::class,
            ])
            ->add([
                'field' => 'created_by',
                'label' => __('crud.permissions.fields.member'),
                'type' => 'select2',
                'route' => route('users.find', $this->campaign),
                'placeholder' => __('crud.permissions.fields.member'),
                'model' => Entity::class,
            ]);
    }
}

<?php

namespace App\Renderers\Layouts\Ability;

use App\Models\EntityAbility;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Entity extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        return [
            'image' => [
                'render' => Standard::IMAGE,
            ],
            'name' => [
                'key' => 'name',
                'label' => 'crud.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'crud.fields.entity_type',
                'render' => function (EntityAbility $model) {
                    return $model->entity->entityType->name();
                },
            ],
            'visibility' => [
                'label' => 'crud.fields.visibility',
                'render' => Standard::VISIBILITY,
            ],
            'tags' => [
                'render' => Standard::TAGS,
                'with' => 'entity',
            ],
        ];
    }

    /**
     * Available actions on each row
     */
    public function actions(): array
    {
        return [
            'abilities.entities.actions.delete',
        ];
    }
}

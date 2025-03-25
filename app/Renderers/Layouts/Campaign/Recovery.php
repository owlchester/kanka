<?php

namespace App\Renderers\Layouts\Campaign;

use App\Facades\Avatar;
use App\Renderers\Layouts\Layout;

class Recovery extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'class' => 'avatar w-14',
                'label' => '',
                'render' => function ($entity) {
                    $child = $entity->child()->withTrashed()->first();
                    if (empty($child)) {
                        return '';
                    }

                    return '<div style="background-image: url(' . Avatar::entity($entity)->size(40)->thumbnail() . ');" class="entity-image w-10 h-10"></div>';
                },
            ],
            'name' => [
                'key' => 'name',
                'label' => 'crud.fields.name',
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'crud.fields.entity_type',
                'render' => function ($entity) {
                    return $entity->entityType->singular();
                },
            ],
            'deleted' => [
                'key' => 'deleted_at',
                'label' => 'campaigns/recovery.fields.deleted',
                'class' => self::ONLY_DESKTOP,
                'render' => function ($model) {
                    return $model->deleted_at->diffForHumans();
                },
            ],
        ];

        return $columns;
    }

    /**
     * Bulk actions
     */
    public function bulks(): array
    {
        return [
            [
                'action' => 'recover',
                'label' => 'campaigns/recovery.actions.recover',
                'icon' => 'fa-solid fa-history',
                'can' => 'campaign:recover',
            ],
        ];
    }
}

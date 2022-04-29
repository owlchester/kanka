<?php

namespace App\Renderers\Layouts\Entity;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Relation extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'relation' => [
                'key' => 'relation',
                'label' => 'entities/relations.fields.relation',
                'render' => function ($relation) {
                    $icon = '';
                    if ($relation->is_star) {
                        $icon = '<i class="fas fa-star" title="' . __('crud.fields.is_star') . '" data-toggle="tooltip"></i> ';
                    }

                    return $icon . $relation->relation;
                }
            ],
            'target' => [
                'key' => 'target.name',
                'label' => 'crud.relations.fields.name',
                'render' => function ($relation) {
                    $icon = '';
                    if ($relation->target->is_private) {
                        $icon = '<i class="fa-solid fa-lock" title="' . __('crud.is_private') . '" data-toggle="tooltip"></i> ';
                    }
                    return $icon . $relation->target->tooltipedLink();
                }
            ],
            'location' => [
                'label' => 'crud.fields.location',
                'render' => function ($model) {
                    if (!$model->target->location) {
                        return null;
                    }
                    return $model->target->location->tooltipedLink();
                },
            ],
            'attitude' => [
                'key' => 'attitude',
                'label' => 'entities/relations.fields.attitude',
                'class' => 'hidden-xs hidden-sm',
                'render' => function ($relation) {
                    $icon = '';
                    if (!empty($relation->colour)) {
                        $icon = '<div class="label-tag-bubble" style="background-color: ' . $relation->colour . '; "></div> ';
                    }
                    return $icon . $relation->attitude;
                }
            ],
            'visibility' => [
                'label' => '',
                'render' => Standard::VISIBILITY
            ]
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     * @return array
     */
    public function actions(): array
    {
        return [
            self::ACTION_EDIT_AJAX,
            self::ACTION_DELETE
        ];
    }
}

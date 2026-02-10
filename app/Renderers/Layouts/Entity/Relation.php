<?php

namespace App\Renderers\Layouts\Entity;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Relation extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'relation' => [
                'key' => 'relation',
                'label' => 'entities/relations.fields.role',
                'render' => function ($relation) {
                    $icon = '';
                    if ($relation->isPinned()) {
                        $icon = '<i class="fa-regular fa-star" data-title="' . __('crud.fields.is_star') . '" data-toggle="tooltip"></i> ';
                    }

                    return $icon . $relation->relation;
                },
            ],
            'target' => [
                'key' => 'target.name',
                'label' => 'crud.fields.entity',
                'render' => Standard::ENTITYLINK,
                'with' => 'target',
            ],
            'location' => [
                'label' => 'entities.location',
                'render' => Standard::LOCATION,
                'with' => 'target',
            ],
            'attitude' => [
                'key' => 'attitude',
                'label' => 'entities/relations.fields.attitude',
                'class' => 'hidden-xs hidden-sm',
                'render' => function ($relation) {
                    /** @var \App\Models\Relation $relation */
                    $icon = '';
                    if (empty($relation->colour)) {
                        return $relation->attitude;
                    }
                    $html = '<div class="flex items-center gap-1">';
                    $icon = '<div class="flex-0 inline-block p-1 rounded-2xl w-5 h-5" style="background-color: ' . $relation->colour . '; "></div>';

                    return $html . $icon . '<div class="grow">' . $relation->attitude . '</div></div>';
                },
            ],
            'visibility' => [
                'label' => '',
                'render' => Standard::VISIBILITY,
            ],
        ];

        return $columns;
    }

    /**
     * Available actions on each row
     */
    public function actions(): array
    {
        return [
            self::ACTION_EDIT_DIALOG,
            self::ACTION_DELETE,
        ];
    }
}

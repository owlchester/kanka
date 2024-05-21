<?php

namespace App\Renderers\Layouts\Organisation;

use App\Facades\Module;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Organisation extends Layout
{
    /**
     * Available columns
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'image' => [
                'render' => Standard::IMAGE
            ],
            'name' => [
                'key' => 'name',
                'label' => Module::singular(config('entities.ids.organisation'), 'entities.organisation'),
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'crud.fields.type',
            ],
            'organisation' => [
                'key' => 'parent.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->parent) {
                        return null;
                    }
                    $defunctIcon = null;
                    if ($model->parent->is_defunct) {
                        $defunctIcon = ' <i class="fa-solid fa-shop-slash" aria-hidden="true" data-title="' . __('organisations.fields.is_defunct') . '"></i>';
                    }
                    return $model->parent->tooltipedLink() . $defunctIcon;
                },
                'visible' => function () {
                    return !request()->has('parent_id');
                }
            ],
            'tags' => [
                'render' => Standard::TAGS
            ]
        ];

        return $columns;
    }
}

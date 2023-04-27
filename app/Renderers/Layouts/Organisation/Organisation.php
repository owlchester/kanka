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
                'key' => 'organisation.name',
                'label' => 'crud.fields.parent',
                'render' => function ($model) {
                    if (!$model->organisation) {
                        return null;
                    }
                    $defunctIcon = null;
                    if ($model->organisation->is_defunct) {
                        $defunctIcon = ' <i class="fa-solid fa-shop-slash" title="' . __('organisations.fields.is_defunct') . '"></i>';
                    }
                    return $model->organisation->tooltipedLink() . $defunctIcon;
                },
            ],
        ];

        return $columns;
    }
}

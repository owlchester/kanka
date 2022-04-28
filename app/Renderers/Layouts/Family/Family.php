<?php

namespace App\Renderers\Layouts\Family;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Family extends Layout
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
            'family_id' => [
                'key' => 'name',
                'label' => 'families.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'families.fields.type',
            ],
            'location' => [
                'key' => 'location.name',
                'label' => 'families.fields.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
            ],
            'family' => [
                'key' => 'family.name',
                'label' => 'families.fields.family',
                'render' => function ($model) {
                    if (!$model->family) {
                        return null;
                    }
                    return $model->family->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}

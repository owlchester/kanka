<?php

namespace App\Renderers\Layouts\Organisation;

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
                'label' => 'entities.organisation',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'organisations.fields.type',
            ],
            'organisation' => [
                'key' => 'organisation.name',
                'label' => 'organisations.fields.organisation',
                'render' => function ($model) {
                    if (!$model->organisation) {
                        return null;
                    }
                    return $model->organisation->tooltipedLink();
                },
            ],
        ];

        return $columns;
    }
}

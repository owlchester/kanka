<?php

namespace App\Renderers\Layouts\Location;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Location extends Layout
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
            'location_id' => [
                'key' => 'name',
                'label' => 'locations.fields.name',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type',
                'label' => 'characters.fields.type',
                'render' => function ($model) {
                    return $model->type;
                },
            ],
            'location' => [
                'key' => 'location.name',
                'label' => 'locations.fields.location',
                'render' => function ($model) {
                    if (!$model->location) {
                        return null;
                    }
                    return $model->location->tooltipedLink();
                },
                'visible' => function () {
                    return !request()->has('parent_location_id');
                }
            ],
        ];

        return $columns;
    }
}

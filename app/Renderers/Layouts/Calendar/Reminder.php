<?php

namespace App\Renderers\Layouts\Calendar;

use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Reminder extends Layout
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
            'entity' => [
                'key' => 'entity.name',
                'label' => 'crud.fields.entity',
                'render' => Standard::ENTITYLINK,
            ],
            'type' => [
                'key' => 'type_id',
                'label' => 'crud.fields.entity_type',
                'render' => function ($model) {
                    return __('entities.' . $model->entity->pluralType());
                }
            ],
            'date' => [
                'key' => 'date',
                'label' => 'events.fields.date',
                'render' => 'readableDate()',
            ],
            'length' => [
                'key' => 'length',
                'label' => 'calendars.fields.length',
                'render' => 'readableLength()',
            ],
            'comment' => [
                'label' => '',
                'render' => function ($model) {
                    if (empty($model->comment)) {
                        return '';
                    }
                    return '<i class="fa-solid fa-comment" title="' . $model->comment . '" data-toggle="tooltip"></i>';
                }
            ],
            'recurring' => [
                'label' => '',
                'render' => function ($model) {
                    if (empty($model->is_recurring)) {
                        return '';
                    }
                    return '<i class="fa-solid fa-refresh" title="' . __('calendars.fields.is_recurring') . '" data-toggle="tooltip"></i>';
                }
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
            self::ACTION_EDIT_AJAX,
            self::ACTION_DELETE
        ];
    }
}

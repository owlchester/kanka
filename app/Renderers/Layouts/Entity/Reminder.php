<?php

namespace App\Renderers\Layouts\Entity;

use App\Models\EntityEvent;
use App\Renderers\Layouts\Columns\Standard;
use App\Renderers\Layouts\Layout;

class Reminder extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'calendar' => [
                'key' => 'calendar.name',
                'label' => 'entities.calendar',
                'render' => Standard::ENTITYLINK,
                'with' => 'calendar',
            ],
            'date' => [
                'key' => 'date',
                'label' => 'events.fields.date',
                'render' => function (EntityEvent $reminder) {
                    $params = '?year=' . $reminder->year . '&month=' . $reminder->month;

                    return '<a href="' . $reminder->calendar->getLink() . $params . '">' . $reminder->readableDate() . '</a>';
                },
            ],
            'length' => [
                'key' => 'length',
                'label' => 'calendars.fields.length',
                'render' => function (EntityEvent $reminder) {
                    return trans_choice('calendars.fields.length_days', $reminder->length, ['count' => $reminder->length]);
                },
            ],
            'comment' => [
                'key' => 'comment',
                'label' => 'calendars.fields.comment',
                'render' => function (EntityEvent $reminder) {
                    return $reminder->comment;
                },
            ],
            'recurring' => [
                'label' => 'calendars.fields.is_recurring',
                'render' => function (EntityEvent $reminder) {
                    if ($reminder->is_recurring) {
                        return '<i class="fa-solid fa-redo" data-title="' . __('calendars.fields.is_recurring') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
                    }
                    if ($reminder->isBirth()) {
                        return '<i class="fa-solid fa-birthday-cake" data-title="' . __('entities/events.types.birth') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
                    } elseif ($reminder->isDeath()) {
                        return '<i class="fa-solid fa-skull" data-title="' . __('entities/events.types.death') . '" data-toggle="tooltip" aria-hidden="true"></i>';
                    } elseif ($reminder->isFounded()) {
                        return '<i class="fa-solid fa-building-columns" data-title="' . __('entities/events.types.founded') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
                    }
                },
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

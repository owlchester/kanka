<?php

namespace App\Renderers\Layouts\Entity;

use App\Models\Reminder as Model;
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
                'render' => function (Model $reminder) {
                    $params = '?year=' . $reminder->year . '&month=' . $reminder->month;

                    return '<a href="' . $reminder->calendar->getLink() . $params . '" class="text-link">' . $reminder->readableDate() . '</a>';
                },
            ],
            'length' => [
                'key' => 'length',
                'label' => 'calendars.fields.length',
                'render' => function (Model $reminder) {
                    return trans_choice('calendars.fields.length_days', $reminder->length, ['count' => $reminder->length]);
                },
            ],
            'comment' => [
                'key' => 'comment',
                'label' => '<i class="fa-regular fa-comments" data-title="' . __('calendars.fields.comment') . '" data-toggle="tooltip" aria-hidden="true"></i><span class="sr-only">' . __('calendars.fields.comment') . '</span>',
                'render' => function (Model $reminder) {
                    return '<p class="text-xs text-neutral-content">' . $reminder->comment . '</p>';
                },
            ],
            'recurring' => [
                'label' => '<i class="fa-regular fa-arrows-rotate" data-title="' . __('calendars.fields.is_recurring') . '" data-toggle="tooltip" aria-hidden="true"></i><span class="sr-only">' . __('calendars.fields.is_recurring') . '</span>',
                'render' => function (Model $reminder) {
                    if ($reminder->is_recurring) {
                        return '<i class="fa-regular fa-redo" data-title="' . __('calendars.fields.is_recurring') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
                    }
                    if ($reminder->isBirth()) {
                        return '<i class="fa-regular fa-birthday-cake" data-title="' . __('entities/events.types.birth') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
                    } elseif ($reminder->isDeath()) {
                        return '<i class="fa-regular fa-skull" data-title="' . __('entities/events.types.death') . '" data-toggle="tooltip" aria-hidden="true"></i>';
                    } elseif ($reminder->isFounded()) {
                        return '<i class="fa-regular fa-building-columns" data-title="' . __('entities/events.types.founded') . '" data-toggle="tooltip" aria-hidden="true" ></i>';
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

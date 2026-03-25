<?php

namespace App\Renderers\Layouts\Calendar;

use App\Models\CalendarEra;
use App\Renderers\Layouts\Layout;

class Era extends Layout
{
    /**
     * Available columns
     *
     * @return array[]
     */
    public function columns(): array
    {
        $columns = [
            'name' => [
                'key' => 'name',
                'label' => __('crud.fields.name'),
                'render' => function (CalendarEra $model) {
                    return '<a href="' . $model->getLink() . '" class="text-link">' . e($model->name) . '</a>';
                },
            ],
            'start_year' => [
                'key' => 'start_year',
                'label' => __('calendars/eras.fields.start_date'),
                'render' => function (CalendarEra $model) {
                    return $model->startDay() . '/' . $model->startMonth() . '/' . $model->start_year;
                },
            ],
            'end_year' => [
                'key' => 'end_year',
                'label' => __('calendars/eras.fields.end_date'),
                'render' => function (CalendarEra $model) {
                    if (! $model->hasEndDate()) {
                        return '<em>' . __('quests.status.ongoing') . '</em>';
                    }

                    return $model->endDay() . '/' . $model->endMonth() . '/' . $model->end_year;
                },
            ],
            'show_era_dates' => [
                'key' => 'show_era_dates',
                'label' => __('calendars/eras.fields.show_era_dates'),
                'render' => function (CalendarEra $model) {
                    if ($model->show_era_dates) {
                        return '<i class="fa-regular fa-check-circle" aria-hidden="true"></i>';
                    }

                    return '';
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
            self::ACTION_EDIT,
            self::ACTION_DELETE,
        ];
    }

    public function bulks(): array
    {
        return [
            self::ACTION_DELETE,
        ];
    }
}

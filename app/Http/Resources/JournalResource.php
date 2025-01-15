<?php

namespace App\Http\Resources;

use App\Models\Journal;

class JournalResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var Journal $model */
        $model = $this->resource;
        return $this->entity([
            'journal_id' => $model->journal_id,
            'date' => $model->date,
            'author' => $model->author,
            'author_id' => $model->author_id,
            'calendar_id' => $model->entity->calendarDate?->calendar_id,
            'calendar_year' => $model->entity->calendarDate?->year,
            'calendar_month' => $model->entity->calendarDate?->month,
            'calendar_day' => $model->entity->calendarDate?->day,
        ]);
    }
}

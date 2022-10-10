<?php

namespace App\Http\Resources;

use App\Models\Journal;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'type' => $model->type,
            'author_id' => $model->author,
            'calendar_id' => $model->calendar_id,
            'calendar_year' => $model->calendar_year,
            'calendar_month' => $model->calendar_month,
            'calendar_day' => $model->calendar_day,
        ]);
    }
}

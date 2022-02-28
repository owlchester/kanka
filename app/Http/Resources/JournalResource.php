<?php

namespace App\Http\Resources;

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
        return $this->entity([
            'journal_id' => $this->journal_id,
            'date' => $this->date,
            'type' => $this->type,
            'author_id' => $this->author,
            'calendar_id' => $this->calendar_id,
            'calendar_year' => $this->calendar_year,
            'calendar_month' => $this->calendar_month,
            'calendar_day' => $this->calendar_day,
        ]);
    }
}

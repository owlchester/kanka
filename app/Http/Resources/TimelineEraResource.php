<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use App\Models\TimelineEra;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineEraResource extends EntityResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var TimelineEra $era */
        $era = $this->resource;
        return [
            'id' => $era->id,
            'name' => $era->name,
            'abbreviation' => $era->abbreviation,
            'start_year' => $era->start_year,
            'entry' => $era->entry,
            'entry_parsed' => Mentions::mapAny($era),
            'end_year' => $era->end_year,
            'elements' => TimelineElementResource::collection($era->elements)
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use App\Models\TimelineEra;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineEraResource extends JsonResource
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
            'entry_parsed' => $era->parsedEntry(),
            'end_year' => $era->end_year,
            'elements' => $era->elements ? TimelineElementResource::collection($era->elements) : [],
            'is_collapsed' => $era->collapsed(),
            'position' => $era->position,
        ];
    }
}

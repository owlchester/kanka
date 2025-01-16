<?php

namespace App\Http\Resources;

use App\Models\EntityType;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var EntityType $this */
        return [
            // @phpstan-ignore-next-line
            'id' => $this->id,
            // @phpstan-ignore-next-line
            'code' => $this->code,
            'singular' => $this->singular,
            'plural' => $this->plural,
            'icon' => $this->icon,
            'is_special' => $this->isSpecial(),
            'is_enabled' => $this->isEnabled(),
        ];
    }
}

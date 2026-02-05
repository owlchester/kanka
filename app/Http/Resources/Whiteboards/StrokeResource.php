<?php

namespace App\Http\Resources\Whiteboards;

use App\Models\WhiteboardStroke;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StrokeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var WhiteboardStroke $stroke */
        $stroke = $this->resource;

        return [
            'id' => $stroke->id,
            'fill' => $stroke->color,
            'points' => $stroke->unpack(),
            'strokeWidth' => $stroke->width,
        ];
    }
}

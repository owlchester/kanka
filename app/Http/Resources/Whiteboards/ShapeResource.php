<?php

namespace App\Http\Resources\Whiteboards;

use App\Facades\Avatar;
use App\Models\Entity;
use App\Models\Image;
use App\Models\WhiteboardShape;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ShapeResource extends JsonResource
{
    const SCALE = 1000;
    const ROT_SCALE = 1_000_000;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var WhiteboardShape $shape */
        $shape = $this;
        $campaign = $shape->whiteboard->campaign;
        $whiteboard = $shape->whiteboard;

        $data = [
            'id'       => $shape->id,
            'type'     => $shape->type,
            'x'        => $shape->x / self::SCALE,
            'y'        => $shape->y / self::SCALE,
            'width'    => $shape->width / self::SCALE,
            'height'   => $shape->height / self::SCALE,
            'rotation' => $shape->rotation / self::ROT_SCALE,
            'is_locked'   => (bool) $shape->is_locked,
            'z_index'  => $shape->z_index,
            'fill' => Arr::get($shape->shape, 'fill'),


            'urls' => [
                'edit' => route('whiteboards.shapes.update', [$campaign, $whiteboard, $shape]),
                'delete' =>route('whiteboards.shapes.delete', [$campaign, $whiteboard, $shape]),
                'stroke' => route('whiteboards.shapes.stroke', [$campaign, $whiteboard, $shape]),
            ]
        ];

        if ($shape->isCircle()) {
            $data['radius'] = $shape->width / self::SCALE / 2;
        }
        if ($shape->isText()) {
            $data['text'] = Arr::get($shape->shape, 'text');
            $data['fontSize'] = Arr::get($shape->shape, 'fontSize');
        }
        if ($shape->isImage()) {
            $data['uuid'] = Arr::get($shape->shape, 'uuid');
        }
        if ($shape->isEntity()) {
            $data['entity'] = Arr::get($shape->shape, 'entity_id');
        }
        if ($shape->isDrawing()) {
            $data['children'] = StrokeResource::collection($shape->strokes);
        }

        return $data;
    }

    protected function strokes(): array
    {

    }

}

<?php

namespace App\Observers;

use App\Models\WhiteboardShape;

class WhiteboardShapeObserver
{
    const SCALE = 1000;
    public function saving(WhiteboardShape $shape)
    {
        if (!empty($shape->scale_x)) {
            $shape->width *= $shape->scale_x;
            unset($shape->scale_x);
        }

        if (!empty($shape->scale_y)) {
            $shape->height *= $shape->scale_y;
            unset($shape->scale_y);
        }

        if ($shape->isDirty('x')) {
            $shape->x = (int)round($shape->x * self::SCALE);
        }
        if ($shape->isDirty('y')) {
            $shape->y = (int)round($shape->y * self::SCALE);
        }
        if ($shape->isDirty('width')) {
            $shape->width = (int)round($shape->width * self::SCALE);
        }
        if ($shape->isDirty('height')) {
            $shape->height = (int)round($shape->height * self::SCALE);
        }

        if ($shape->isDirty('rotation')) {
            $shape->rotation = (int)round($shape->rotation * 1_000_000);
        }
    }
}

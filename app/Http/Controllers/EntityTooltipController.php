<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Response;

class EntityTooltipController extends Controller
{
    /**
     *
     */
    public function show(Entity $entity)
    {
        return Response::json([
            $entity->fullTooltip()
        ]);
    }
}

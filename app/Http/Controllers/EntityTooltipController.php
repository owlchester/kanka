<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Support\Facades\Auth;
use Response;

class EntityTooltipController extends Controller
{
    /**
     *
     */
    public function show(Entity $entity)
    {
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeForGuest('read', $entity->child);
        }

        return Response::json([
            $entity->fullTooltip()
        ]);
    }
}

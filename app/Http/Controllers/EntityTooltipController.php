<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;
use Response;

class EntityTooltipController extends Controller
{
    use GuestAuthTrait;

    /**
     *
     */
    public function show(Entity $entity)
    {
        if (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest('read', $entity->child);
        }

        return Response::json([
            $entity->fullTooltip()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
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
        if (!$entity->child) {
            abort('403');
        } elseif (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $campaign = CampaignLocalization::getCampaign();
        $tooltip = view('entities.components.tooltip')
            ->with('entity', $entity)
            ->with('tags', $entity->tags)
            ->with('campaign', $campaign)
            ->render();

        return Response::json([
            $tooltip
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Facades\CampaignLocalization;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class EntityTooltipController extends Controller
{
    use GuestAuthTrait;

    /**
     * Prepare and show an entity's tooltip
     */
    public function show(Entity $entity)
    {
        if (empty($entity->child)) {
            abort(403);
        } elseif (Auth::check()) {
            $this->authorize('view', $entity->child);
        } else {
            $this->authorizeEntityForGuest(\App\Models\CampaignPermission::ACTION_READ, $entity->child);
        }

        $tags = $entity->tagsWithEntity();
        $tagClasses = [];
        foreach ($tags as $tag) {
            $tagClasses[] = 'kanka-tag-' . $tag->id;
            $tagClasses[] = 'kanka-tag-' . $tag->slug;
        }

        $campaign = CampaignLocalization::getCampaign();
        $tooltip = view('entities.components.tooltip')
            ->with('entity', $entity)
            ->with('tags', $entity->tagsWithEntity())
            ->with('tagClasses', $tagClasses)
            ->with('campaign', $campaign)
            ->render();

        return response()->json([
            $tooltip
        ]);
    }
}

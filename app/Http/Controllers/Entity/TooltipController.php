<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;
use Illuminate\Support\Facades\Auth;

class TooltipController extends Controller
{
    use GuestAuthTrait;

    /**
     * Prepare and show an entity's tooltip
     */
    public function show(Campaign $campaign, Entity $entity)
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

        $tooltip = view('entities.components.tooltip')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('tags', $entity->tagsWithEntity())
            ->with('tagClasses', $tagClasses)
            ->render();

        return response()->json([
            $tooltip
        ]);
    }
}

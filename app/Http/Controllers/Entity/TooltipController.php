<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Traits\GuestAuthTrait;

class TooltipController extends Controller
{
    use GuestAuthTrait;

    /**
     * Prepare and show an entity's tooltip
     */
    public function show(Campaign $campaign, Entity $entity)
    {
        $this->authEntityView($entity);

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

<?php

namespace App\Http\Controllers\Entity;

use App\Facades\Avatar;
use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\TooltipService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class TooltipController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(public TooltipService $tooltipService)
    {}

    /**
     * Prepare and show an entity's tooltip
     */
    public function show(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        $tags = $entity->tags;
        $tagClasses = [];
        foreach ($tags as $tag) {
            $tagClasses[] = 'kanka-tag-' . $tag->id;
            $tagClasses[] = 'kanka-tag-' . $tag->slug;
        }
        $render = request()->get('render');
        $hasImage = Avatar::entity($entity)->hasImage();

        $tooltipText = $this->tooltipService->entity($entity)->campaign($campaign)->tooltip();

        $tooltip = view('entities.components.tooltip')
            ->with('campaign', $campaign)
            ->with('entity', $entity)
            ->with('tags', $entity->visibleTags)
            ->with('hasImage', $hasImage)
            ->with('tagClasses', $tagClasses)
            ->with('render', $render)
            ->with('tooltip', $tooltipText)
            ->render();

        return response()->json([
            $tooltip,
        ]);
    }
}

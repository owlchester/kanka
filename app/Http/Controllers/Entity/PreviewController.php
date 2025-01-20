<?php

namespace App\Http\Controllers\Entity;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\PreviewService;
use App\Services\Search\RecentService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class PreviewController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected PreviewService $service;
    protected RecentService $recentService;

    public function __construct(PreviewService $service, RecentService $recentService)
    {
        $this->service = $service;
        $this->recentService = $recentService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (auth()->check()) {
            $this->recentService
                ->campaign($campaign)
                ->user(auth()->user())
                ->logView($entity);
        }

        return response()->json(
            $this
                ->service
                ->entity($entity)
                ->campaign($campaign)
                ->preview()
        );
    }
}

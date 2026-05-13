<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Search\RecentService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class LogController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected RecentService $recentService) {}

    public function store(Campaign $campaign, Entity $entity): \Illuminate\Http\Response
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (auth()->check()) {
            $this->recentService
                ->campaign($campaign)
                ->user(auth()->user())
                ->logView($entity);
        }

        return response()->noContent();
    }
}

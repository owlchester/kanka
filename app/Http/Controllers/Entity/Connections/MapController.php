<?php

namespace App\Http\Controllers\Entity\Connections;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\Connections\MapService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class MapController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected MapService $service;

    public function __construct(MapService $mapService)
    {
        $this->service = $mapService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        $map = $this->service
            ->campaign($campaign)
            ->entity($entity)
            ->option(request()->get('option', null))
            ->map();

        return response()->json(
            $map
        );
    }
}

<?php

namespace App\Http\Controllers\Entity\Maps;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Maps\ExploreApiService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected ExploreApiService $apiService) {}

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        if (! $entity->isMap()) {
            abort(404);
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->map($entity->child)
                ->load()
        );
    }
}

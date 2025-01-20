<?php

namespace App\Http\Controllers\Entity\Attributes;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Attributes\ApiService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);
        $this->authorize('view-attributes', [$entity, $campaign]);

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->entity($entity)
                ->build()
        );
    }
}

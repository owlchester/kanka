<?php

namespace App\Http\Controllers\Attributes;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Services\Attributes\ApiService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    public function __construct(protected ApiService $apiService)
    {
    }

    public function index(Campaign $campaign, EntityType $entityType)
    {
        if (request()->has('source')) {
            $source = Entity::findOrFail((int) request()->get('source'));

            $this->apiService
                ->user(auth()->user())
                ->copy()
                ->entityType($entityType);

            return $this->entity($campaign, $source);
        }

        return response()->json(
            $this->apiService
                ->campaign($campaign)
                ->entityType($entityType)
                ->build()
        );
    }

    public function entity(Campaign $campaign, Entity $entity)
    {
        $this->campaign($campaign)->authEntityView($entity);

        // When copying an entity, the source might have private attributes, which blocks the attributes
        if (auth()->check() && auth()->user()->can('view-attributes', [$entity, $campaign])) {
            $this->apiService
                ->entity($entity);
        }

        return response()->json(
            $this->apiService
                ->user(auth()->user())
                ->campaign($campaign)
                ->build()
        );
    }
}

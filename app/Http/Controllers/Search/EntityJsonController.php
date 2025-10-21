<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Services\Entity\ExportService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\Request;

/**
 * Class EntityJsonController
 */
class EntityJsonController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected ExportService $service;

    public function __construct(ExportService $service)
    {
        $this->service = $service;
    }

    public function jsonSearch(Campaign $campaign, Request $request)
    {
        $entityId = $request->query('entity_id');

        // Fetch the entity or fail with 404
        $entity = Entity::findOrFail($entityId);

        // Authorize viewing this entity
        $this->campaign($campaign)->authEntityView($entity);

        // Delegate to the service
        return $this->service->entity($entity)->json();
    }
}

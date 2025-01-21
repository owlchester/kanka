<?php

namespace App\Http\Controllers\Families\Trees;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Entity;
use App\Models\Family;
use App\Services\Families\FamilyTreeService;
use App\Traits\CampaignAware;
use App\Traits\GuestAuthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    use CampaignAware;
    use GuestAuthTrait;

    protected FamilyTreeService $service;

    public function __construct(FamilyTreeService $service)
    {
        $this->service = $service;
    }

    /**
     * Provide the family tree info as a json
     */
    public function index(Campaign $campaign, Family $family): JsonResponse
    {
        $this->campaign($campaign)->authEntityView($family->entity);

        return response()->json(
            $this
                ->service
                ->campaign($campaign)
                ->family($family)
                ->api()
        );
    }

    /**
     * Provide the entity info as a json
     */
    public function entity(Campaign $campaign, Entity $entity): JsonResponse
    {
        if (empty($entity->child)) {
            abort(404);
        }
        $this->authorize('view', $entity);

        return response()->json(
            $this
                ->service
                ->entity($entity)
        );
    }

    /**
     * Save the new config
     */
    public function save(Request $request, Campaign $campaign, Family $family): JsonResponse
    {
        $this->authorize('update', $family->entity);

        return response()->json(
            $this
                ->service
                ->family($family)
                ->campaign($campaign)
                ->save($request->get('data'))
                ->api()
        );
    }
}

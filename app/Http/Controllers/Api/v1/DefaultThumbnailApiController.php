<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Middleware\Campaigns\Boosted;
use App\Http\Requests\Campaigns\DestroyDefaultThumbnail;
use App\Http\Requests\Campaigns\StoreDefaultThumbnail;
use App\Http\Resources\EntityDefaultThumbnailResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Services\Campaign\DefaultImageService;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DefaultThumbnailApiController extends ApiController
{
    public function __construct(
        EntitySaveService $entitySaveService,
        EntityRelationsServiceFactory $relationsFactory,
        protected DefaultImageService $defaultImageService,
    ) {
        parent::__construct($entitySaveService, $relationsFactory);
        $this->middleware(Boosted::class)->except('index');
    }

    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign->defaultImages());
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function upload(StoreDefaultThumbnail $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        /** @var EntityType $entityType */
        $entityType = EntityType::inCampaign($campaign)->find($request->post('entity_type_id'));
        $this->defaultImageService->campaign($campaign)
            ->user($request->user())
            ->entityType($entityType);
        if ($this->defaultImageService->save($request)) {
            return response()->json([
                'data' => 'Default thumbnail successfully uploaded',
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }

    /**
     * @throws AuthorizationException
     */
    public function delete(DestroyDefaultThumbnail $request, Campaign $campaign)
    {
        $this->authorize('recover', $campaign);

        /** @var EntityType $entityType */
        $entityType = EntityType::inCampaign($campaign)->find($request->post('entity_type_id'));
        $result = $this->defaultImageService
            ->campaign($campaign)
            ->user($request->user())
            ->entityType($entityType)
            ->destroy();

        if ($result) {
            return response()->json([
                'data' => 'Default thumbnail successfully deleted',
            ]);
        }

        return response()->json(['error' => 'Invalid input'], 422);
    }
}
